<?php 
    if($cateList && $pageType!='List'){
        $tagsArr = array();
        foreach($cateList as $cateKey=>$cateV){
            $tagsArr[$cateKey] = Helper_Blog::getTags(array('cate'=>$cateKey));
        }
    }
?>

<?php if(defined('WEIBO_UID')){?>
    <div class="hidden yard cm_mb" style="margin-top:10px;">
        <div class="ydtitle"><h3><span style="color: #40AA53">About me</span></h3></div>
        <div class="ydcontent index_gtag">
            <iframe width="100%" height="22" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" border="0" src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&uid=<?=WEIBO_UID?>&style=3&btn=red&dpc=0"></iframe>
        </div> 
    </div>
<?php } ?>
        
<?php if($tagsArr){
    foreach($tagsArr as $cateid=>$tagArr){
        if(isset($cate) && $cateid === $cate && $pageType==='List') continue;
        if($tagArr){
            ?>
            <div class="yard cm_mb" style="margin-top:10px;">
                <div class="ydtitle">
                    <h3>
                        <a target="_blank" href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$cateid))?>"><?=$cateList[$cateid][0]?>热门标签</a>
                    </h3><a class="cm_go" target="_blank" href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$cateid))?>">更多>></a>
                </div>
                <div class="ydcontent index_gtag">
                    <?php foreach($tagArr as $tagInfo){
                        ?>
                        <a class="tag project" href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$cateid,'tag'=>$tagInfo['tag']))?>" title="<?=$cateList[$cateid][0]?> <?=$tagInfo['tag']?>"><?=$tagInfo['tag']?></a> 
                        <?php 
                    }?>
                </div>
            </div>
            <?php 
        }
    }
}?>