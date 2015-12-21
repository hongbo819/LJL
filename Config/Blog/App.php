<?php 
    if(IS_PRODUCTION){
        return array(
            'staticPath' => 'http://static.cuihongbo.com/',
        );
    }else{
        return array(
            'staticPath' => 'http://static-de.cuihongbo.com/',
        );
    }
?>