<?php

abstract class LJL_Abstract_Page
{
	/*
	| @access  private
	| @var     array
	*/

    /**
     * 是否缓存
     * @var bool
     */
    protected $_isCache = false;


    /**
     * 过期时间 单位 秒
     * @var int
     */
    protected $_expire  = 3600;

	protected $_aActionsMapping = array();
	
	public function addActionMapping(array $aActionMap)
	{
		$this->_aActionsMapping = $aActionMap;
	}
	
	public function getActionMapping()
	{
		return $this->_aActionsMapping;
	}

    /**
     * 页面过期时间 0为永不过期
     * @return int
     */
    public function getExpire()
    {
        return $this->_expire;
    }

    /**
     * 页面是否缓存
     * @return bool
     */
    public function isCache()
    {
        return $this->_isCache;
    }
	
	/*
	|---------------------------------------------------------------
	| Specific validations are implemented in sub classes.
	|---------------------------------------------------------------
	| @param   LJL_Request     $req    LJL_Request object received from user agent
	| @return  boolean
	|
	*/
	public function validate(LJL_Request $input, LJL_Response $output)
	{
		return true;
	}
}
