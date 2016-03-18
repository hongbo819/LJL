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
		    $articleCate = array(
    		        1 => array('php','PHP文章'),
    		        2 => array('linux','Linux文章'),
    		        3 => array('mysql','MySQL文章'),
		            4 => array('js' ,'JS相关文章'),
		            5 => array('jiagou','架构相关'),
		            6 => array('grow','随笔.生活'),
		            7 => array('tech','值得收藏'),
		            );
		    $db = Db_Blog::instance(null,'blog_cui');
		    
// 		    $logPath = APP_PATH.'/Page/Api/log.php';
// 		    file_put_contents($logPath, json_encode($db), FILE_APPEND);
            
		    $resieveMsg = LJL_Api::run('Open.Weixin.receiveMsg',array(
		        'subscribeCallback' => 'subscribe'
		    ));
		    
		    switch ((string)$resieveMsg['Content']){
		        case '1': 
		            $articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[1][0]));
		        break;
		        case '2':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[2][0]));
		            break;
		        case '3':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[3][0]));
		            break;
		        case '4':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[4][0]));
		            break;
		        case '5':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[5][0]));
		            break;
		        case '6':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[6][0]));
		            break;
		        case '7':$articleList = Helper_Blog::getArticleList(array('fields'=>array('id','title'), 'cate'=>$articleCate[7][0]));
		            break;
		        default:$articleList = null;
		    }
		    if($articleList){
		        $akey = array_rand($articleList);
		        $articleInfo = $articleList[$akey];
		        
		        $answer = "<a href='http://cui.zhbor.com/article/{$articleInfo['id']}.html'>{$articleInfo['title']}</a>";
		        //$answer = $articleInfo['title'].":".PHP_EOL."http://cui.zhbor.com/article/".$articleInfo['id'].".html";
		    }else{
		        $answer = '回复数字来找文章'.PHP_EOL;
		        $answer .= '1: PHP文章'.PHP_EOL;
		        $answer .= '2: Linux文章'.PHP_EOL;
		        $answer .= '3: MySQL文章'.PHP_EOL;
		        $answer .= '4: JS相关文章'.PHP_EOL;
		        $answer .= '5: 架构相关文章'.PHP_EOL;
		        $answer .= '6: 随笔.生活'.PHP_EOL;
		        $answer .= '7: 值得收藏'.PHP_EOL;
		        
		        
		    }
		    
		    $answer = LJL_Api::run('Open.Weixin.answerText',array(
		          'content' => $answer,
		    ));
		    echo $answer;die;
		}
	}
?>