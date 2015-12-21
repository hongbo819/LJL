<?php
/**
* @version  v1.0
* @todo Icloud配置  Redis操作
*/
return array(
    'Kv_Redis_getObj' => array(
        'name' => '获得Redis的连接对象',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
        ), 
    ),
    'Kv_Redis_getAllServer' => array(
        'name' => '获得所有的Redis服务器信息',
        'param'=> array(
        ), 
    ),
    'Kv_Redis_stringSet' => array(
        'name' => 'string类型的set方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
            array('value', 'value', 0, ''),
            array('life', '缓存时间', 0, '默认86400'),
        ), 
    ),
    'Kv_Redis_stringGet' => array(
        'name' => 'string类型的get方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
        ), 
    ),
    'Kv_Redis_stringMGet' => array(
        'name' => 'string类型一次获取多条数据的get方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '多个key用逗号分割'),
        ), 
    ),
    'Kv_Redis_stringIncr' => array(
        'name' => 'string类型的自增方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
        ), 
    ),
    'Kv_Redis_stringDecr' => array(
        'name' => 'string类型的自减方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
        ), 
    ),
    'Kv_Redis_stringAppend' => array(
        'name' => 'string类型的append方法',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
            array('value', 'value', 0, '要连接的字串'),
            array('life', 'life', 0, '缓存时间 默认86400'),
        ), 
    ),
    'Kv_Redis_listRange' => array(
        'name' => '列表类型获取值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
            array('start', 'start', 0, 'lRange的start 默认0'),
            array('end', 'end', 0, 'lRange的end 默认-1'),
        ), 
    ),
    'Kv_Redis_listSize' => array(
        'name' => '列表类型的大小',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
        ), 
    ),
    'Kv_Redis_listIndexSet' => array(
        'name' => '列表类型设置某个索引的值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
            array('index', 'index', 0, '要设置的索引'),
            array('value', 'value', 0, '值'),
            array('life', '设置过期时间', 0, '为0，则使用list初始过期时间'),
        ), 
    ),
    'Kv_Redis_listIndexGet' => array(
        'name' => '列表类型获取某个索引的值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
            array('index', 'index', 0, '要获取的索引'),
        ), 
    ),
    'Kv_Redis_listRemove' => array(
        'name' => '列表类型删除某个值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
            array('value', 'value', 1, '要删除的值'),
            array('count', '删除几个', 0, '-2：删除最后两个 2：删除头两个 0：删除所有'),
        ), 
    ),
    'Kv_Redis_hashSet' => array(
        'name' => '散列类型获取key的某个索引的或所有值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'Key', 1, ''),
            array('index', 'index', 0, '索引值'),
            array('value', 'value', 0, ''),
            array('life', '缓存时间', 0, '不设置则默认原来的缓存时间'),
        ), 
    ),
    'Kv_Redis_hashGet' => array(
        'name' => '散列类型获取key的某个索引的值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
            array('index', 'index', 0, '索引值'),
        ), 
    ),
    'Kv_Redis_hashGetAll' => array(
        'name' => '散列类型获取key的某个索引的值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '列表的Key', 1, ''),
        ), 
    ),
    'Kv_Redis_hashIncrBy' => array(
        'name' => '散列类型指定字段incrby',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'Key', 1, ''),
            array('index', 'index', 1, '索引值'),
            array('incrby', 'incrby', 0, '整数数据值'),
            array('life', '缓存时间', 0, '不设置则默认原来的缓存时间'),
        ),
    ),
    'Kv_Redis_ssetAdd' => array(
        'name' => '集合:增加集合元素',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'Key', 1, ''),
            array('value', 'value', 0, ''),
            array('life', '缓存时间', 0, '不设置则默认原来的缓存时间'),
        ),
    ),
    'Kv_Redis_ssetMembers' => array(
        'name' => '集合:获得当前key下所有元素',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'Key', 1, ''),
        ),
    ),
    'Kv_Redis_ssetRemove' => array(
        'name' => '集合:删除当前key下指定元素',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'Key', 1, ''),
            array('value', 'value', 1, '要删除的元素'),
        ),
    ),
    'Kv_Redis_ssetMove' => array(
        'name' => '集合:移动元素 从集合A到集合B',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('fromKey', 'Key', 1, '要移动涉及的key $fromKey'),
            array('toKey', 'value', 1, '移动到的key $toKey'),
            array('value', 'value', 1, '要移动的元素'),
        ),
    ),
    'Kv_Redis_ssetSize' => array(
        'name' => '集合:统计集合内元素个数',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
        ),
    ),
    'Kv_Redis_ssetIsMember' => array(
        'name' => '集合:判断元素是否属于某个key',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, ''),
            array('value', 'value', 1, ''),
        ),
    ),
    'Kv_Redis_ssetInter' => array(
        'name' => '集合:求交集',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('keyArr', 'keyArr', 1, '键值数组，可以逗号分隔'),
        ),
    ),
    'Kv_Redis_ssetUnion' => array(
        'name' => '集合:求并集',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('keyArr', 'keyArr', 1, '键值数组，可以逗号分隔'),
        ),
    ),
    /**
     * --------有序集合
     */
    
    'Kv_Redis_zsetAdd' => array(
        'name' => '有序集合:增加加元素',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '键值'),
            array('score', 'score', 1, '用于对value排序'),
            array('value', 'value', 1, '值'),
            array('life', '有效时间', 0, '有效时间'),
        ),
    ),
    'Kv_Redis_zsetRange' => array(
        'name' => '有序集合:获取键为key的zset(index从start到end)',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '键值'),
            array('start', 'start', 0, ''),
            array('end', 'end', 0, ''),
            array('withscores', '是否按照分数排序', 0, '是否按照分数排序'),
            array('orderBy', '排序', 0, '是否逆序'),
        ),
    ),
    'Kv_Redis_zsetRangeByScore' => array(
        'name' => '有序集合:获取(score >= star且score <= end)的值',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '键值'),
            array('start', 'start', 0, '开始score'),
            array('end', 'end', 0, '结束socre'),
            array('withscores', '是否按照分数排序', 0, '是否按照分数排序'),
            array('limitStart', '索引起始点', 0, ''),
            array('limitNum', '个数', 0, ''),
            array('orderBy', '排序', 0, '是否逆序'),
        ),
    ),
    'Kv_Redis_zsetCount' => array(
        'name' => '有序集合:获取(score >= star且score <= end)的数量',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '键值'),
            array('start', 'start', 0, '开始score'),
            array('end', 'end', 0, '结束socre'),
        ),
    ),
    'Kv_Redis_zsetSize' => array(
        'name' => '有序集合:获取集合类型名称为key的所有元素的个数',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', 'key', 1, '键值'),
        ),
    ),
    'Kv_Redis_delete' => array(
        'name' => '删除操作',
        'param'=> array(
            array('serverName', '服务器名', 0, '参照见API_Redis的定义'),
            array('key', '要删除的Key', 1, '可以是数组'),
        ),
    ),
);