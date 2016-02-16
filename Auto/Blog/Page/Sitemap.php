<?php
/**
* @version v1.0
* @todo 自动运行程序
*/

class Auto_Blog_Page_Sitemap extends Auto_Blog_Page_Abstract {
    private $sitemapIndexAddr = array();//存储sitemapindex文件
    private $stobj = null;//sitemap对象
    /**
     * 发布sitemap  每个项目下都有各自分类的sitemap，然后在总站有sitemapindex文件指向各个sitemap文件
     * 一天运行一次
     * 执行方式: php index.php server --c=Sitemap --a=Publishsitemap
     */
    public function __construct(){
        $this->stobj = Libs_Global_Sitemap::instance();
    }
    public function doPublishsitemap(LJL_Request $input){
        $pageSize = 10;
        $adminCount = Helper_Blogconfig::getAdminList(array('isCount'=>1));
        $maxPage = ceil($adminCount/$pageSize);
        for($page = 1; $page<=$maxPage; $page++){
            $adminList = Helper_Blogconfig::getAdminList(array(
                'page'     => $page,//当前页
                'pageSize' => $pageSize,//limit
                'fields'   => array('webSite'),//要查询的字段
                'status'   => 1, //线上的项目状态为ok
                'order'    => 'order by id',
            ));
            if($adminList){
                foreach($adminList as $APP_BLOG_NAME){
                    //写入sitemap
                    $this->makeSitemap('blog_'.$APP_BLOG_NAME['webSite']);
                    $this->saveasSitemapIndex('Blog_'.$APP_BLOG_NAME['webSite']);
                    $this->sitemapIndexAddr = array();
                    Db_Blog::destory();//清除实例
                    sleep(1);
                    echo 'blog_'.$APP_BLOG_NAME['webSite'].' sitemap is ok'.PHP_EOL;
                }
            }
            sleep(1);
        }
        exit();
    }
    /**
     * 形成sitemap文件
     * @param $database 项目名
     * @param $catekey 分类
     * @param $num 某个分类下超过5000个则会有多个文件
     */
    private function saveasSiemap($database, $catekey, $num=''){
        $website = substr($database, 5);
        //sitemapindex 地址
        $this->sitemapIndexAddr[$database.'_'.$catekey] = 'http://'.$website.'.'.MAIN_PAGE.'/sitemap/'.$catekey.$num.'.xml';
        //写入sitemap
        $this->stobj->sitemap("/www/LJL/Html/".ucfirst($database)."/sitemap/".$catekey.$num.".xml");
        echo $database.' cate '.$catekey.' sitemap over'.PHP_EOL;
    }
    /**
     * 形成sitemap索引文件
     */
    public function saveasSitemapIndex($subject){
        //形成sitemap索引文件
        foreach($this->sitemapIndexAddr as $sitemapindex){
            $this->stobj->sitemapItem($sitemapindex);
        }
        $this->stobj->sitemapIndex("/www/LJL/Html/{$subject}/sitemap.xml");
    }
    
    /**
     * 各子站sitemap写入
     */
    private function makeSitemap($database){
        //列表页url
        $this->makeListPage($database);
    }
    //生成每个分类下的sitemap
    private function makeListPage($database){
        $website = substr($database, 5);
        $cate    = LJL_Config::get('Blog_'.ucfirst($website).'_Cate', 'CATE');
        foreach((array)$cate as $catekey=>$val){
            $this->stobj->urlItem('http://'.$website.'.'.MAIN_PAGE.'/list/'.$catekey.'/1/', '0.8');
            $this->makeDetailPage($database, $catekey);
        }
    }
    //组装每个分类下的 详情页url
    private function makeDetailPage($database, $catekey){
        if(!$catekey) return;
        Db_Blog::instance(null, $database);
        $website = substr($database, 5);
        //获取文章总数
        $count = Helper_Blog::getArticleList(array('isCount'=>1));
        $page = 1; $pageSize = 100;
        $totalPage = ceil($count/$pageSize);
        while($totalPage >= $page){
            $articleInfo = Helper_Blog::getArticleList(array(
                'page'     => $page,//当前页
                'pageSize' => $pageSize,//limit
                'fields'   => array('id'),//要查询的字段
                'isPublished' => 1,
                'cate'     => $catekey,
            ));
            if($articleInfo){
                foreach($articleInfo as $val){
                    $this->stobj->urlItem('http://'.$website.'.'.MAIN_PAGE.'/article/'.$val['id'].'.html');
                }
            }
            $page++;
            
            if(($page*$pageSize)%5000==0)//每5000条生成新的sitemap文件
                $this->saveasSiemap($database, $catekey, $page);
            
            if($page%10===0)//每10页sleep
                sleep(1);
        }
        
        $this->saveasSiemap($database, $catekey);
    }
}