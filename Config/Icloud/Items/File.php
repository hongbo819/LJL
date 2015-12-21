<?php
/**
* @version  v1.0
* @todo Icloud配置 文件相关
*/
return array(
    'Base.File.exists' => array(
        'name' => '判断文件(本地或远处)是否存在',
        'param'=> array(
            array('file', '文件地址', 1),
        ), 
    ),
    'Base.File.ls' => array(
        'name' => '列出文件列表(非递归)',
        'param'=> array(
            array('__dir', '目录地址', 1),
            array('__pattern', '匹配规则', 0, '默认*.*'),
        ), 
    ),
);