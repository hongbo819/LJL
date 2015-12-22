<?php
/**
* Icloud管理器
*/
//http://icloud-de.zhbor.com/index.php?c=IcloudManage
class Icloud_Page_IcloudManage extends LJL_Abstract_Page
{
    private $helperCfgArr = array();
		
	public function __construct(){
	}

	public function validate(LJL_Request $input, LJL_Response $output)	{
// 	    LJL_Api::run("Image.Util.downImg" , array(
// 	        'file' 	   =>'/www/LJL/Html/Blogstaticfile/1.png',
// 	    ));
// 	    die;
	    $output->Items = LJL_Config::get('Icloud_Items');
	    //指定方法
	    $output->showFunName = $input->showFunName = $input->get("showFunName");
	    $input->funName = $output->funName = $input->post("funName");
	    
	    //指定模块
	    $output->moduleName = $input->moduleName = $input->get("moduleName") 
	                                               ? $input->get("moduleName")
	                                               : $input->post("moduleName");
	    
		#从配置中读取相关模块所属下的方法
		if(!$input->moduleName){
		    return true;
		}
		$output->helperCfgArr = $this->helperCfgArr = LJL_Config::get('Icloud_Items_'.$input->moduleName);
		
		if($input->funName || $input->showFunName)
	    $output->funParamArr = $output->showFunName 
	                           ? $output->helperCfgArr[$output->showFunName]
	                           : $output->helperCfgArr[$output->funName];
		
		return true;
	}

	public function doDefault(LJL_Request $input, LJL_Response $output){
		#如果是提交
		if($input->funName){#获得所有需要参数的值
			$iparam = $output->helperCfgArr[$input->funName]['param'];
			$paramVal = array();
			if($iparam){
				foreach($iparam as $p){
					$paramValArr[$p[0]] = $input->post($p[0]);
				}
				
			}
			if(isset($paramValArr)){
				foreach($paramValArr as $k => $v){
					if($v == '')unset($paramValArr[$k]);
				}
				$paramValArr =
				$output->paramValArr = $paramValArr;// array_filter($paramValArr);
			}else{
				$paramValArr = array();
				$output->paramValArr = $paramValArr;
			}
			$data = LJL_Api::run($input->funName , $paramValArr);
			$output->htmlVarStr =  Libs_Tools_VarDump::showVar($data);

		}
		$output->setTemplate('IcloudManage');
	}
	public function doSinalogin(LJL_Request $input, LJL_Response $output){
// 	    $userInfo = LJL_Api::run('Open.Sina.getWeiboByUrl' , array(
// 	        //'apiuid' => '2004858905', 
// 	        //'appuid' => '20', 
// 	         //'name' => '崔洪波同学', 
// 	         'url' => 'http://cui.zhbor.com/article/13.html#0-tsina-1-38138-397232819ff9a47a7b7e80a40613cfe1',
// 	    ));
// 	    var_dump($userInfo);die;
	    
	    
	    
	    $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    if($input->get('code')){
	        $tokenInfo = LJL_Api::run('Open.Sina.getLoginTokens' , array(
	            'code'        =>$input->get('code'),
	            'redirect_uri'=>$redirect_uri,
	        ));
	        
	        $userInfo = LJL_Api::run('Open.Sina.getUserInfo' , array(
	            'uid'        =>$tokenInfo['uid'],
	            'accessToken'=>$tokenInfo['access_token'],
	        ));
	        var_dump($tokenInfo);
	        var_dump($userInfo);die;
	    }
	        
	    $loginurl = LJL_Api::run('Open.Sina.getAuthorizeURL' , array('redirect_uri'=>$redirect_uri));
	   echo '<a href="'.$loginurl.'">微博登陆</a>';die;
	}
}