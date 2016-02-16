<?php
class Db_Blog extends LJL_Abstract_Pdo 
{
    /**
     * 生产服务器数据库配置
     */
    private $serversProduction = array(
	    'username' => 'puser',
	    'password' => '',
		'master' => array(
			'host' => '127.0.0.1',
			//'database' => 'blog_cui',
		 ),
		 'slave' => array(
			'host' => '127.0.0.1',
			//'database' => 'blog_cui',
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
			//'database' => 'blog_cui',
		 ),
		 'slave' => array(
			'host' => '127.0.0.1',
			//'database' => 'blog_cui',
		 ),
	);
	protected $servers   = array();
	//项目特殊，才这样做的
	public function __construct($database=''){
	    $this->servers = IS_PRODUCTION
	    ? $this->serversProduction
	    : $this->serversDevelop;
	    
	    //以下是特殊处理(因为多个站点用的同一个model)，不正规
	    $isDevelop = IS_PRODUCTION ? '' : '-test';
	    if(defined('APP_BLOG_NAME') && APP_BLOG_NAME != 'www'){
	        $this->servers['master']['database'] = 'blog_'.APP_BLOG_NAME.$isDevelop;
	        $this->servers['slave']['database']  = 'blog_'.APP_BLOG_NAME.$isDevelop;
	    }elseif($database){
	        $this->servers['master']['database'] = $database.$isDevelop;
	        $this->servers['slave']['database']  = $database.$isDevelop;
	    }
	    
	    parent::__construct();
	}
}
