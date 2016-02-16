<?php
/**
* @version  v1.0
* @todo Icloud配置 http基本操作
*/
return array(
    'Base.Page.setExpires' => array(
        'name' => '设置页面的过期时间',
        'param'=> array(
            array('second', '过期时间', 1, '多少秒后过期，如86400'),
            array('point', '整点', 0, '设置一个时间，会到那个时间段的整点失效'),
            array('esi', '是否设置特殊头部', 0),
        ), 
    ),
    'Base.Page.createIpCk' => array(
        'name' => '新生成ipck，并且可以设置cookie中',
        'param'=> array(
            array('setCookie', '是否设置cookie', 0, '默认0：不设置 1：设置'),
        ), 
    ),
    'Base.Http.send404Header' => array(
        'name' => '设置404 Header信息',
        'param'=> array(
        ),
    ),
    'Base.Http.sendHeaderCode' => array(
        'name' => '设置各种码的header信息',
        'param'=> array(
            array('code', '返回码', 1, '404、302、304...'),
        ),
    ),
    'Base.Http.curlPage' => array(
        'name' => '利用curl的形式获得页面请求',
        'param'=> array(
            array('url', 'url', 1, '要请求的URL'),
            array('timeout', '超时时间 s', 0, ''),
            array('recErrlog', '是否记录错误日志', 0, '默认0'),
            array('reConnect', '是否出错后重连', 0, '默认0'),
            array('keepAlive', '是否执行保持长链接的处理', 0, '默认0：不 1：是'),
        ), 
    ),
    'Base.Http.curlPost' => array(
        'name' => '利用curl post数据',
        'param'=> array(
            array('url', 'url', 1, '要请求的URL'),
            array('postdata', 'POST的数据', 0, ''),
            array('timeout', '超时时间s', 0, ''),
        ), 
    ),
    'Base.Http.multiCurl' => array(
        'name' => '利用 curl_multi_** 的函数,并发多个请求',
        'param'=> array(
            array('urlArr', 'urlArr', 1, '要请求的URL数组'),
            array('timeout', '超时时间s', 0, ''),
        ), 
    ),
    'Service.FetchHtml.snoopyFetch' => array(
        'name' => 'snoopy抓取',
        'param'=> array(
            array('url', 'url', 1, '要抓取的站点'),
            array('agent', '使用的agent', 0, '默认1：普通用户 2：百度agent'),
            array('referer', 'referer', 0, '来路referer',),
            array('proxy', '是否使用代理', 0, '默认0'),
            array('maxredirs', '允许跳转的次数', 0, ''),
            array('header', '定制Header头儿', 0, ''),
            array('getredirect', '是否只要跳转后链接', 0, '默认0'),
        ), 
    ),
    'Service.FetchHtml.getHtmlOrDom' => array(
        'name' => '获得Dom操作对象',
        'param'=> array(
            array('url', 'url', 1, '要抓取的站点'),
            array('charset', '编码', 0, '默认utf-8'),
            array('timeout', '超时时间', 0, '默认 3 秒'),
            array('isGearman', '是否用Gearman', 0, '默认0'),
            array('getDom', '是否获得Dom', 0, '默认0'),
            array('snoopy', '是否使用snoopy', 0, '默认0'),
            array('fileGetContents', '是否用php函数抓取', 0, '默认0 不用file_get_content'),
            array('ungzip', '是否解压gzip', 0, '默认0'),
            array('referer', 'snoopy referer', 0, 'snoopy模拟referer'),
            array('proxy', '是否使用代理', 0, 'snoopy'),
            array('maxredirs', '允许跳转的次数', 0, '默认 6 次'),
            array('header', '定制Header头儿', 0, ''), 
        ), 
    ),
    'Service.FetchHtml.htmlToDom' => array(
        'name' => '将HTML字符串转为Dom',
        'param'=> array(
            array('htmlStr', 'html代码', 1, ''), 
        ), 
    ),
);