<?php
/**
* @version  v1.0
* @todo Icloud配置 验证码相关
*/
return array(
    'Security.Captcha.showImage' => array(
        'name' => '显示验证码',
        'param'=> array(
            array('token', '唯一标志', 0, '验证验证码时的签名'),
            array('numCnt', '长度', 0, '验证码字符长度'),
            array('width', '宽', 0, '图片宽度'),
            array('height', '高', 0, '图片长度'),
            array('type', '类型', 0, '1：黑白 2-6复杂'),
            array('plex', '复杂度', 0, '正整数，type=6时生效'),
        ), 
    ),
    'Security.Captcha.doCheck' => array(
        'name' => '验证验证码',
        'param'=> array(
            array('token', '唯一标志', 0, '验证验证码时的签名'),
            array('text', '字符', 1, '验证码字符'),
            array('clear', '是否清除验证码', 0, '默认0：不清除 1：清除'),
            array('debug', 'debug', 0, '是否打印redis中保存的验证码'),
        ), 
    ),
);