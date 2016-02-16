<?php
/**
* @version  v1.0
* @todo Icloud配置 算法
*/
return array(
    'Security.Algos.getUniqueCode' => array(
        'name' => '获得用户唯一码 (用户信息+进程信息+时间戳+随机数)',
        'param'=> array(
        ), 
    ),
    'Security.Algos.des3Encrypt' => array(
        'name' => '3DES 加密算法(可逆加密，安全性高)',
        'param'=> array(
            array('value', '要加密的字符', 1, ),
            array('cryptkey', '秘钥', 0, '加密用的key'),
        ),
    ),
    'Security.Algos.des3Dencrypt' => array(
        'name' => '3DES 解密算法',
        'param'=> array(
            array('value', '加密字符', 1, ),
            array('cryptkey', '秘钥', 0, '秘钥'),
        ),
    ),
    'Security.Algos.fastEncode' => array(
        'name' => '快速的加密算法（可逆加密，安全性差）',
        'param'=> array(
            array('value', '要加密的字符', 1, ),
            array('cryptkey', '秘钥', 0, '加密用的key'),
        ),
    ),
    'Security.Algos.fastDecode' => array(
        'name' => '快速的解密算法',
        'param'=> array(
            array('value', '加密字符', 1, ),
            array('cryptkey', '秘钥', 0, '秘钥'),
        ),
    ),
    'Security.Algos.simpleEncrypt' => array(
        'name' => '简单的加密形式',
        'param'=> array(
            array('value', '要加密字符', 1, ),
            array('cryptkey', '秘钥', 0, '秘钥(16/24/34位 php6.+)'),
        ),
    ),
    'Security.Algos.simpleDecrypt' => array(
        'name' => '简单的解密形式',
        'param'=> array(
            array('value', '加密字符', 1, ),
            array('cryptkey', '秘钥', 0, '秘钥'),
        ),
    ),
    'Security.Algos.urlSign' => array(
        'name' => 'URL的签名算法，返回一个token字符串',
        'param'=> array(
            array('queryParam', '请求参数', 1, '可以传入参数数组（一维） 也可以传入a=b&c=d的参数'),
            array('cryptkey', '秘钥', 0, '签名的密钥'),
            array('timeInfo', '时间信息', 0, '0：不可逆 1:为了获取设置的时间 可逆'),
        ),
    ),
    'Security.Algos.getUrlSignTm' => array(
        'name' => '获得URL的签名时间戳',
        'param'=> array(
            array('signStr', '签名串', 1, '根据签名算法生成的字串'),
            array('cryptkey', '秘钥', 0, '签名的密钥'),
        ),
    ),
);