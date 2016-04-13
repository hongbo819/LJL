<?php
/**
 * blog项目公用相关
 * @author cuihb
 *
 */
class Blog_Plugin_Common {
    /**
     * 博客简单密码，实际项目请用保密接口形式
     */
    public static function password($password){
        return md5($password.'_');
    }
    
    /**
     * 博客用户唯一ckid
     */
    public static function ckid($str){
        $key = '&$@#$%&^$';
        return md5(md5(urlencode($str)).$key);
    }
    /**
     * 验证登录的合法性
     */
    public static function loginAuth($ckid, $name) {
        if($name)
            return $ckid === self::ckid($name) ? true : false;
        return true;
    }
    /**
     * 获取顶级域名
     */
    public static function getHost(){
        if(strpos(WWW_WEB, '-de') > -1)
            return str_replace('http://'.APP_BLOG_NAME.'-de.', '', rtrim(WWW_WEB, '/'));
        return str_replace('http://'.APP_BLOG_NAME.'.', '', rtrim(WWW_WEB, '/'));
    }
    /**
     * 时间戳转时间
     */
    public static function timestampToTime($timestamp){
        $time = time();
        $temp = $time-$timestamp;
        if($temp < 60){
            return '刚刚';
        }elseif($temp >= 60 && $temp < 3600){
            return floor($temp/60).'分钟前';
        }elseif($temp >= 3600 && $temp < 86400){
            return floor($temp/3600).'小时前';
        }elseif($temp >= 86400 && $temp < 2592000){
            return floor($temp/86400).'天前';
        }else{
            return date("Y-m-d H:i:s", $timestamp);
        }
    }
    
}
?>