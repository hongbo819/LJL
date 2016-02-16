<?php 
//solr 配置
//项目中用到
if(defined('APP_BLOG_NAME')){
    return array(
        'SOLR' => array(
            'url'=>'http://localhost:8983/solr/'.APP_BLOG_NAME.'_blog',
        ),
    );
//自动运行程序用到
}else{
    return array(
        'SOLR' => array(
            'url'=>'http://localhost:8983/solr/xxx_blog',
        ),
    );
}

