<?php
/**
* @version v1.0
* @todo 自动运行程序
* 1、文章导入solr
* 2、发布文章标签到标签表
*/

class Auto_Blog_Page_Import extends Auto_Blog_Page_Abstract
{
    /**
     * 所有项目文章导入solr
     * 一天运行一次
     * 执行方式: php index.php server --c=Import --a=Article
     */
    public function doArticle(LJL_Request $input){
        $solrServer = LJL_Config::get('Blog_Solr', 'SOLR');
    
        $pageSize = 10;
        $adminCount = Helper_Blogconfig::getAdminList(array('isCount'=>1));
        $maxPage = ceil($adminCount/$pageSize);
        for($page = 1; $page<=$maxPage; $page++){
            $adminList = Helper_Blogconfig::getAdminList(array(
                'page'     => $page,//当前页
                'pageSize' => $pageSize,//limit
                'fields'   => array('webSite'),//要查询的字段
                'status'   => 1, //线上的项目状态为ok
                'order'    => 'order by id desc',
            ));
            if($adminList){
                foreach($adminList as $APP_BLOG_NAME){
                    $this->importArticle($APP_BLOG_NAME['webSite'], $solrServer['url']);
                }
            }
            sleep(1);
        }
        exit();
    }
   /**
    * 发布最近需要发布的信息1、导入标签2、更新博主排行3、更新最新，最热博文
    * 一天运行一次
    * 执行方式: php index.php server --c=Import --a=Publishblog  --day=发布前几天,如果不填则自动按照上次发布之后的时间
    */
    public function doPublishblog(LJL_Request $input){
        $pageSize = 10;
        $adminCount = Helper_Blogconfig::getAdminList(array('isCount'=>1));
        $maxPage = ceil($adminCount/$pageSize);
        for($page = 1; $page<=$maxPage; $page++){
            $adminList = Helper_Blogconfig::getAdminList(array(
                'page'     => $page,//当前页
                'pageSize' => $pageSize,//limit
                'fields'   => array('webSite'),//要查询的字段
                'status'   => 1, //线上的项目状态为ok
                'order'    => 'order by id desc',
            ));
            if($adminList){
                foreach($adminList as $APP_BLOG_NAME){
                    //导入标签
                    $this->importTag($input, 'blog_'.$APP_BLOG_NAME['webSite']);
                    //更新博主排行
                    $this->updateBloggerRank('blog_'.$APP_BLOG_NAME['webSite']);
                    //更新最新、最热博文
                    $this->updateTopNewBlog('blog_'.$APP_BLOG_NAME['webSite']);
                    Db_Blog::destory();//清除实例
                }
            }
            sleep(1);
        }
        exit();
    }
    /**
     * 更新博主排行
     */
    private function updateBloggerRank($database){
        $db = Db_Blog::instance(null, $database);
        //获取文章数量
        $articleCount = Helper_Blog::getArticleList(array(
		        'isPublished' => 1,
		        'isCount'     => 1, //是否是查询总数
		    ));
        //获取评论数量
        $commentCount = Helper_Blog::getCommentsList(array());
        //获取文章总观看数量
        $sql = "SELECT SUM(view) FROM blog_article_info";
        $viewNum = $db->getOne($sql);
        Helper_Blogconfig::updateAdminInfo(array(
		        'webSite'   => str_replace('blog_', '', $database),
		        'updateData'  =>  array(
		            'articleNum' => $articleCount,
		            'commentNum' => $commentCount,
		            'viewNum'    => $viewNum,
		            'score'      => $articleCount*20+$commentCount*5+$viewNum,
		        ), #array('name'=>'cuihb')
		    ));
        echo $database.' blogger rank over'.PHP_EOL;
    }
    /**
     * 更新 最新最热 博文列表  每个博主下各抽取5条，最新的、最热的
     * 推荐的文章也是依据这个表，会依据 表中的推荐权重字段
     */
    private function updateTopNewBlog($database){
        $db = Db_Blog::instance(null, $database);
        //最新5篇
        $newList = Helper_Blog::getArticleList(array(
		        'pageSize'    => 5,//limit
                'isPublished' => 1,
		        'fields'      => array('id', 'view', 'cate', 'title', 'descript', 'insertTime'),//要查询的字段
		        'order'       => 'order by insertTime desc',
		    ));
        //最热5篇
        $hotList = Helper_Blog::getArticleList(array(
		        'pageSize'    => 5,//limit
                'isPublished' => 1,
		        'fields'      => array('id', 'view', 'cate', 'title', 'descript', 'insertTime'),//要查询的字段
		        'order'       => 'order by view desc',
		    ));
        if(is_array($newList) && is_array($hotList)){
            $newHotList = array_merge($newList, $hotList);
            $webSite = str_replace('blog_', '', $database);
            foreach($newHotList as $articleInfo){
                //查询推荐权重
                $isRecommend = Helper_Blogconfig::getArticleInfo(array(
    		        'articleId' => $articleInfo['id'], #文章id
    		        'webSite'   => $webSite,#博客站
    		        'fileds'    =>  array('isRecommend'), #要查询的字段
    		    ));
                $isRecommend = $isRecommend['isRecommend'] ? $isRecommend['isRecommend'] : 0;
                Helper_Blogconfig::insertHotnew(array(
    		        'insertData' =>  array(
    		            'webSite'     => $webSite,
    		            'articleId'   => $articleInfo['id'],
    		            'title'       => $articleInfo['title'],
    		            'descript'    => $articleInfo['descript'],
    		            'cate'        => $articleInfo['cate'],
    		            'cateVal'     => LJL_Config::get('Blog_'.ucfirst($webSite).'_Cate', 'CATE')[$articleInfo['cate']][0],
    		            'view'        => $articleInfo['view'],
    		            'score'       => $articleInfo['view'],
    		            'publishTime' => $articleInfo['insertTime'],
    		            'isRecommend' => $isRecommend,
    		        ), #array('name'=>'cuihb');
    		    ));
            }
        }
        echo $database.' hot and new blog publish over'.PHP_EOL;
    }
    
