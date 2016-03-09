        <?=$header?>
        <?=$navbarTpl?>
        <div class="wp" id="wp">
            <?=$navGuideTpl?>
            <div class="wp area2 cl cm_mb">
                <div class="a1L">
                    <div class="detail">
                        <h1 class="detail_title">
                            <?php if($articleInfo['source'] && APP_BLOG_NAME !== 'share'){?><span>【收藏】</span><?php }?><a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['id']))?>" title="<?=htmlspecialchars_decode($articleInfo['title'])?>"><?=htmlspecialchars_decode($articleInfo['title'])?></a>
                        </h1>
                        <ul class="cl" id="article_info">
                            <li>分类：<b><a href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$articleInfo['cate']))?>" target="_blank" title="<?=$cateList[$articleInfo['cate']][0]?>" class="category"><?=$cateList[$articleInfo['cate']][0]?></a></b></li>
                            <?php if($articleTags[0]){?>
                            <li>本文标签：
                                <?php foreach($articleTags as $val){?>
                                        <b><a href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$articleInfo['cate'], 'tag'=>$val))?>" target="_blank" title="<?=$val?>" class="category"><?=$val?></a></b>
                                <?php  }?>
                            </li>
                            <?php }?>
                            <li>发布时间：<b><?=date('Y-m-d H:i:s', $articleInfo['insertTime'])?></b></li>
                            <?php if(!$articleInfo['source']){?>
                            <li>作者：<b><?=BLOG_WEB_NAME?></b></li>
                            <?php }?>
                            <li>查看数: <b><?=$articleInfo['view']?></b></li>
                        </ul>
                        <div class="content" id="content">
                            <?=htmlspecialchars_decode($articleInfo['content'])?>
                            <?php if($articleInfo['source']){?>
                                <?php if(APP_BLOG_NAME === 'share'){?>
                                <p>文章来源于网络</p>
                                <?php }else{?>
                                <p>转自：<span><?=$articleInfo['source']?></span></p>
                                <?php }?>
                            <?php }?>
                        </div>
                        <p style="padding:5px;border:3px solid #009933;background:#F7F7F7">
                            转载时请以 超链接的形式 注明：转自<a href="<?=WWW_WEB?>" title="<?=BLOG_WEB_NAME?>"><?=BLOG_WEB_NAME?></a>
                        </p>
                        <div class="detail_description">
                            <table style="margin:20px 0px;">
                                <tbody>
                                    <tr><td colspan="2">
                                        <div class="bdsharebuttonbox" data-tag="share_1">
                                        	<a class="bds_tsina" data-cmd="tsina"></a>
                                        	<a class="bds_weixin" data-cmd="weixin"></a>
                                        	<a class="bds_qzone" data-cmd="qzone"></a>
                                        	<a class="bds_tqq" data-cmd="tqq"></a>
                                        	<a class="bds_tieba" data-cmd="tieba"></a>
                                        	<a class="bds_more" data-cmd="more">更多</a>
                                        	<a class="bds_count" data-cmd="count"></a>
                                        </div>
                                    </td></tr>
                                    <tr>
                                        <td height="30" width="360">
                                            上一篇：<?php if($prevNext[0]){?><a href="<?=$prevNext[0][0]['url']?>"><?=$prevNext[0][0]['title']?></a><?php }else{echo '暂无';}?>
                                        </td>
                                        <td height="30">
                                            下一篇：<?php if($prevNext[1]){?><a href="<?=$prevNext[1][0]['url']?>"><?=$prevNext[1][0]['title']?></a><?php }else{echo '暂无';}?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="clear:both"></div>
                        <?=$commentTpl?>
                    </div>
                </div>
                <div class="a1R">
                    <?=$searchTpl?>
                    <?=$leftsideCate?>
                    <?=$newArticleTpl;?>
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
        <link type="text/css" rel="stylesheet" href="<?=$_SFP?>ueditor/third-party/SyntaxHighlighter/shCoreDefault.css">
        <script type="text/javascript" src="<?=$_SFP?>ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
        <script type="text/javascript">SyntaxHighlighter.all();</script>
        <?php if(APP_BLOG_NAME === 'share'){?>
        <link type="text/css" rel="stylesheet" href="<?=$_SFP?>css/csdnlighter.css">
        <?php }?>
        <?=$footer?>