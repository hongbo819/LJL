<?php
/**
* @version  v1.0
* @todo Icloud配置 数组基本操作
*/
return array(
    'Queue.Util.deamonStart' => array(
        'name' => '消息队列 Deamon程序启动',
        'param'=> array(
            array('queueType', '队列类型', 0, '默认RedisQ'),
            array('serverName', '服务器名', 0, '默认ResysQ'),
            array('queueName', 'key', 1, '要监听的消息队列键值'),
            array('jobName', 'jobName', 0, 'job名称'),
            array('cnName', 'cnName', 0, '队列中文名称，便于监控显示'),
            array('function', 'function', 1, '要运行的函数名'),
            array('msgNumAtm', '消息数', 0, '每次处理的消息数默认10'),
            array('maxSleep', 'maxSleep', 0, '没有消息时，deamon睡眠时间'),
            array('adminMail', '邮箱', 1, '接受报警的地址，多个以逗号分隔'),
            array('msgServer', '服务器名', 1, '脚本所在服务器'),
            array('phpFile', '脚本路径', 1, 'php文件地址'),
            array('life', 'life', 0, '程序的生命周期，0：一直循环Deamon处理 否则需要采用crontab形式'),
        ), 
    ),
    'Queue.RedisQ.push' => array(
        'name' => '插入数据',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义 ResysQ'),
            array('key', 'key', 1, '队列名'),
            array('value', 'value', 1, '插入队列的数据'),
        ), 
    ),
    'Queue.RedisQ.pop' => array(
        'name' => '弹出数据,一次一个',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义 ResysQ'),
            array('key', 'key', 1, '队列名'),
        ),
    ),
    'Queue.RedisQ.pops' => array(
        'name' => '弹出数据,一次多个',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义 ResysQ'),
            array('key', 'key', 1, '队列名'),
            array('num', '数量', 0, '默认2'),
        ),
    ),
    'Queue.RedisQ.getSize' => array(
        'name' => '获得队列中现有值的数量',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义 ResysQ'),
            array('key', 'key', 1, '队列名'),
        ),
    ),
    'Queue.RedisQ.range' => array(
        'name' => '获得队列列表详情，不弹出，只是查看',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义 ResysQ'),
            array('key', 'key', 1, '队列名'),
            array('offset', 'offset', 0, '开始索引值'),
            array('len', 'len', 0, '结束索引值'),
        ),
    ),
);