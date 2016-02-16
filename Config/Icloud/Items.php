<?php
/**
* @version  v1.0
* @todo Icloud配置  每个英文键值都对应一个配置文件
*/
return array(
    '基础服务' => array(
        '字符串相关' => array(
            'String' => '字符串操作',
            'Sim'    => '相似度',
        ),
        '基础信息' => array(
            'Area' => 'IP与手机号'
        ),
        '安全相关' => array(
            'Security' => '各种算法',
            'Filter'   => '输入过滤',
            'Captcha' => '验证码',
        ),
        'Arr'      => '数组操作',
        'File'     => '文件相关',
        'Http'     => '页面相关',
    ),
    '图片相关' => array(
        'Imageutil' => '常用方法',
        'Imagestore' => '图片存储',
        'Imageopt' => '图片操作',
    ),
    'kv操作' => array(
        'Redis' => 'Redis',
//         'Mongo' => 'Mongo',
//         'Memcache' => 'Memcache',
        'Queue' => '消息队列'
    ),
    '开放平台' => array(
        'Opensina' => '新浪微博'
    ),
);
