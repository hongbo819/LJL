<?php
    /**
     * 微信api
     * @author cuihb
     * @since 2015-11-27
     */
	class Blog_Page_Api_Weixin extends Blog_Page_Abstract{
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
		/**
		 * 微信信息接口 http://www.zhbor.com/index.php?c=Api_Weixin&a=Weixin
		 * 
		 * 接口实现用户回复数字 返回数字对应的分类文章的url 关注微信 爱科技：hongbozxz
		 */
		public function doWeixin(LJL_Request $input, LJL_Response $output){
		    $articleCate = self::_getCate();
		    $db = Db_Blog::instance(null,'blog_cui');
		    
// 		    $logPath = APP_PATH.'/Page/Api/log.php';
// 		    file_put_contents($logPath, json_encode($db), FILE_APPEND);
		   
		    $resieveMsg = LJL_Api::run('Open.Weixin.receiveMsg',array(
		        'subscribeCallback' => 'subscribe'
		    ));
		    $content = (string)$resieveMsg['Content'];
		    
		    //错误关键字 回复提示信息
		    if(!is_numeric($content))
		        self::_notice();
		    
		    $classid = substr($content, 0, 1);
		    $page    = substr($content, 1) ? substr($content, 1) : 1;
		    //限制分类
		    if($classid > 7 || $classid < 1)
		        $this->_notice();
		        
		    $articleList = Helper_Blog::getArticleList(array(
		            'fields'  =>array('id','firstImgId','title','descript'),
		            'page'    =>$page,
		            'pageSize'=>5,
		            'cate'    =>$articleCate[$classid][0]
		          ));
		    if($articleList){
		        self::_articleList($articleList);
		    } else {
		        self::_noArticle($classid, $page);
		    }
		}
		/**
		 * 返回文章列表
		 */
		private function _articleList($articleList) {
		    $params = array();;
		    foreach($articleList as $article) {
		        $url      = 'http://cui.zhbor.com/article/'.$article['id'].'.html';
		        $imgSrc   = $article['firstImgId'] ? self::_getImgSrc($article['firstImgId']) : '';
		        $params[] = array(
		            'Title'       =>$article['title'],
		            'Description' =>$article['descript'],
		            'PicUrl'      =>$imgSrc,
		            'Url'         => $url,
		          );
		    }
		    echo LJL_Api::run('Open.Weixin.answerList',array(
		        'dataArr' => $params,
		    ));die();
		}
		/**
		 * 获取文章图片src
		 */
		private function _getImgSrc($imgId) {
		    $imgInfo = Helper_Blog::getPicInfo(array('picId'=>$imgId));
		    return Helper_Blog::getPicWebPath(array(
		        'imgName'=>$imgInfo['picName'],
		        'imgExt'=>$imgInfo['picExt'],
		        'time'=>$imgInfo['time'],
		        'rootdir' => UPLOAD_IMG_PATH.'blog_cui/',
		        'size' => ''
		    ));
		}
		/**
		 * 无文章提示
		 */
		private function _noArticle($classid, $page) {
		    $articleCate = self::_getCate();
		    $answer .= $articleCate[$classid][1].'总页数 小于'.$page.'直接输入 '.$classid.' 试试'.PHP_EOL;
		    echo LJL_Api::run('Open.Weixin.answerText',array(
		        'content' => $answer,
		    ));die();
		}
		/**
		 * 输入错误关键字后给出提示信息
		 */
		private function _notice() {
		    $answer  = '1: PHP文章 '.PHP_EOL;
		    $answer .= '2: Linux文章'.PHP_EOL;
		    $answer .= '3: MySQL文章'.PHP_EOL;
		    $answer .= '4: JS相关文章'.PHP_EOL;
		    $answer .= '5: 架构相关文章'.PHP_EOL;
		    $answer .= '6: 随笔.生活'.PHP_EOL;
		    $answer .= '7: 值得收藏'.PHP_EOL;
		    $answer .= '----------------------------'.PHP_EOL;
		    $answer .= '回复数字来找文章,例如:'.PHP_EOL;
		    $answer .= '12代表第1类文章的第2页'.PHP_EOL;
		    echo LJL_Api::run('Open.Weixin.answerText',array(
		        'content' => $answer,
		    ));die();
		}
		/**
		 * 文章分类
		 */
		private function _getCate() {
		    return array(
        		        1 => array('php','PHP文章'),
        		        2 => array('linux','Linux文章'),
        		        3 => array('mysql','MySQL文章'),
    		            4 => array('js' ,'JS相关文章'),
    		            5 => array('jiagou','架构相关'),
    		            6 => array('grow','随笔.生活'),
    		            7 => array('tech','值得收藏'),
		            );
		}
	}
?>