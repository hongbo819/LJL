<?php
/**
* Helper管理器
*/
//http://helper.cuihongbo.com/index.php?c=HelperManage
class Tools_Page_HelperManage extends LJL_Abstract_Page
{
    private $helperCfgArr = array();
		
	public function __construct(){
	}

	public function validate(LJL_Request $input, LJL_Response $output)	{
		//var_dump($input);
		#从配置中读取相关Helper配置
		$output->helperCfgArr = $this->helperCfgArr = LJL_Config::get('Tools_Helper_'.LJL_FAPP,'MANAGE');
		$output->dopost =
		$input->dopost = (int)$input->post("dopost");
		$input->funName = '';
		if($input->dopost){
			$output->funName = 
			$input->funName = $input->post("funName");
		}
		#指定方法
		$output->showFunName  = $input->funName ? $input->funName : $input->get("showFunName");
		$helpCfgArr2 = array();
		foreach($this->helperCfgArr as $groupName => $cfgArr){
			$helpCfgArr2 = array_merge($helpCfgArr2,$cfgArr);
		}		
		$output->helpCfgArr2 = $helpCfgArr2;
		//var_dump($helpCfgArr2);die;
		if($output->showFunName){
			$output->funParamArr = $helpCfgArr2[$output->showFunName];
		}
		return true;
	}

	public function doDefault(LJL_Request $input, LJL_Response $output){
		#如果是提交
		//var_dump($input->dopost);die;
		if($input->dopost && $input->funName){#获得所有需要参数的值
			$iparam = $output->helpCfgArr2[$input->funName]['param'];
			//var_dump($iparam);die;
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
			#获得结果
			$tmpArr = explode("::",$input->funName);
			$className = "Helper_" . $tmpArr[0];
			//var_dump($className);die;
			$classMethod = $tmpArr[1];
			
			#特殊处理
			if('Helper_Blog' == $className && in_array($classMethod, array('getArticleList','getArticleInfo'))){
			    Db_Blog::instance(null, 'blog_laura');
			}
			
			if(isset($output->helpCfgArr2[$input->funName]['norun'])){
				$output->htmlVarStr = $output->helpCfgArr2[$input->funName]['norun'];
			}else{
				$data = call_user_func(array($className, $classMethod),$paramValArr);
				$output->htmlVarStr =  Libs_Tools_VarDump::showVar($data);
			}

		}

		$output->setTemplate('HelperManage');
	}

}