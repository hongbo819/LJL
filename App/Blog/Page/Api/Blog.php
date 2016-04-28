<?php 
class Blog_Page_Api_Blog extends Blog_Page_Abstract
{
    private $pageSize=15;
    public function __construct(LJL_Request $input, LJL_Response $output)
    {
        parent::__construct($input, $output);
    }
    public function validate(LJL_Request $input, LJL_Response $output)
    {
         
        if (!parent::baseValidate($input, $output)) {
            return false;
        }
    
        return true;
    }
    
    public function doCate(LJL_Request $input, LJL_Response $output) 
    {
        $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
        foreach($cateList as $cate=>$val) {
            $cateList[$cate]['url'] = self::getListUrl(array('cate'=>$cate));
        }
        exit(json_encode($cateList));
    }
    public function doDetail(LJL_Request $input, LJL_Response $output)
    {
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
        $articleInfo['id'] = $articleId;
        exit(trim(json_encode($articleInfo)));
    }
    public function doList(LJL_Request $input, LJL_Response $output)
    {
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
        exit(json_encode($articleList));
    }
    
    
    public function getListUrl($paramArr) 
    {
        $options = array(
				'cate' => '', #
				'tag'  => '', #
				'page' => 1,
			);
			if (is_array($paramArr))$options = array_merge($options, $paramArr);
			
			$args = self::_formatQueryString($options);
			return WWW_WEB.'index.php?c=Api_Blog&a=List'.$args;
    }
    /**
     * 搜索字段格式化
     * date 2015-06-01
     * @author cuihb
     */
    private static function _formatQueryString($param){
        $returnStr  = '';
        if(is_array($param)){
            foreach($param as $key=>$val){
                if(!$val) continue;
                $returnStr .= '&'.$key.'='.$val;
            }
        }
        return $returnStr;
    }
}
?>