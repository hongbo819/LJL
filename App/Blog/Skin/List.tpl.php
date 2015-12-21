        <?=$header?>
        <?=$navbarTpl?>
        <div class="wp" id="wp">
            <?=$navGuideTpl?>
            <div class="wp area2 cl cm_mb">
                <div class="a1L">
                    <div class="detail">
                        <div class="pclass cl" id="catbox">
                            <a href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$cate))?>" title="<?php if(!empty($cate)) echo $cateList[$cate][0];?>" <?php if(!$tag){?>class="y"<?php }?>>全部</a>
                            <?php if(isset($tagsArr) && !empty($tagsArr[$cate])){foreach($tagsArr[$cate] as $tagInfo){
                                ?>
                                <a href="<?=Blog_Plugin_Urls::getListUrl(array('cate'=>$cate,'tag'=>$tagInfo['tag']))?>" title="<?=$tagInfo['tag']?>" <?php if($tag==$tagInfo['tag']){?>class="y"<?php }?>><?=$tagInfo['tag']?></a>
                                <?php 
                            }}?>
                        </div>
                        <div class="content" style="min-height: 400px;">
                            <?php if($articleList){foreach($articleList as $articleInfo){?>
                                 <div class="plist">
    					            <div class="p_r">
    					              	<h2><a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['id']))?>" title="<?=strip_tags($articleInfo['title'])?>"><?=htmlspecialchars_decode($articleInfo['title'])?></a></h2>
    					              	<p>
    					              		<?php if($articleInfo['firstImgId']){
    					              		    $imgInfo = Helper_Blog::getPicInfo(array('picId'=>$articleInfo['firstImgId']));
    					              		    ?>
    					              		    <a href="<?=Blog_Plugin_Urls::getDetailUrl(array('articleid'=>$articleInfo['id']))?>" title="<?=$articleInfo['title']?>"><img src="<?=Helper_Blog::getPicWebPath(array(
    					              		        'imgName'=>$imgInfo['picName'],
    					              		        'imgExt'=>$imgInfo['picExt'],
    					              		        'time'=>$imgInfo['time'],
    					              		        'rootdir' => UPLOAD_IMG_PATH.'blog_'.APP_BLOG_NAME.'/',
    					              		        'size' => '110x66_'
    					              		    ))?>" width="50" height="50" alt="<?=$articleInfo['title']?>"></a>
    					              		    <?php 
    					              		}?><?=$articleInfo['descript']?>...
    									</p></div></div>
                           <?php }}else{?>
                               <div class="plist"><div class="p_r"><h2>暂无相关文章</h2></div></div>
                           <?php }?>
                        </div>
                        <div class="page">
                            <?=$pageStr?>
                        </div>
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
        <?=$footer?>