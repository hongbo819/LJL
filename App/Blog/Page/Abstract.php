<?php

abstract class Blog_Page_Abstract extends LJL_Abstract_Page
{
	/**
	* @var LJL_DAL_RefreshCacheLoader
	*/
	protected static $_cache;	
	
	protected function _loadDb()
	{
	}
    
	public function __construct(LJL_Request $input, LJL_Response $output)
	{
		$this->_loadDb();

		$output->execName =
		$input->execName  = $input->getExecName();
		
		$output->actName  =
		$input->actName   = $input->getActionName();
		
		$output->ctlName  =
		$input->ctlName   = $input->getControllerName();
	}
	/**
	 * 父类的Validate
	 */
	public function baseValidate(LJL_Request $input, LJL_Response $output)
	{
	    //获取静态文件路径
	    $output->_SFP = LJL_Config::get(APP_NAME."_App", 'staticPath');
	    //不是爬虫
	    if(!LJL_Http::isRobot()){
	        //防止恶意刷新
	        if($input->cookie('whatareyou')){
	            echo 'what are you 弄啥嘞！ ……robot-like';die();
	        }
	        
	        if($input->cookie('emithsulf') || setcookie('emithsulf', API_Item_Security_Algos::fastEncode(array('value'=>1)), SYSTEM_TIME+3, '/')){
	            if(API_Item_Security_Algos::fastDecode(array('value'=>$input->cookie('emithsulf')))>10){
	                setcookie('whatareyou', 'ekil-tobor', SYSTEM_TIME+120, '/');
	            }
	            $nowNum = API_Item_Security_Algos::fastDecode(array('value'=>$input->cookie('emithsulf')))+1;
	            setcookie('emithsulf', API_Item_Security_Algos::fastEncode(array('value'=>$nowNum)), SYSTEM_TIME+3, '/');
	        }
	    }
	    //登录验证
	    if(!Blog_Plugin_Common::loginAuth()) {
	        echo '非法。。。登录。。。';die();
	    }
		
		return true;
	}
	/**
	* 初始化缓存
	*/
	public static function init()
	{
	}
	
	/**
	* 加载缓存
	* @return array DAL data
	*/
	protected static function loadCache($moduleName, $param = array(), $num = 0)
	{
		self::init();
		$data = self::$_cache->loadCacheObject($moduleName, $param);

		if ($num && $data && count($data) > $num) {
			$data = array_slice($data, 0, $num, true);
		}

		return $data;
	}
	
	/**
	* 更新缓存
	*/
	protected static function refreshCache($moduleName, $param = array())
	{
		self::init();
		return self::$_cache->refreshCacheObject($moduleName, $param);
	}
}
