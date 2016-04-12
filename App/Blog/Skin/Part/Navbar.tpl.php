<div id="header">
    <div class="wp cl">
        <h2 id="logo">
            <a href="<?=WWW_WEB?>" title="<?=BLOG_WEB_NAME?>"><?=BLOG_WEB_NAME?></a>
        </h2>
        <ul id="w3cnav" class="hidden2 cl">
            <li <?php if(empty($cate)){?>class="active"<?php }?>>
                <a href="<?=WWW_WEB?>" title="">首页</a>
                <i></i>
            </li>
            <?php 
                if($cateList){
                    foreach($cateList as $key=>$val){
                        $url = Blog_Plugin_Urls::getListUrl(array('cate'=>$key));
                        ?>
                         <li <?php if(isset($cate) && $key==$cate){?>class="active"<?php }?>>
                            <a href="<?=$url?>"><?=$val[0]?></a>
                            <i></i>
                        </li>
                        <?php
                    }
                }
            ?>
        </ul>
        <div id="login-button"><a href="javascript:;" onclick="showAll('#model', 'showlogin')">登陆</a> <a href="javascript:;" onclick="showAll('#model', 'showregister')">注册</a></div>
    </div>
</div>
<ul id="wapfl" class="cl">
            <li <?php if(empty($cate)){?>class="active"<?php }?>>
                <a href="<?=WWW_WEB?>" title="">首页</a>
                <i></i>
            </li>
            <?php 
                if($cateList){
                    foreach($cateList as $key=>$val){
                        $url = Blog_Plugin_Urls::getListUrl(array('cate'=>$key));
                        ?>
                         <li <?php if(isset($cate) && $key==$cate){?>class="active"<?php }?>>
                            <a href="<?=$url?>"><?=$val[0]?></a>
                            <i></i>
                        </li>
                        <?php
                    }
                }
            ?>
        </ul>