<?php
    /**
     * 列表页
     * @author cuihb
     * @since 2015-09
     */
	class Blog_Page_List extends Blog_Page_Abstract{
	    private $pageSize=15;
    	public function __construct(LJL_Request $input, LJL_Response $output)
    	{
    	    parent::__construct($input, $output);
    	}
		public function validate(LJL_Request $input, LJL_Response $output)
		{
			$output->pageType = 'List';
	
	        if (!parent::baseValidate($input, $output)) {
	            return false;
	        }
	
			return true;
		}
        public function doDefault(LJL_Request $input, LJL_Response $output){
            //http://cuihongbo.com/index.php?c=list&a=default&cate=php
            //http://cuihongbo.com/index.php?c=list&a=default&cate=php&tag=%E5%AE%89%E5%85%A8%E9%97%AE%E9%A2%98
            LJL_Http::setExpires(3600);  #设置缓存时间
            $page = $input->get('page') ? intval($input->get('page')) : 1;
            $cate = $input->get('cate');
            //与搜索标签方法融合
            $tag  = $input->get('tag') ? urldecode(trim($input->get('tag'))) :  urldecode(trim($input->get('keyword')));
            
            $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
            //文章列表
            $articleList = Helper_Blog::getArticleList(array(
                'page'     => $page,
                'pageSize' => $this->pageSize,
                'fields'   => array('id', 'firstImgId', 'title', 'descript'),
                'cate'     => $cate,
                'tag'      => $tag,
            ));
            //var_dump(1111);die;
            $articleCount = Helper_Blog::getArticleList(array(
                'isCount' => 1,
                'cate'    => $cate,
                'tag'     => $tag,
            ));
            
            //分页相关
            $totalPage = ceil($articleCount/$this->pageSize);
            if($page > $totalPage && $page > 1){
                LJL_Http::send404Header();
                $output->setTemplate('404'); return;
            }
            $pageStr   = Libs_Global_Page::getPageString(array(
                'page'      => $page,//当前页
                'pageTotal' => $totalPage,//总页数
                'urlClass'  => 'Blog_Plugin_Urls',//获取url的类
                'urlFunc'   => 'getListUrl',//url方法
                'args'      => array('page'=>$page, 'cate'=>$cate, 'tag'=>$tag),//传参
            ));
            
            //获取各分类下tag标签
            if($cateList){
                $tagsArr = [];
                foreach($cateList as $cateKey=>$cateV){
                    $tagsArr[$cateKey] = Helper_Blog::getTags(array('cate'=>$cateKey,'limit'=>40));
                }
            }
            
            //面包屑导航
            $nav[0]['title'] = '首页';
            $nav[0]['url'] = WWW_WEB;
            if(!$cate){
		        $nav[1]['title'] = $tag ? $tag : '全部';
		    }else{
		        $nav[1]['title'] = $cateList[$cate][0];
		        if($tag){
		            $nav[1]['url'] = Blog_Plugin_Urls::getListUrl(array('cate'=>$cate));
		            $nav[2]['title'] = $tag;
		        }
		    }
		    
		    //seo
		    $seoTitle = $cate ? ($tag ? $cateList[$cate][0].'分类 - '.$tag.'标签' : $cateList[$cate][0].'分类'): $tag.'标签';
		    $output->seoArr = array('title' => $seoTitle.'-第'.$page.'页 － '.BLOG_SEO_TITTLE.'　| 最红博 ');
            
            $output->tagsArr       = $tagsArr;
            $output->cate          = $cate;
            $output->tag           = $tag;
            $output->nav           = $nav;
            $output->cateList      = $cateList;
            $output->pageStr       = $pageStr;
            $output->articleList   = $articleList;
            
            $output->header     = $output->fetchCol("Part/Main/Header");
            $output->footer     = $output->fetchCol("Part/Main/Footer");
            $output->navbarTpl     = $output->fetchCol("Part/Navbar");
            $output->leftsideCate  = $output->fetchCol("Part/LeftsideCate");
            $output->navGuideTpl   = $output->fetchCol("Part/Navguide");
            $output->newArticleTpl = $output->fetchCol("Part/NewArticle");
            $output->searchTpl     = $output->fetchCol("Part/Search");
			$output->setTemplate('List');
		}
		/**
		 * 搜索
		 */
		public function doSearch(LJL_Request $input, LJL_Response $output){
		    $output->type = $type  = $input->get('type');
		    
		    if($type === 'tags')
		        $this->doDefault($input, $output);
		    else
		        $this->_fulltextSearch($input, $output);
		}
		public function doList(LJL_Request $input, LJL_Response $output){
			$output->setTemplate('list');
		}
		
		private function _fulltextSearch($input, $output){
		    LJL_Http::setExpires(3600);  #设置缓存时间
		    $tag = $keyword = trim($input->get('keyword'));
		    $page    = $input->get('page') ? intval($input->get('page')) : 1;
		    $start   = ($page-1)*$this->pageSize;
		    
		    $query = array(
		        'q'     => $keyword ? $keyword : '*',
		        'wt'    => 'json',
		        'rows'  => $this->pageSize,
		        'start' => $start,
		        'hl'    => 'true',
		        'hl.fl' => 'title,descript',
		        "hl.simple.pre" => '<font color="red">',
		        "hl.simple.post" => '</font>',
		    );
		    $solrServer = LJL_Config::get('Blog_Solr', 'SOLR');
		    $url = $solrServer['url'].'/select?'.http_build_query($query);
		    //echo $url;die;
		    $solrRes = LJL_Http::curlPage(array(
				'url'      => $url, #要请求的URL数组
				'timeout'  => 5,#超时时间 s
			));
		    $searchRes = json_decode($solrRes, true);
		    //var_dump($searchRes);
		    
		    $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
		    //文章列表
		    $articleList = $searchRes['response']['docs'];
		    $articleCount= $searchRes['response']['numFound'];
		    $articleHl   = $searchRes['highlighting'];
		    unset($searchRes);
		    
		    //组织高亮部分
		    //var_dump($articleHl);die;
		    foreach((array)$articleList as $akey=>$aval){
		        if(key_exists($aval['id'], $articleHl)){
		            if(isset($articleHl[$aval['id']]['title']))
		                $articleList[$akey]['title'] = $articleHl[$aval['id']]['title'][0];
		            if(isset($articleHl[$aval['id']]['descript']))
		                $articleList[$akey]['descript'] = $articleHl[$aval['id']]['descript'][0];
		        }
		    }
		    
		    //分页相关
		    $totalPage = ceil($articleCount/$this->pageSize);
		    $pageStr   = Libs_Global_Page::getPageString(array(
		        'page'      => $page,//当前页
		        'pageTotal' => $totalPage,//总页数
		        'urlClass'  => 'Blog_Plugin_Urls',//获取url的类
		        'urlFunc'   => 'getSearchUrl',//url方法
		        'args'      => array('type'=>$input->get('type'), 'keyword'=>$keyword, 'page'=>$page),//传参
		    ));
		    
		    //获取各分类下tag标签
		    if($cateList){
		        $tagsArr = [];
		        foreach($cateList as $cateKey=>$cateV){
		            $tagsArr[$cateKey] = Helper_Blog::getTags(array('cate'=>$cateKey));
		        }
		    }
		    
		    //面包屑导航
		    $nav[0]['title'] = '首页';
		    $nav[0]['url'] = WWW_WEB;
		    $nav[1]['title'] = $keyword;
		    
		    //seo
		    $output->seoArr = array('title' => $keyword.'搜索-第'.$page.'页  － '.BLOG_SEO_TITTLE.'　| 最红博 ');
		    
		    $output->tagsArr       = $tagsArr;
		    $output->tag           = $keyword;
		    $output->cate          = '';
		    $output->nav           = $nav;
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
	}
?>
