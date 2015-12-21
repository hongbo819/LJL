<?php
    /**
     * 博客申请页面
     * @author cuihb
     * @since 2015-9-15
     */
	class Blog_Page_Apply extends Blog_Page_Abstract{
		public function __construct(LJL_Request $input, LJL_Response $output)
		{
		    parent::__construct($input, $output);
		}
		public function validate(LJL_Request $input, LJL_Response $output)
		{
			$output->pageType = 'Apply';
	        
	        if (!parent::baseValidate($input, $output)) {
	            return false;
	        }
	
			return true;
		}
		public function doHome(LJL_Request $input, LJL_Response $output){
		    $error = 0;
		    if(!$input->post('submit')){
		        $output->error = $error;
		        $output->setTemplate('Apply');return;
		    }
		    
		    $webName = $input->post('webName');
		    $adminName = $input->post('adminName');
		    $adminPassword = $input->post('adminPassword');
		    $webDesc = $input->post('webDesc');
		    $webSite = $input->post('webSite');
		    $weiboUid = $input->post('weiboUid');
		    $email = $input->post('email');
		    $cate = $input->post('cate');
		    if(!trim($webName) || !trim($adminName) || !trim($adminPassword) || !trim($webDesc)
		        || !trim($webSite) || !trim($cate) || !trim($email)){
		        //信息不完整
		        $error = 2;
		    }
		    if(Helper_Blogconfig::getAdminInfo(array('website'  => $webSite, 'status'=>0)) 
		        || Helper_Blogconfig::getAdminInfo(array('webname'  => $webName, 'status'=>0))){
		        //网站已存在
		        $error = 1;
		    }
		    if(!$error){
		        Helper_Blogconfig::insertAdminInfo(array(
    		        'insertData' =>  array(
    		            'webName' => $webName,
    		            'adminName' => $adminName,
    		            'adminPassword' => md5($adminPassword.'_'),
    		            'webDesc' => $webDesc,
    		            'webSite' => $webSite,
    		            'weiboUid' => $weiboUid,
    		            'email' => $email,
    		            'cate' => $cate,
    		            'status' => 0,
    		        ), 
    		    ));
		        $error = 'noerror';
		    }
		    $output->error = $error;
		    $output->setTemplate('Apply');
		}
	}
?>