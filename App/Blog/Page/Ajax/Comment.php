<?php 
/**
 * 用户评论相关的ajax
 * @author cuihb
 * @since 2015-08-011
 */
class Blog_Page_Ajax_Comment extends Blog_Page_Abstract{
    public function __construct(LJL_Request $input, LJL_Response $output)
    {
        
    }
    public function validate(LJL_Request $input, LJL_Response $output)	{
        $output->subPageType = 'Ajax';
    
        if (!parent::baseValidate($input, $output)) {
            return false;
        }
        return true;
    }
    /**
     * 插入评论
     */
    public function doComment(LJL_Request $input, LJL_Response $output){
        $articleId = $input->post('articleId');
        $message   = $input->post('message');
        
        if(!Helper_Blogconfig::getUserInfo(array('username'=>urldecode($input->cookie('blog_username'))))){
            echo 'error';die;
        }
        $message = $this->ubbReplace($message);
        $touser = preg_match('/回复 (.*?):/', $message, $mathes) ? trim($mathes[1]) : '';
    	if($touser){
    	    $message = str_replace($mathes[0], '<a class="ds-comment-context">'.$mathes[0].'</a>', $message);
    	}
        $lastId = Helper_Blog::insertComment(array(
		        'insertData' =>  array(
		            'articleId' => $articleId,
		            'user'      => urldecode($input->cookie('blog_username')),
		            'touser'    => $touser,
		            'time'      => SYSTEM_TIME,
		            'comment'   => $message,
		        ), #array('name'=>'cuihb');
		    ));
        if($lastId)
            echo $message;die;
    }
    //顶
    public function doDing(LJL_Request $input, LJL_Response $output){
        $commentId = (int)$input->get('commentid');
        Helper_Blog::updateComment(array(
		        'commentid'   => $commentId,
		    ));
        exit();
    }
    private function ubbReplace($str){
        $facePath = LJL_Config::get(APP_NAME."_App", 'staticPath').'images/face';
        $str = str_replace("<",'&lt;',$str);
        $str = str_replace(">",'&gt;',$str);
        $str = str_replace("\n",'<br/>',$str);
        $str = preg_replace("[\[/表情([0-9]*)\]]","<img src=\"{$facePath}/$1.gif\" />",$str);
        return $str;
    }
}
?>
