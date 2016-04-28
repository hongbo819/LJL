<?php 
class Blog_Page_Api_Blog extends Blog_Page_Abstract
{
    private $pageSize=5; 
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
    
    public function doCatejson(LJL_Request $input, LJL_Response $output) 
    {
        $cateList = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
        $cateList['meinv'] = array('美女'); 
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
        $articleInfo['content'] = htmlspecialchars_decode($articleInfo['content']);
        exit(trim(json_encode($articleInfo)));
    }
    public function doList(LJL_Request $input, LJL_Response $output)
    {
        $page = $input->get('page') ? intval($input->get('page')) : 1;
        $cate = $input->get('cate');
        $articleList = array();
        //与搜索标签方法融合
        $tag  = $input->get('tag') ? urldecode(trim($input->get('tag'))) :  urldecode(trim($input->get('keyword')));
        if($cate === 'meinv') {
            $arr = array('清纯美女','美女','性感美女', '模特', '美女写真', '长腿美女', '大胸美女', '人体模特');
            shuffle($arr);
            $url = 'http://image.baidu.com/search/index?tn=baiduimage&word='.array_pop($arr);
            //$url = 'https://www.baidu.com';
            $content = file_get_contents($url);
            preg_match_all('/hoverURL\"\:\"(.*?)\"/is', $content, $mathes);
            shuffle($mathes[1]);
            $outArr = array_slice($mathes[1], 1, 5);
            foreach ((array)$outArr as $key=>$src) {
                $articleList[$key]['src'] = $src;
            }
            exit(json_encode($articleList));
        }
        //文章列表
        $articleList = Helper_Blog::getArticleList(array(
            'page'     => $page,
            'pageSize' => $this->pageSize,
            'fields'   => array('id', 'firstImgId', 'title', 'descript'),
            'cate'     => $cate,
            'tag'      => $tag,
        ));
        if(is_array($articleList)) {
            foreach($articleList as $key=>$val) {
                if(!$val['firstImgId']) {
                    $articleList[$key]['src'] = ''; continue;
                }
                $imgInfo = Helper_Blog::getPicInfo(array('picId'=>$val['firstImgId']));
                $articleList[$key]['src'] =  Helper_Blog::getPicWebPath(array(
    					              		        'imgName'=>$imgInfo['picName'],
    					              		        'imgExt'=>$imgInfo['picExt'],
    					              		        'time'=>$imgInfo['time'],
    					              		        'rootdir' => UPLOAD_IMG_PATH.'blog_'.APP_BLOG_NAME.'/',
    					              		        'size' => '110x66_'
    					              		    ));
            }
        }
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