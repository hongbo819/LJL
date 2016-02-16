<?php
/**
 * 启动脚本
 *
 * 使用方法
 * 		/usr/local/php/bin/php index.php 服务器环境(server/local) --c=操作类 --a=操作方法 
 *
 * 例如：
 *      /usr/local/php/bin/php index.php server --c=Publish --a=Publisharticle
 */


//产品配置
define('IN_PRODUCTION', true);
define('PRODUCTION_ROOT', dirname(dirname(dirname(__FILE__))));
define('SYSTEM_VAR', PRODUCTION_ROOT . '/var/');

//应用配置
define('APP_NAME', 'Auto_Blog'); // 配置是哪个实例
define('MAIN_PAGE', 'zhbor.com');
define('APP_PATH', PRODUCTION_ROOT . '/Auto/' . APP_NAME); // 配置实例的APP路径
//数据库配置
// define('DB_USERNAME','root');
// define('DB_PASSWORD','111111');

//DAL配置
define('DAL_CACHE_MODULES_DIR', PRODUCTION_ROOT . '/Modules');#数据模块目录
define('DAL_DIR', PRODUCTION_ROOT . '/DAL');#DAL实例目录

// 调试模式
define('IS_DEBUGGING', true);
// 生产状态
define('IS_PRODUCTION', $argv[1] === 'server');

//LJL框架，需要先引入私有云
require('/APILJL/Api.php');
require_once(PRODUCTION_ROOT . '/init.php');

LJL::setNameSpace(PRODUCTION_ROOT . '/Libs');#注册类库
LJL::setNameSpace(PRODUCTION_ROOT . '/Modules');#注册缓存模块
LJL::setNameSpace(APP_PATH);#注册应用
LJL::setNameSpace(PRODUCTION_ROOT . '/Db');#注册数据库链接类
LJL::setNameSpace(PRODUCTION_ROOT . '/DAL');#注册DAL实例
LJL::setNameSpace(PRODUCTION_ROOT . '/Auto');
LJL::setNameSpace(PRODUCTION_ROOT . '/Helper');#注册Helper实例

LJL_Controller_Front::run();

