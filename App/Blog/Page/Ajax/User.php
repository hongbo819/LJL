<?php 
/**
 * 用户登录相关的ajax
 * @author cuihb
 * @since 2015-08-04
 */
class Blog_Page_Ajax_User extends Blog_Page_Abstract{
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
    private function getSinaUserInfo(LJL_Request $input, LJL_Response $output){
        $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $tokenInfo = LJL_Api::run('Open.Sina.getLoginTokens' , array(
            'code'        =>$input->get('code'),
            'redirect_uri'=>$redirect_uri,
        ));
         
        $userInfo = LJL_Api::run('Open.Sina.getUserInfo' , array(
            'apiuid'      =>$tokenInfo['uid'],
            'accessToken' =>$tokenInfo['access_token'],
        ));
        
        $userMapInfo = array(
            'api_uid'     => $tokenInfo['uid'],
            'api_name'    => $userInfo['screen_name'],
            'api_headimg' => $userInfo['profile_image_url'],
            'api_token'   => $tokenInfo['access_token'],
            'api_type'    => 'sina',
            'expires_tm'  => $tokenInfo['expires_in'],
            'tm'          => SYSTEM_TIME,
        );
        $this->doRegister($input, $output, $userMapInfo);
    }
    /**
     * 显示登录
     */
    public function doShowLogin(LJL_Request $input, LJL_Response $output){
        if($input->get('code')){
            $this->getSinaUserInfo($input, $output);die;
        }
        $output->pageType = 'login';
        $output->fetchCol("Part/Login");
    }
    /**
     * 显示注册
     */
    public function doShowRegister(LJL_Request $input, LJL_Response $output){
        if($input->get('code')){
            $this->getSinaUserInfo($input, $output);die;
        }
        $output->pageType = 'register';
        $output->fetchCol("Part/Login");
    }
    /**
     * 执行注册
     */
    public function doRegister(LJL_Request $input, LJL_Response $output, $openUserInfo=null){
        $userName  = $input->post('username');
        $email     = $input->post('email');
        $password1 = $input->post('password1');
        $password2 = $input->post('password2');
        //第三方平台登录 sina
        if($openUserInfo){
            $email     = '';
            $userName  = $openUserInfo['api_name'];
            $password1 = $password2 = $openUserInfo['api_token'];
        }
        
        if(!$userName) $msg = '请填写用户名';
        if($password1 != $password2) $msg = '两次密码不一致';
        
        $appUserInfo = Helper_Blogconfig::getUserInfo(array('username'=>$userName));
        if(!$openUserInfo){
            if($appUserInfo)
                $msg = '用户名已经存在';
        }
        if(isset($msg)){ echo $msg;die; }
        
        $ipInfo = LJL_Http::ip2location(LJL_Http::getClientIp());
        $ckid = Blog_Plugin_Common::ckid($userName);
        
        if(!$appUserInfo){
            $lastId = Helper_Blogconfig::insertUser(array(
                'insertData' =>  array(
                    'username'     =>$userName,
                    'email'        => $email,
                    'password'     => Blog_Plugin_Common::password($password1),
                    'registerTime' => SYSTEM_TIME,
                    'registerIp'   => $ipInfo['ip'],
                    'registerAddr' => $ipInfo['country'],
                    'ckid'         => $ckid,
                ),
            ));
            if($lastId){ $msg = 'ok'; }
            
            //以下代码是以sina接口数据库打通
            if($openUserInfo){
                $openUserInfo['app_uid'] = $lastId;
                Helper_User::insertUserMap(array('insertData'=>$openUserInfo));
            }
            
            //以下代码是用户与聊天项目数据库打通
            Helper_User::insertChatuser(array(
                'insertData' => array(
                    'accountid' => $userName,
                    'username'  => $userName,
                    'dept'      => $ipInfo['country'],
                    'email'     => $email,
                    'deptDetail'=> $ipInfo['country'],
                    'updateTime'=> SYSTEM_TIME,
                ),
            ));
            
        }
	    setcookie('blog_username', urlencode($userName), SYSTEM_TIME+3600*24*30, '/', ".".Blog_Plugin_Common::getHost());
	    setcookie('blog_ckid', $ckid, SYSTEM_TIME+3600*24*30, '/', ".".Blog_Plugin_Common::getHost());
		
	    if($openUserInfo){
	        $goHistory = isset($_SERVER['HTTP_REFERER']) ? -1 : -2;
	        echo "<script>history.go({$goHistory})</script>";die;
	    }
	    
	    echo $msg;die;
    }
    /**
     * 执行登录
     */
    public function doLogin(LJL_Request $input, LJL_Response $output){
        $userName  = $input->post('username');
        $password = $input->post('password');
    
        if(!$userName) $msg = '请填写用户名';
        if(!$password) $msg = '请填写密码';
        
        if(preg_match('/@/', $userName)){
            $userInfo = Helper_Blogconfig::getUserInfo(array('email'=>$userName, 'password'=>md5($password.'_')));
        }else{
            $userInfo = Helper_Blogconfig::getUserInfo(array('username'=>$userName, 'password'=>md5($password.'_')));
        }
    
        if(!$userInfo)
            $msg = '用户不存在或密码错误';
    
        if(isset($msg)){ echo $msg;die; }
        $ipInfo = LJL_Http::ip2location(LJL_Http::getClientIp());
        //插入用户登录数据
        Helper_Blogconfig::insertLoginData(array(
            'insertData' =>  array(
                'username'     =>$userInfo['username'],
                'loginIp' => $ipInfo['ip'],
                'loginAddr' => $ipInfo['country'],
                'userAgent' => $_SERVER['HTTP_USER_AGENT'],
                'time' => SYSTEM_TIME,
            ),
        ));
        
        setcookie('blog_username', urlencode($userInfo['username']), SYSTEM_TIME+3600*24*30, '/', ".".Blog_Plugin_Common::getHost());
        setcookie('blog_ckid', Blog_Plugin_Common::ckid($userInfo['username']), SYSTEM_TIME+3600*24*30, '/', ".".Blog_Plugin_Common::getHost());
        
        if(Helper_Blogconfig::getAdminInfo(array('username'=>$userInfo['username'], 'password'=>md5($password.'_'), 'website'=>APP_BLOG_NAME))){
            setcookie('mda_', '@#%^&', SYSTEM_TIME+3600*24*30, '/');
            echo $userInfo['username'].'_ok_adm';die;
        }else{
            echo $userInfo['username'].'_ok';die;
        }
    }
    /**
     * 执行退出
     */
    public function doLoginout(LJL_Request $input, LJL_Response $output){
        setcookie('blog_username', '', SYSTEM_TIME-3600, '/', ".".Blog_Plugin_Common::getHost());
        setcookie('blog_ckid', '', SYSTEM_TIME-3600, '/', ".".Blog_Plugin_Common::getHost());
        setcookie('mda_', '', SYSTEM_TIME-3600, '/');
        exit();
    }
}
?>