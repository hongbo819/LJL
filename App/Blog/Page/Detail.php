<?php
    /**
     * 详情页
     * @author cuihb
     * @since 2015-09
     */
	class Blog_Page_Detail extends Blog_Page_Abstract{
    	public function __construct(LJL_Request $input, LJL_Response $output)
    	{
    	    parent::__construct($input, $output);
    	}
		public function validate(LJL_Request $input, LJL_Response $output)
		{
			$output->pageType = 'Detail';
	
	        if (!parent::baseValidate($input, $output)) {
	            return false;
	        }
	
			return true;
		}
        public function doDefault(LJL_Request $input, LJL_Response $output){
            //http://hongbo.com/index.php?c=detail&a=default&articleid=67
            LJL_Http::setExpires(3600);  #设置缓存时间
            
            $articleId = $input->get('articleid');
            $articleInfo = Helper_Blog::getArticleInfo(array(
		        'articleId' => $articleId, #文章id
		        'fileds'    =>  array(
		            'firstImgId',
		            'cate',
		            'title',
		            'descript',
		            'tags',
		            'source',
		            'insertTime',
		            'view',
		            'content',
		        ), #要查询的字段
		    ));
            if(count($articleInfo)<5){
                LJL_Http::send404Header();
                $output->setTemplate('404'); return;
            }
            $articleInfo['id'] = $articleId;
            $articleInfo['content'] = str_replace('img.cuihongbo', 'img.zhbor', $articleInfo['content']);
            $articleTags = explode(',', $articleInfo['tags']);
            
            $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
            
            $prevNext = Helper_Blog::getPreNextArticle(array('articleId'=>$articleId,'fileds'=>array('id','title')));
            $prevNext = $this->formatPrevNext($prevNext);
            
            //面包屑导航
            $nav[0]['title'] = '首页';
            $nav[0]['url']   = WWW_WEB;
            $nav[1]['title'] = $cateList[$articleInfo['cate']][0];
            $nav[1]['url']   = Blog_Plugin_Urls::getListUrl(array('cate'=>$articleInfo['cate']));
            $nav[2]['title'] = $articleInfo['title'];
            
            //seo
            $output->seoArr = array(
                'title' => $articleInfo['title'].' － '.BLOG_SEO_TITTLE.'　| 最红博',
                'description' => $articleInfo['descript'],
                'keywords' => implode(',', $articleTags),
            );
            
            $output->cateList      = $cateList;
            $output->articleInfo   = $articleInfo;
            $output->articleTags   = $articleTags;
            $output->prevNext      = $prevNext;
            $output->nav           = $nav;
            $output->cate          = $articleInfo['cate'];
            
            $output->header     = $output->fetchCol("Part/Main/Header");
            $output->footer     = $output->fetchCol("Part/Main/Footer");
            $output->navbarTpl     = $output->fetchCol("Part/Navbar");
            $output->leftsideCate  = $output->fetchCol("Part/LeftsideCate");
            $output->navGuideTpl   = $output->fetchCol("Part/Navguide");
            $output->newArticleTpl = $output->fetchCol("Part/NewArticle");
            $output->commentTpl    = $output->fetchCol("Part/Comment");
            $output->searchTpl     = $output->fetchCol("Part/Search");
			$output->setTemplate('Detail');
		}
		
		public function doList(LJL_Request $input, LJL_Response $output){
			//$output->setTemplate('Detail');
		}
		
		/**
		 * 对前后文章数据进行组织
		 */
		private function formatPrevNext($prevNext){
		    if(!is_array($prevNext)) return false;
		    $out = array();
		    foreach($prevNext as $pkey=>$pN){
		        if(is_array($pN)){
		            if(!$pN) $out[$pkey] = array();
		            foreach($pN as $key=>$val){
                        $out[$pkey][$key]['title'] = $val['title'];
                        $out[$pkey][$key]['url']   = Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$val['id']));
		            }
		        }
		    }
		    return $out;
		}
	}
?>