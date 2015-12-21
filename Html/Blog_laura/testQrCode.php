<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//phpinfo();die;
	//输出二维码
	require('/APILJL/Api.php');
	#域名限制
	$size_limit = array(100,50,70);
	#获取参数
	$url = "www.baidu.com";
	/*$url = isset($_GET ['url'])? trim ( $_GET ['url'] ) :false;
	if(!$url){
		echo ' param error ';
		exit();
	}*/
	$size = intval($_GET['size']);
	$size = $size?$size:100;
	if(!in_array($size,$size_limit)){
		echo ' param error ';
		exit();
	}
	
	$qrImg = LJL_Api::run("Image.QrCode.getQrCode" , array(
		'string'         => $url,   #二维码的字符串内容\	
		'size'           => $size,              #尺寸
	    'margin' => false,   #外边距
	    'color' => '#AEC7E1',       #颜色值
	    'logoFile' => '/www/LJL/Html/Blogstaticfile/images/404.png',    #logo图片文件地址
	    'logoWidth' => 0,    #logo图片的大小，默认为 二维码 的五分之一 即（size-2*margin）/5
	));
	Header ( "Content-type: image/png" );
	ImagePng ( $qrImg );
	ImageDestroy ( $qrImg );
	exit ();
	