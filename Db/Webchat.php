<?php
class Db_Webchat extends LJL_Abstract_Pdo 
{
    /**
     * 生产服务器数据库配置
     */
    private $serversProduction = array(
	    'username' => 'puser',
	    'password' => '',
		'master' => array(
			'host' => '127.0.0.1',
			'database' => 'webChat',
		 ),
		 'slave' => array(
			'host' => '127.0.0.1',
			'database' => 'webChat',
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
            'database' => 'webChat',
        ),
        'slave' => array(
            'host' => '127.0.0.1',
            'database' => 'webChat',
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
