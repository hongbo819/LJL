<?php
/**
 * 个人站首页，总站首页
 * @author cuihb
 * @since 2015-08
 */
class Blog_Page_Default extends Blog_Page_Abstract
{
    private $pageSize = 15;
    public function __construct(LJL_Request $input, LJL_Response $output)
	{
	    parent::__construct($input, $output);
	}
	public function validate(LJL_Request $input, LJL_Response $output)
	{
		$output->pageType = 'Default';

        if (!parent::baseValidate($input, $output)) {
            return false;
        }

		return true;
	}
	/**
	 * 个人站首页
	 */
    public function doDefault(LJL_Request $input, LJL_Response $output){
        LJL_Http::setExpires(3600);  #设置缓存时间
        $page = $input->get('page') ? intval($input->get('page')) : 1;
        //文章列表
        $articleList = Helper_Blog::getArticleList(array(
            'page'     => $page,
            'pageSize' => $this->pageSize,
            'fields'   => array('id', 'firstImgId', 'title', 'descript'),
        ));
        $articleCount = Helper_Blog::getArticleList(array(
            'isCount' => 1,
        ));
        
        //分页相关
        $totalPage = ceil($articleCount/$this->pageSize);
        $pageStr   = Libs_Global_Page::getPageString(array(
                 'page'      => $page,//当前页
                 'pageTotal' => $totalPage,//总页数
                 'urlClass'  => 'Blog_Plugin_Urls',//获取url的类
                 'urlFunc'   => 'getIndexUrl',//url方法
                 'args'      => array('page'=>$page),//传参
             ));
        $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
        
        //面包屑导航
        $nav[0]['title'] = '首页';
        $pageTitle = $page>1 ? '-第'.$page.'页' : '';
        //seo
        $output->seoArr = array('title' => BLOG_SEO_TITTLE.$pageTitle.'　| 最红博 ');
        
        $output->nav           = $nav;
        $output->cate          = '';
        $output->tag           = '';
        $output->cateList      = $cateList;
        $output->pageStr       = $pageStr;
        $output->articleList   = $articleList;
        
        $output->header        = $output->fetchCol("Part/Main/Header");
        $output->footer        = $output->fetchCol("Part/Main/Footer");
        $output->navbarTpl     = $output->fetchCol("Part/Navbar");
        $output->leftsideCate  = $output->fetchCol("Part/LeftsideCate");
        $output->navGuideTpl   = $output->fetchCol("Part/Navguide");
        $output->newArticleTpl = $output->fetchCol("Part/NewArticle");
        $output->searchTpl     = $output->fetchCol("Part/Search");
		$output->setTemplate('List');
	}
	/**
	 * 母站首页
	 */
	public function doHome(LJL_Request $input, LJL_Response $output){
	    //echo Blog_Plugin_Common::ckid('胡国庆');die;
	    //echo 111;die;
	    //setcookie('userProvinceId', 'aaa', SYSTEM_TIME + 86400, '/');
// 	    setcookie('userProvinceId2', 'aaa', SYSTEM_TIME + 86400, '/', '.zhbor.com');
// 	    die();
	    LJL_Http::setExpires(3600);
	    $nearTime = SYSTEM_TIME-30*24*3600;
	    //最热10篇
	    $hotList = Helper_Blogconfig::getBlogRankList(array(
		        'fields' => array('webSite', 'articleId', 'title', 'cate', 'cateVal', 'score', 'publishTime'),//要查询的字段
                        'pageSize' => 15,
		        'order'  => 'order by score desc',
	            'publishTime'  => $nearTime,
		    ));
	    if(count($hotList) < 10){
	        $hotList = Helper_Blogconfig::getBlogRankList(array(
		        'fields' => array('webSite', 'articleId', 'title', 'cate', 'cateVal', 'score', 'publishTime'),//要查询的字段
                        'pageSize' => 15,
		        'order'  => 'order by score desc',
		    ));
	    }
	    //最新10篇
	    $newList = Helper_Blogconfig::getBlogRankList(array(
	        'fields' => array('webSite', 'articleId', 'title', 'cate', 'cateVal', 'score', 'publishTime'),//要查询的字段
                'pageSize' => 15,
	        'order'  => 'order by publishTime desc',
	        'publishTime'  => $nearTime,
	    ));
	    if(count($newList) < 10){
	        $newList = Helper_Blogconfig::getBlogRankList(array(
    	        'fields' => array('webSite', 'articleId', 'title', 'cate', 'cateVal', 'score', 'publishTime'),//要查询的字段
                    'pageSize' => 15,
    	        'order'  => 'order by publishTime desc',
    	    ));
	    }
	    //推荐10篇
	    $recommendList = Helper_Blogconfig::getBlogRankList(array(
	        'fields' => array('webSite', 'articleId', 'title', 'descript', 'cate', 'cateVal', 'score', 'publishTime'),//要查询的字段
                'pageSize' => 10,
	        'order'  => 'order by isRecommend desc,score desc',
	    ));
	    //博主100个
	    $bloggerList = Helper_Blogconfig::getAdminList(array(
		        'page'     => 1,//当前页
		        'pageSize' => 100,//limit
		        'fields'   => array('webName', 'webSite'),//要查询的字段
		        'status'   => 1, //线上的项目状态为ok
		        'order'    => 'order by score desc',
		    ));
	    //自定义（关于本博1篇）
	    //seo
	    $output->seoArr = array('title' => BLOG_SEO_TITTLE.'　| 最红博 ');
	    
	    $output->pageType = 'webHome';
	    $output->hotList  = $hotList;
	    $output->newList  = $newList;
	    $output->recommendList = $recommendList;
	    $output->bloggerList   = $bloggerList;
	    $output->header = $output->fetchCol("Part/Main/Header");
	    $output->footer = $output->fetchCol("Part/Main/Footer");
	    $output->setTemplate('Home');
	}
	//404页面
	public function doShowerror(LJL_Request $input, LJL_Response $output){
	    LJL_Http::send404Header();
	    $output->setTemplate('404');
	}

}
