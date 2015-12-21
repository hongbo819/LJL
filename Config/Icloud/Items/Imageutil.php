<?php
/**
 * @version  v1.0
 * @todo Icloud配置  
 */
return array(
    'Image.Util.getImgInfo' => array(
        'name' => '获得图片的详细信息(仅限图片)',
        'param'=> array(
            array('path', '图片路径', 1, '图片路径'),
        ),
    ),
    'Image.Util.getImgType' => array(
        'name' => '获得文件类型（根据type可知是否为图片）',
        'param'=> array(
            array('path', '图片路径', 1, '图片路径'),
        ),
    ),
    'Image.Util.downImg' => array(
        'name' => '下载本地图片',
        'param'=> array(
            array('file', '本地图片路径', 1, '图片路径'),
        ),
    ),
    'Image.Util.downRemoteImg' => array(
        'name' => '下载远程图片，并保存',
        'param'=> array(
            array('url', '图片src', 1, '远程图片路径'),
            array('path', '保存路径', 1, '如：/a/b.jpg'),
        ),
    ),
    'Image.Util.getFileTypeByContent' => array(
        'name' => '根据内容判断文件类型',
        'param'=> array(
            array('filepath', '文件路径', ),
            array('content', '内容', 0, '如有文件路径，则该参数无意义'),
        ),
    ),
);

?>