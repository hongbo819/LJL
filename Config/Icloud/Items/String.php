<?php
/**
* @version  v1.0
* @todo Icloud配置 字符串基本操作
*/
return array(
    'Base.String.getFirstLetter' => array(
        'name' => '获取字符串首字母',
        'param'=> array(
            array('input', '字符串', 1, '字符串'),
            array('code', '编码', 0, '编码utf-8/gbk，默认utf-8'),
        ), 
    ),
    'Base.String.getPinyin' => array(
        'name' => '将汉字转化为拼音',
        'param'=> array(
            array('input', '汉字', 1,),
            array('code', '编码', 0, '编码utf-8/gbk，默认utf-8'),
        ), 
    ),
    'Base.String.replaceCnStr' => array(
        'name' => '中文替换',
        'param'=> array(
            array('needle', '字符串', 1, '被替换的字符串'),
            array('str', '字符串', 0, '替换为的字符串'),
            array('haystack', '字符串', 0, 'haystack'),
            array('code', '编码', 0, '编码 utf-8/gb2312/gbk/big5'),
        ), 
    ),
    'Base.String.splitStr' => array(
        'name' => '将字符串拆解成数组(识别汉字)',
        'param'=> array(
            array('input', '字符串', 1, '字符串'),
            array('code', '编码', 0, '编码 utf-8/gbk'),
        ), 
    ),
    'Base.String.getShort' => array(
        'name' => '中文截取,utf8',
        'param'=> array(
            array('str', '字符串', 1, '字符串'),
            array('length', '截取长度'),
            array('ext', '后缀', 0, '比如"..."'),
        ), 
    ),
    'Base.String.gzdecode' => array(
        'name' => '解压gzip字符串',
        'param'=> array(
            array('input', '字符串', 1, '字符串'),
        ), 
    ),
);