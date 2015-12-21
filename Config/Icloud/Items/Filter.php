<?php
/**
* @version  v1.0
* @todo Icloud配置 安全过滤
*/
return array(
    'Security.Input.sqlFilter' => array(
        'name' => '预防sql注入的过滤',
        'param'=> array(
            array('value', '要过滤的字串', 1,),
            array('from', '来源', 0, '来源区分，G:get的数据 P:post C:cookie'),
            array('recDb', '记录', 0, '默认0：不记录 1：记录'),
        ), 
    ),
    'Base.String.filterXss' => array(
        'name' => '过滤xss代码',
        'param'=> array(
            array('input', '字符串', 1,),
        ),
    ),
);