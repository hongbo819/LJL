<?php 
    if(IS_PRODUCTION){
        return array(
            'staticPath' => 'http://static.zhbor.com/',
        );
    }else{
        return array(
            'staticPath' => 'http://static-de.zhbor.com/',
        );
    }
?>