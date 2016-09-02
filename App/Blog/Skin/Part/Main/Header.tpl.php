<!doctype html>
<html>
    <head>
        <?=Libs_Global_PageHtml::getPageMeta($seoArr)?>
        <link href="<?=$_SFP?>css/style.css" type="text/css" rel="stylesheet">
        <?php if($pageType==='Detail'){?>
            <link type="text/css" rel="stylesheet" href="<?=$_SFP?>css/embed.default.css">
        <?php }?>
        <meta http-equiv="Cache-Control" content="no-transform" /> 
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes" />
        <style  >
            #wapfl{display:none;}
            @media(max-width:960px)
            {
	            body{width:100%}
                	.wp,#wp{width:95%;margin:0 auto;}
                	.hidden2{display:none;}
                #wapfl{display:block;margin:0 auto;width:95%;}
            	    #wapfl .active{background-color:red;}
            	    #ds-thread #ds-reset .ds-textarea-wrapper{padding-right:0px;}
	            #ds-thread #ds-reset .ds-comment-body p{width:78%}
                	#ft{width:95%;margin:0 auto;}
                	.ydtitle{padding: 0 0;}
                	.searchBlk{padding-top:10px;padding:1px;}
                	#wp div{width:100%}
	            #wp img{max-width:100%}
                	#wp table{max-width:95%}
                	#article_info {padding-bottom:27px;}
                	.search_goal p {width:80%}
                #wapfl ul{
                   float:left;
                }
                .tab_box ul li{width:71%}
                .tab_box ul li p.list_title{text-align:left}
                .model input{border:solid 1px}
                #wapfl li a {
	                float:left;
                    	background-color: #E0EAF1;
                    color: #3E6D8E;
                    font-size: 15px;
                    margin: 5px 15px 2px 0;
                    padding: 5px;
                    text-decoration: none;
                    white-space: nowrap;
                	    border-radius: 8px;
                    }
                #wapfl li{
	              
                }
            }
        </style>
    </head>
    <body>
