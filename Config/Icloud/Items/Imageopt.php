<?php
/**
* @version  v1.0
* @todo Icloud配置 图片相关
*/
return array(
    'Image.QrCode.getQrCode' => array(
        'name' => '获取二维码图片资源',
        'param'=> array(
            array('string', '字串', 1, '二维码文本内容'),
            array('saveFile', '返回形式', 0, '0:返回资源 ；1：返回图片；路径：则保存到该路径'),
            array('size', '尺寸(像素)', 0, '二维码大小，默认150 '),
            array('margin', '外边距', 0, '外边距'),
            array('color', '颜色值', 0, '颜色值'),
            array('logoFile', '图片文件地址', 0, 'logo图片文件地址'),
            array('logoWidth', 'logo图片的大小', 0, '默认为 二维码 的五分之一（size-2*margin）/5'),
        ),
    ),
    'Image.IM.watermark' => array(
        'name' => '添加水印',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('waterGroup', '预定的水印图片组', 0, '预定的水印图片组'),
            array('position', '水印位置', 0, '水印位置'),
            array('waterImg', '指定水印图片', 0, '如果指定水印组，这个参数无效'),
            array('xpadding', '距离左右边的空隙', 0, '如果指定水印组，这个参数无效'),
            array('ypadding', '距离上下边的空隙', 0, '如果指定水印组，这个参数无效'),
        ),
    ),
    'Image.IM.createTextPic' => array(
        'name' => '生成文字图片，用于email，电话，qq等',
        'param'=> array(
            array('desPath', '生成图片名', 1, '生成图片名'),
            array('text', '文本内容', 1, '文本内容'),
            array('font', '文本字体', 0, '文本字体'),
            array('width', '图片宽度', 0, '图片宽度'),
            array('height', '图片高度', 0, '图片高度'),
            array('txtColor', '文本颜色', 0, '默认黑色'),
            array('bgColor', '背景色', 0, ' 默认白色'),
            array('fontSize', '文本字号', 0, '默认16'),
            array('leftOffset', '文本距左边偏移量', 0, '默认4'),
            array('topOffset', '文本距上边偏移量', 0, '默认14'),
        ),
    ),
    'Image.IM.addText' => array(
        'name' => '图片上添加文本',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('text', '文本内容', 1, '文本内容'),
            array('font', '文本字体', 0, '文本字体'),
            array('txtColor', '文本颜色', 0, ''),
            array('fontSize', '文本字号', 0, ''),
            array('leftOffset', '文本距左边偏移量', 0, ''),
            array('topOffset', '文本距上边偏移量', 0, ''),
        ),
    ),
    'Image.IM.rotate' => array(
        'name' => '图片顺时针旋转',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('degree', '旋转度数', 0, '向右旋转的度数（顺时针） '),
            array('background', '背景色', 0, '若旋转不是90的整数倍，需要背景色填空'),
        ),
    ),
    'Image.IM.turn' => array(
        'name' => '图片像素翻转',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('type', '方式', 0, '默认0：水平翻转 1：左右翻转 '),
        ),
    ),
    'Image.IM.transFileType' => array(
        'name' => '图片格式转换',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('format', '目标文件路径', 0, '转换的文件格式(默认jpg)'),
        ),
    ),
    'Image.IM.zoom' => array(
        'name' => '图片 尺寸转换',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 0, '目标文件路径'),
            array('size', '尺寸', 0, '要缩放的图片尺寸 如120x90'),
            array('progressive', '0 or 1', 0, '是否进行渐进式渲染'),
            array('quality', '图片品质', 0, '图片品质(默认90)'),
            array('stripExif', '是否去掉Exif信息 拍摄相机信息等', 0, '除非显示拍摄相机的需求，否则无用'),
        ),
    ),
    'Image.IM.cut' => array(
        'name' => '从图片中截取一个区域',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('size', '要压缩的图片尺寸', 1, '如:100x80'),
            array('left', '距离左侧的像素值',),
            array('top', '距离顶部的像素值',),
        ),
    ),
    'Image.IM.square' => array(
        'name' => '截取正方形区域',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('size', '要压缩的图片尺寸', 1, '如:100x80'),
            array('position', '是否从中部中截取',0, '默认0：不是  1：是'),
            array('offset', '裁图', 0, '左上角位置如：100'),
            array('quality', '图片品质', 0, '图片品质(默认90)'),
            array('stripExif', '是否去掉Exif信息 拍摄相机信息等',0,'除非显示拍摄相机的需求，否则无用'),
        ),
    ),
    'Image.IM.mergePic' => array(
        'name' => '合并图片',
        'param'=> array(
            array('srcPath1', '源文件路径1', 1, '源文件路径1'),
            array('srcPath2', '源文化路径2', 1, '源文化路径2'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('type', '合并方式',0, '默认0=>横向 1=>纵向'),
        ),
    ),
    'Image.IM.border' => array(
        'name' => '设置图片边框颜色及线宽',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('borderColor', '边框颜色',0, '默认红色'),
            array('borderWidth', '左右边框宽度',0, '默认2px'),
            array('borderHeight', '上下边框高度',0, '默认2px'),
        ),
    ),
    'Image.IM.blur' => array(
        'name' => '模糊图片',
        'param'=> array(
            array('srcPath', '源文件路径', 1, '源文件路径'),
            array('desPath', '目标文件路径', 1, '目标文件路径'),
            array('radius', '一个数字', 0, '默认80 '),
            array('sigma', '一个数字', 0, '默认5'),
        ),
    ),
    'Image.IM.toRGBJpg' => array(
        'name' => '将图片转化RGB模式，防止CMYK图片显示问题',
        'param'=> array(
            array('srcPath', '文件路径', 1),
        ),
    ),
    'Image.IM.splitGif' => array(
        'name' => '分解gif动图',
        'param'=> array(
            array('srcPath', '源文件路径', 1),
            array('desDir', 'gif子图存放目录', 1, ''),
            array('desPrefix', '拆分出的gif子图文件名前缀', 0, '默认gif_'),
        ),
    ),
    'Image.IM.getOnePicFromGif' => array(
        'name' => '从gif动图中得到一张子图',
        'param'=> array(
            array('srcPath', '源文件路径', 1),
            array('desPath', 'gif子图路径', 1, ''),
            array('index', '子图索引位置', 0, '从0开始'),
        ),
    ),
);