<?php
/**
* @version v1.0
* @todo 自动运行程序
* 抓取的文章进行发布处理(share项目)
* 每天凌晨进行发布，发布的文章时间是昨天 4-24点   确保solr程序可以捕获文章
*/

class Auto_Blog_Page_Publish extends Auto_Blog_Page_Abstract {
    private $website = 'blog_share';
    
    private $cate = ''; //指定发布的类别prolan,dbms,linux,jscss,fm,cloud,math,news
    private $tags = '';    //指定分类 cate 下标签
    
    private $pnum = 10; //每天每个分类下发布的文章数量10*7
   
    /**
     * 发布
     * 每天凌晨发布
     * 执行方式: php index.php server --c=Publish --a=Publisharticle
     */
    public function doPublisharticle(LJL_Request $input){
        $db = Db_Blog::instance(null, $this->website);
        $cateArr = LJL_Config::get('Blog_Share_Cate', 'CATE');
        foreach($cateArr as $cate=>$val){
            $this->cate = $cate;
            $this->tags = $this->getTag($cate);
            //echo $this->tags;die;
            $articleList = $this->getUnPublishList(1, $this->pnum);
            $this->publish($articleList);
            echo $cate.' is publish over~'.PHP_EOL;
            sleep(1);
        }
        exit();
    }
    /**
     * 作用是将descript字段里的htmlspecailchar给decode掉
     * 执行方式: php index.php server --c=Publish --a=Changedesc
     */
    public function doChangedesc(LJL_Request $input){
        $db = Db_Blog::instance(null, $this->website);
        $pageSize = 100;
        $count = $db->getOne("select count(*) from blog_article_info");
        $maxPage = ceil($count/$pageSize);
        for($page = 1; $page<=$maxPage; $page++){
            $limit = ' limit '.($page-1)*$pageSize.','.$pageSize;
            $sql = "select id,descript from blog_article_info $limit";
            $articleList = $db->getAll($sql);
            foreach($articleList as $val){
                Helper_Blog::updateArticleInfo(array(
                    'articleId'   => $val['id'],
                    'updateData'  =>  array(
                        'descript' => ' '.htmlspecialchars_decode($val['descript']).' ',
                    ), #array('name'=>'cuihb')
                ));
                //echo $val['id'].' over'.PHP_EOL;
            }
    
            sleep(1);
            echo 'page '.$page.' is change over~'.PHP_EOL;
        }
        exit();
    }
    
    /**
     * 将content里的href超链接全部去掉.已经跑过。之后抓的数据是过滤好的，不用再次跑了。
     * 执行方式: php index.php server --c=Publish --a=FilterHref
     */
    public function doFilterHref(){
        $db = Db_Blog::instance(null, $this->website);
        $pageSize = 50;
        $count = $db->getOne("select count(*) from blog_article_content");
        $maxPage = ceil($count/$pageSize);
        //$maxPage = 362;
        for($page=1; $page<=$maxPage; $page++){
            $limit = ' limit '.($page-1)*$pageSize.','.$pageSize;
            $sql = "select id,content from blog_article_content order by id asc $limit";
            //$sql = "select id,content from blog_article_content where articleId=38185";
            $articleList = $db->getAll($sql);
            foreach($articleList as $val){
                if(!$val['id']) continue;
                $content = stripslashes(htmlspecialchars_decode($val['content']));
                $content = htmlspecialchars(addslashes($this->filterHref($content)));
                $sql = "update blog_article_content set content='{$content}' where id={$val['id']}";
                $db->query($sql);
            }
            echo 'page is '.$page.' articlecount is '.$page*$pageSize.' is over~'.PHP_EOL;
            file_put_contents('/www/LJL/Auto/Blog/Page/publish.log', 'desc page is '.$page.' articlecount is '.$page*$pageSize." is over~\n", FILE_APPEND);
            sleep(1);
        }
        exit();
    }
    /**
     * 过滤文章超链接
     */
    private function filterHref($content){
        if(!$content) return;
        return preg_replace_callback("/<a[^>]+>([\S\s]+?)<\/a>/i",
            function($matchs){
                $str = $matchs[1];
                if(!$str) return '';
                $arr = array('www.','http://','https://','.com','.cn','.org','.net','.cc');
                foreach($arr as $k=>$v){
                    if(stripos($str,$v) !== false) return '';
                }
                return $str;
            },
            $content
        );
    }
    /**
     * 随机获取某个cate下面的某个标签
     */
    private function getTag($cate){
        $db = Db_Blog::instance(null, $this->website);
        if(!$cate) return;
        $sql = "SELECT tags FROM `blog_article_info` where isPublished=0 and cate='{$cate}' GROUP BY tags";
        $res = $db->getCol($sql);
        if(!$res) return '';
        shuffle($res);
        return $res[0];
    }
    /**
     * 修改文章状态，改变时间，进行发布
     */
    public function publish($articleIds){
        foreach((array)$articleIds as $aid){
            $publishTime = $this->getPubishTime();
            Helper_Blog::updateArticleInfo(array(
		        'articleId'   => $aid,
		        'updateData'  =>  array(
		            'insertTime' => $publishTime,
		            'updateTime' => $publishTime,
		            'isPublished'=> 1,
		        ), #array('name'=>'cuihb')
		    ));
        }
    }
    /**
     * 获取没有发布的文章的列表
     * @param unknown $page
     * @param unknown $pageSize
     * @return Ambigous <boolean, mixed>
     */
    private function getUnPublishList($page, $pageSize){
        $db = Db_Blog::instance(null, $this->website);
        $limit = ' limit '.($page-1)*$pageSize.','.$pageSize;
        $where = " where isPublished=0 ";
        if($this->cate)
            $where .= " and cate='{$this->cate}' ";
        if($this->tags)
            $where .= " and tags='{$this->tags}' ";
        $order = " order by id asc ";//其实现不用desc也行，这样前期的文章质量高，搜索引擎更喜欢
        $sql = "select id from blog_article_info {$where} {$limit}";
        return $db->getCol($sql);
    }
    /**
     * 获取昨天5-24点中任何一个时间戳
     */
    private function getPubishTime(){
        //今天5点的时间戳
        $time1 = strtotime(date('Y-m-d 04:00:00'));
        //到24点还需要多少秒
        $second = 19*60*60;
        //之间的一个随机时间
        $mt = mt_rand(0, $second);
        //今天减去一天24*60*60
        return $time1+$mt-86400;
    }
}
