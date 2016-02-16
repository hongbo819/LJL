<head>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<link href="<?=$_SFP?>css/adminlist.css" type="text/css" rel="stylesheet">
</head>
<body>
<dl class="list_dl">
<dd>
<form action="" method="get">
<input type="hidden" name="c" value="admin" />
<input type="hidden" name="a" value="list" /> 
<input type="text" name="articleid" value="<?=$articleid?>" placeholder="查询：输入文章id" />
<input type="submit"/> <a href="javascript:void(history.go(-1))">返回</a>
</form>
</dd>
<dt><b>文章列表</b><a href="<?=Blog_Plugin_Urls::getAdminEditUrl(array())?>" class="more">>>发布新文</a></dt>
    <dd>
        <ul>
            <?php 
                if($articleList){
                    foreach($articleList as $val){
                        ?>
                        <li>
                            <span><a target="_blank" href='<?=Blog_Plugin_Urls::getAdminEditUrl(array('articleid'=>$val['id']))?>'>修改</a></span>
                            <?php if($val['isPublished']==0){?><span>未发布</span><?php }else{?><span>&nbsp;&nbsp;&nbsp;</span><?php }?>
                            <span><?=date("Y-m-d H:i:s", $val['insertTime'])?></span><a class="link1">[<?=$val['cate']?>]</a>
                            <a target="_blank" href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$val['id']))?>"><?=$val['title']?></a>
                        </li>
                        <?php 
                    }
                }
            ?>
            <p class="page"><?=$pageStr?></p>
        </ul>
    </dd>
</dl>
</body>
</html>