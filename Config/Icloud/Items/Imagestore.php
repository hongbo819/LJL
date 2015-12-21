<?php
/**
* @version  v1.0
* @todo Icloud配置 图片相关
*/
return array(
    'Image.DFS.imgStorage' => array(
        'name' => '上传前,获取图片名称 、时间、上传路径',
        'param'=> array(
            array('rootdir', '上传目录', 0, '默认根目录的0-f文件夹下'),
        ), 
    ),
    'Image.DFS.getImgDir' => array(
        'name' => '获取图片路径',
        'param'=> array(
            array('imgName', '图片名称', 1, ),
            array('time', '上传时间', 1, ),
            array('rootdir', '上传目录', 0, '默认根目录的0-f文件夹下'),
        ),
    ),
 );