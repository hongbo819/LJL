<?php
/**
* @version v1.0
* @todo 自动运行程序
*/

class Auto_Weixin_Page_Maketoken extends Auto_Blog_Page_Abstract {
    private static  $WX_AKEY = 'wxf45e9c7fad8e4f39';
    private static $WX_SKEY = '6a9962d639cd937682917d0863335103';
    
    public function doMaketoken(LJL_Request $input){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::$WX_AKEY.'&secret='.self::$WX_SKEY.'';
        $tokenInfo = LJL_Api::run('Base.Http.curlPage',array('url'=>$url,'timeout'=>3));
        
        $tokenPath = PRODUCTION_ROOT.'/Auto/Weixin/Page/token.php';
        $token = (array)json_decode($tokenInfo);
        $token = $token['access_token'];
        
        file_put_contents($tokenPath, $token);
        exit();
    }
}