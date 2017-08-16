<?php
define('IN_PRODUCTION', true);
define('PRODUCTION_ROOT', dirname(dirname(dirname(__FILE__))));
define('SYSTEM_VAR', PRODUCTION_ROOT . '/var/');//日志等
//应用配 置
define('APP_NAME', 'Blog'); // 配置是哪个实例
define('APP_PATH', PRODUCTION_ROOT . '/App/' . APP_NAME); // 配置实例的APP路径

//到后期这些配置的东西过多的时候，则要放到配置文件中
define('APP_BLOG_NAME', 'dw'); // 配置博客名称
define('BLOG_WEB_NAME', '小伟博客'); // 配置博客名称
define('BLOG_SEO_TITTLE', BLOG_WEB_NAME.'-与时俱进的技术，交流分享的平台。'); // 配置title
define('WEIBO_UID', '5590911646'); // 配置微博uid


//上传图片文件夹
define('UPLOAD_IMG_PATH', '/www/img/');
define('WWW_WEB_IMG', 'http://img.zhbor.com/');

//定义系统首页
define('WWW_WEB', 'http://'.$_SERVER['HTTP_HOST'].'/');

//DAL配置
define('DAL_CACHE_MODULES_DIR', PRODUCTION_ROOT . '/Modules');#数据模块目录
define('DAL_DIR', PRODUCTION_ROOT . '/DAL');#DAL实例目录

// 生产状态(日志输出位置)
$isProduction = stripos($_SERVER['HTTP_HOST'], '-lc') !== false || stripos($_SERVER['HTTP_HOST'], '-de') !== false || stripos($_SERVER['HTTP_HOST'], '172.30') !== false ? false : true;
define('IS_PRODUCTION', $isProduction);
// 调试模式
define('IS_DEBUGGING', true);
if(IS_DEBUGGING){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}else{
    error_reporting(0);
}

//LJL框架，需要先引入私有云
require('/APILJL/Api.php');
require_once(PRODUCTION_ROOT . '/init.php');

LJL::setNameSpace(PRODUCTION_ROOT . '/Libs');#注册类库
LJL::setNameSpace(PRODUCTION_ROOT . '/Modules');#注册缓存模块
LJL::setNameSpace(APP_PATH);#注册应用
LJL::setNameSpace(PRODUCTION_ROOT . '/Db');#注册数据库链接类
LJL::setNameSpace(PRODUCTION_ROOT . '/DAL');#注册DAL实例
LJL::setNameSpace(PRODUCTION_ROOT . '/Helper');#注册Helper实例

LJL_Controller_Front::run();
