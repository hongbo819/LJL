<?php 
    $newList = Helper_Blog::getArticleList(array(
		        'fields'      => array('id', 'title'),//要查询的字段
		        'cate'        => $cate, //要查询的cate
		        'order'       => 'order by id desc',
		    ));
    //最近5天最热的
    $fiveDayHot = SYSTEM_TIME-5*24*3600;
    $hotList = Helper_Blog::getArticleList(array(
		        'fields'      => array('id', 'title'),//要查询的字段
		        'cate'        => $cate, //要查询的cate
		        'order'       => 'order by view desc',
                'updateTime'  => $fiveDayHot,
		    ));
    if(count($hotList) < 5){
        $hotList = Helper_Blog::getArticleList(array(
            'fields'      => array('id', 'title'),//要查询的字段
            'cate'        => $cate, //要查询的cate
            'order'       => 'order by view desc',
        ));
    }
    //最新评论文章
    $newComments = Helper_Blog::getCommentsArticles(array(
            'limit'       => '10',
        ));
    $newCommentsList = array();
    foreach((array)$newComments as $aid) {
        $newCommentsList[] = Helper_Blog::getArticleList(array(
            'fields'      => array('id', 'title'),//要查询的字段
            'articleid'        => $aid, //要查询的cate
        ))[0];
    }
    
?>
<?php if($newList){?>
<div class="yard cm_mb" style="margin-top:10px;">
    <div class="ydtitle">
        <h3>
            <?php if(!empty($cate)) echo $cateList[$cate][0];?>最新更新文章
        </h3>
    </div>
    <div class="ydcontent">
        <div style="margin-left: 2em" class="c5">
            <ul>
                <?php foreach($newList as $atcInfo){?>
                    <li>
                        <a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$atcInfo['id']))?>" title="<?=$atcInfo['title']?>"><?=$atcInfo['title']?></a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<?php }?>
<?php if($hotList){?>
<div class="yard cm_mb" style="margin-top:10px;">
    <div class="ydtitle">
        <h3>
            <?php if(!empty($cate)) echo $cateList[$cate][0];?>热门排行文章
        </h3>
    </div>
    <div class="ydcontent">
        <div style="margin-left: 2em" class="c5">
            <ul>
                <?php foreach($hotList as $atcInfo){?>
                    <li>
                        <a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$atcInfo['id']))?>" title="<?=$atcInfo['title']?>"><?=$atcInfo['title']?></a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<?php }?>
<?php if($newCommentsList){?>
<div class="yard cm_mb" style="margin-top:10px;">
    <div class="ydtitle">
        <h3>
            最新评论文章
        </h3>
    </div>
    <div class="ydcontent">
        <div style="margin-left: 2em" class="c5">
            <ul>
                <?php foreach($newCommentsList as $atcInfo){ ?>
                    <li>
                        <a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$atcInfo['id']))?>" title="<?=$atcInfo['title']?>"><?=$atcInfo['title']?></a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<?php }?>