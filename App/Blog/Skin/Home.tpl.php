        <?=$header?>
        <div id="header">
            <div class="wp cl">
                <h2 id="logo">
                    <a href="<?=WWW_WEB?>" title="<?=BLOG_WEB_NAME?>"><?=BLOG_WEB_NAME?></a>
                </h2>
                <span style="color:white;position:relative;left:-75px;top:20px;">--让你拥有自己专业的独立博客站</span>
            </div>
        </div>
        <div class="wpmain" id="wp">
            <div class="wp area2 cl cm_mb">
                <div class="cm_L">
                    <div class="news_nav">
                        <div class="subbar2 wp">
                            <h1 style="width:280px;">
                                最热博文
                            </h1>
                            <div class="tab_box">
                                <div class="news_list">
                                    <div class="widget">
                                        <ul>
                                            <?php if($hotList){
                                                foreach($hotList as $articleInfo){?>
                                                    <li>
                                                        <a href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], Blog_Plugin_Urls::getListUrl(array('cate'=>$articleInfo['cate'])));?>" target="_blank" title="<?=$articleInfo['cateVal']?>">[<?=$articleInfo['cateVal']?>]</a> 
                                                        <a href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['articleId'])));?>" target="_blank" title="<?=$articleInfo['title']?>" class="title"><?=API_Item_Base_String::getShort(array('str'=>$articleInfo['title'],'length'=>12,))?>...</a><span><?=date('m-d',$articleInfo['publishTime'])?></span>
                                                    </li>
                                            <?php } }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div class="news_nav" style="margin-top:20px;">
                        <div class="subbar3 wp">
                            <h1 style="width:280px;">
                                最新博文
                            </h1>
                            <div class="tab_box">
                                <div class="news_list">
                                    <ul>
                                        <?php if($newList){
                                            foreach($newList as $articleInfo){?>
                                                <li>
                                                    <a href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], Blog_Plugin_Urls::getListUrl(array('cate'=>$articleInfo['cate'])));?>" target="_blank" title="<?=$articleInfo['cateVal']?>">[<?=$articleInfo['cateVal']?>]</a> 
                                                    <a href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['articleId'])));?>" target="_blank" title="<?=$articleInfo['title']?>" class="title"><?=API_Item_Base_String::getShort(array('str'=>$articleInfo['title'],'length'=>12,))?>...</a><span><?=date('m-d',$articleInfo['publishTime'])?></span>
                                                </li>
                                        <?php } }?>
                                    </ul>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="cm_M">
                    <div class="news_nav">
                        <div class="subbar wp">
                            <h1>
                                给你推荐的博文
                            </h1>
                            <div class="tab_box">
                                <ul>
                                    <?php if($recommendList){
                                        foreach($recommendList as $articleInfo){?>
                                            <li>
                                                <h2>
                                                    <a target="_blank" href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['articleId'])));?>" title="<?=$articleInfo['title']?>"><?=$articleInfo['title']?></a>
                                                </h2>
                                                <p><?=$articleInfo['descript']?>...</p>
                                                <p class="list_title">发布于：<?=date('m-d H:i', $articleInfo['publishTime'])?>&nbsp;&nbsp;<a href="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], WWW_WEB)?>" target="_blank" title="<?=str_replace(APP_BLOG_NAME, $articleInfo['webSite'], WWW_WEB)?>"><?=str_replace(array(APP_BLOG_NAME,'http://'), array($articleInfo['webSite'],''), rtrim(WWW_WEB,'/'))?></a>
                                                </p>
                                            </li>
                                    <?php } }?>
                                </ul>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div class="cm_R">
                    <div class="yard cm_mb" style="margin-top:10px;">
                        <div class="ydtitle">
                            <h3 style="color: #40AA53">
                                博主排行榜--最红博
                            </h3>
                        </div>
                        <div class="ydcontent index_gtag">
                            <div>
                            <?php if($bloggerList){ foreach($bloggerList as $blogger){?>
                                <a class="tag noback" href="<?=str_replace(APP_BLOG_NAME, $blogger['webSite'], WWW_WEB)?>" target="_blank" title="<?=$blogger['webName']?>"><?=$blogger['webName']?></a>
                            <?php }}?>
                            </div>
                        </div>
                    </div>
                    <!--  <div style="margin-top:10px;" class="yard cm_mb">
                        <div class="ydtitle">
                            <h3>
                                友情链接
                            </h3>
                        </div>
                        <div class="ydcontent index_gtag">
                            <a target="_blank">xxxxxx</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
        <?=$footer?>