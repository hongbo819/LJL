<?php
$content = file_get_contents('/www/LJL/Html/Blog_cui/sitemap/tech.xml');
$xml = preg_match_all("/<loc>(.*?)<\/loc>/", $content, $matches, PREG_PATTERN_ORDER);
$urls = $matches[1];
//var_dump($urls);die;


//百度推送代码
//$urls = file('/www/LJL/Html/Blog_share/sitemap/dbms.xml');
$api = 'http://data.zz.baidu.com/urls?site=cui.zhbor.com&token=uBbANeNwCiuiDExt';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
?>