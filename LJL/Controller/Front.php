<?php

/*
|---------------------------------------------------------------
| 控制器
|---------------------------------------------------------------
| @package LJL
|
*/
class LJL_Controller_Front
{
    /**
     *
     * @var LJL_Abstract_Page
     */
    protected static $_page;

    protected static $_url;

    protected static $_cacheKey;

    protected static $_html;

    public static function run()
	{
		LJL_Registry::set('request', new LJL_Request);
		$request = LJL_Registry::get('request');

		LJL_Registry::set('response', new LJL_Response());
		$response = LJL_Registry::get('response');
	
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		
		$controller = LJL_String::toValidVariableName($controller);
		$action = LJL_String::toValidVariableName($action);
		
		if (empty($controller))
		{
			throw new LJL_Exception("The controller of '$controller' is empty in request!");
		}
		if (empty($action))
		{
			throw new LJL_Exception("The action of '$action' is empty in request!");
		}

		$controller =  APP_NAME . '_Page_' . ucfirst($controller);
		//var_dump($controller);
        $page = new $controller($request, $response);
        self::$_page = $page;
        
        self::$_url = empty($_SERVER['SCRIPT_URL']) ? '' : $_SERVER['SCRIPT_URL'];
        self::$_cacheKey = self::getCacheKey();
        //var_dump($page);
        if ($page->isCache() && $html = self::getCache()) {
            die($html);
        }

		if ($page->validate($request, $response)) {
			
			$actionMap = $page->getActionMapping();
			if (empty($actionMap)) {
				$action = 'do' . ucfirst($action);
				if (method_exists($page, $action)) {
					$page->$action($request, $response);
				} else {
					throw new LJL_Exception("The function of '{$action}' does not exist in class '$controller'!");
				}
			} else {
				foreach($actionMap[$action] as $methodName) {
					$methodName = 'do' . ucfirst($methodName);
					if (method_exists($page, $methodName)) {
						$page->$methodName($request, $response);
					} else {
						throw new LJL_Exception(' the function dose not exist:' . $methodName );
					}
				}
			}
		}
		
		self::$_html = $response->display();
        $page->isCache() && self::setCache();
	}

    public static function getCache($url = null)
    {
        $key = self::$_cacheKey;
        if (!$key) {
            return false;
        }
        if (self::checkExpire()) {
            $data = LJL_File::get($key);
            return gzinflate($data);
        }
        return false;
    }

    public static function setCache($html = null, $url = null)
    {
        $key = self::$_cacheKey;
        $html = is_null($html) ? self::$_html : $html;
        if (!$html) {
            return false;
        }
        $html = gzdeflate($html, 9);
        return LJL_File::write($html, $key);
    }

    public static function getCacheKey($url = null)
    {
        $url = is_null($url) ? self::$_url : $url;
        $key = md5($url);
        $key = SYSTEM_VAR . 'html/'
            . chunk_split(substr($key, 0, 4), 2, '/')
            . substr($key, 4) . '.html';
        return $key;
    }

    /**
     * 检查缓存是否过期
     * @return bool true 没过期| false过期
     */
    public static function checkExpire()
    {
        $page = self::$_page;
        $expire = $page->getExpire();
        $isCache = $page->isCache();
        return $isCache && file_exists(self::$_cacheKey) && ($expire === 0 || filemtime(self::$_cacheKey) + $expire > SYSTEM_TIME);
    }
}


