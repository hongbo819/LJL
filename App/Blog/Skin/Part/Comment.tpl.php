<?php $commentsList = Helper_Blog::getCommentsList(array('articleId'=>$articleInfo['id']));?>
<div id="comment" articleId="<?=$articleInfo['id']?>" class="bm vw pl">
    <div class="ds-thread" id="ds-thread">
        <div id="ds-reset">
            <div class="ds-comments-info">
                <div class="ds-sort">
<!--                     <a class="ds-order-desc">最新</a><a class="ds-order-asc ds-current">最早</a><a class="ds-order-hot">最热</a> -->
                </div>
                <ul class="ds-comments-tabs">
                    <li class="ds-tab">
                        <a class="ds-comments-tab-duoshuo ds-current" href="javascript:void(0);"><span class="ds-highlight"><?=count($commentsList)?></span>条评论</a>
                    </li>
                </ul>
            </div>
            <ul class="ds-comments">
                <?php if($commentsList){foreach($commentsList as $val){?>
                <li class="ds-post">
                    <div class="ds-post-self">
                        <div class="ds-avatar">
                            <?php 
                            $apiuerInfo = Helper_User::getApiUserInfo(array('apiname'=>$val['user']));
                            $headImg = $apiuerInfo ? $apiuerInfo['api_headimg'] : $_SFP.'images/noavatar_default.png';
                            ?>
                            <img src="<?=$headImg?>" alt="<?=$val['user']?>">
                        </div>
                        <div class="ds-comment-body">
                            <div class="ds-comment-header">
                                <span class="ds-user-name"><?=$val['user']?></span>
                            </div>
                            <p><?=$val['comment']?></p>
                            <div class="ds-comment-footer ds-comment-actions" user="<?=$val['user']?>" commentId="<?=$val['id']?>">
                                <span class="ds-time"><?=Blog_Plugin_Common::timestampToTime($val['time'])?></span><a class="ds-post-reply" href="javascript:void(0);">回复</a><a class="ds-post-likes" href="javascript:void(0);">顶(<?=$val['zan']?>)</a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php }}?>
            </ul>
            <div style="cursor:pointer;margin-top:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="face1" src="<?=$_SFP?>images/face.gif"></div>
            <div class="ds-replybox">
                <a class="ds-avatar"><img src="<?=$_SFP?>images/noavatar_default.png"></a>
                <form>
                    <div class="ds-textarea-wrapper ds-rounded-top">
                        <textarea id="message" name="message" placeholder="说点什么吧…"></textarea>
                    </div>
                    <div class="ds-post-toolbar">
                        <div class=" faceBtn ds-post-options ds-gradient-bg"></div><button class="ds-post-button" type="submit">发布</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>