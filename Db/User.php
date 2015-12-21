<?php
class Db_User extends LJL_Abstract_Pdo 
{
    /**
     * 生产服务器数据库配置
     */
    private $serversProduction = array(
	    'username' => 'puser',
	    'password' => '',
		'master' => array(
			'host' => '127.0.0.1',
			'database' => 'ljl_user',
		 ),
		 'slave' => array(
			'host' => '127.0.0.1',
			'database' => 'ljl_user',
		 ),
	);
    /**
     * 测试机数据库配置
     */
    private $serversDevelop = array(
        'username' => 'duser',
        'password' => '',
        'master' => array(
            'host' => '127.0.0.1',
            'database' => 'ljl_user-test',
        ),
        'slave' => array(
            'host' => '127.0.0.1',
            'database' => 'ljl_user-test',
        ),
    );
    
	protected $servers   = array();
	public function __construct(){
	    $this->servers = IS_PRODUCTION
	    ? $this->serversProduction
	    : $this->serversDevelop;
	    parent::__construct();
	}
}
