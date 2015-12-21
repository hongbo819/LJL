<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
define('IN_PRODUCTION', true);
define('PRODUCTION_ROOT', dirname(dirname(dirname(__FILE__))));
define('SYSTEM_VAR', PRODUCTION_ROOT . '/var/');
//应用配 置
define('APP_NAME', 'Icloud'); // 配置是哪个实例
define('APP_PATH', PRODUCTION_ROOT . '/App/' . APP_NAME); // 配置实例的APP路径

//框架的不同应用实例
//define('LJL_FAPP', 'Blog');



//DAL配置
define('DAL_CACHE_DIR', SYSTEM_VAR .'cache_data/');#缓存目录
define('DAL_LOCALMEM_CACHE_DIR', DAL_CACHE_DIR .'tmpfs/');#内存缓存目录
define('DAL_CACHE_MODULES_DIR', PRODUCTION_ROOT . '/Modules');#数据模块目录
define('DAL_DIR', PRODUCTION_ROOT . '/DAL');#DAL实例目录
define('DAL_CACHE_SAVE_TYPE', 'SERIALIZE');#缓存类型

// 调试模式
define('IS_DEBUGGING' , !false);
// 生产状态
define('IS_PRODUCTION', !true);
if(!IS_DEBUGGING)error_reporting(0);
if(IS_DEBUGGING){
	ini_set("display_error","On");
	error_reporting(E_ALL);
};

//LJL框架，需要先引入私有云
require('/APILJL/Api.php');
require_once(PRODUCTION_ROOT . '/init.php');

LJL::setNameSpace(PRODUCTION_ROOT . '/Libs');#注册类库
LJL::setNameSpace(PRODUCTION_ROOT . '/Modules');#注册缓存模块
LJL::setNameSpace(APP_PATH);#注册应用
LJL::setNameSpace(PRODUCTION_ROOT . '/Db');#注册数据库链接类
LJL::setNameSpace(PRODUCTION_ROOT . '/DAL');#注册DAL实例
LJL::setNameSpace(PRODUCTION_ROOT . '/Helper');#注册Helper实例
LJL::setNameSpace(PRODUCTION_ROOT . '/App/Pro');#注册
LJL::setNameSpace(PRODUCTION_ROOT . '/App/Pro/Plugin');#注册

LJL_Controller_Front::run();