    /**
     * 导入标签,如果指定了天数，则就从指定前几天，如果没有指定天数，则从上一次插入的时间开始
     * @param LJL_Request $input
     * @param unknown $database
     */
	private function importTag(LJL_Request $input, $database){
	    $db = Db_Blog::instance(null, $database);
	    if($input->get('day')){
	        $day = $input->get('day') ? $input->get('day') : 1;//默认1天
	        $fromInsertTime =SYSTEM_TIME - $day*24*3600;
	    }else{
	        $sql = "select updateTime from blog_tags order by id desc limit 1";
	        $fromInsertTime = $db->getOne($sql);
	        $fromInsertTime = $fromInsertTime ? $fromInsertTime : 0;
	    }
	    
	    //获取总数
	    $sql = "select count(*) from blog_article_info where isPublished=1 and updateTime>{$fromInsertTime}";
	    $count = $db->getOne($sql);
	    
	    $page = 1;
	    $pageSize = 100;
	    $totalPage = ceil($count/$pageSize);
	    
	    while($totalPage >= $page){
	        $articleInfo = Helper_Blog::getArticleList(array(
	            'page'     => $page,//当前页
	            'pageSize' => $pageSize,//limit
	            'fields'   => array('id','cate','tags'),//要查询的字段
	            'updateTime' => $fromInsertTime,
	        ));
	        
	        if($articleInfo){
	            foreach($articleInfo as $val){
	                if(!$val['tags']) continue;
	                $tagArr = explode(',', trim(trim($val['tags'],' '),','));
	                foreach($tagArr as $tag){
	                    Helper_Blog::insertTag(array(
	                        'insertData'=>array(
	                            'articleId' => $val['id'],
	                            'cate'      => $val['cate'],
	                            'tag'       => $tag,
	                            'updateTime'=> SYSTEM_TIME,
	                        ),
	                    ));
	                }
	            }
	        }
	        $page++;
	    }
	    echo $database.' tags import over'.PHP_EOL;
    }
    private function importArticle($webSite, $solrUrl){
        //15.28.237.52:8983/solr/cui_blog/dataimport?command=delta-import&clean=false&commit=true
        $importUrl = str_replace('xxx', $webSite, $solrUrl);
        $importUrl .= '/dataimport?command=delta-import&clean=false&commit=true';
        LJL_Http::curlPage(array(
            'url'      => $importUrl, #要请求的URL数组
            'timeout'  => 5,#超时时间 s
        ));
    }
    /**
     * 删除 在数据库中已经删除的数据，但是还存在于solr中的数据
     * 之后有需求的时候可能会用到
     * 尽量不要删、个别要求、个别处理就行
     */
    private function deleteFormSolr(){
        //http://115.28.237.52:8983/solr/cui_blog/update/?stream.body=<delete><id>68</id></delete>&stream.contentType=text/xml;charset=utf-8&commit=true
    }
}
