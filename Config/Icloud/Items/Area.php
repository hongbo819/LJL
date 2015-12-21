<?php
/**
* @version  v1.0
* @todo Icloud配置  
*/
return array(
    'Service_Area_getMobileArea' => array(
        'name' => '获得手机号信息',
        'param'=> array(
            array('mobile', '手机号', 1, ),
        ), 
    ),
    'Service_Area_getClientIp' => array(
        'name' => '得到网友的详细IP信息',
        'param'=> array(
        ), 
    ),
    'Service_Area_ip2location' => array(
        'name' => '获取ip地址信息',
        'param'=> array(
            array('ip', 'ip', 1, '输入ip' ),
        ),
    ),
    'Service_Area_getIpinfoByDb' => array(
        'name' => '从数据库获取ip地址信息',
        'param'=> array(
            array('ip', 'ip', 1, '输入ip' ),
        ),
    ),
);