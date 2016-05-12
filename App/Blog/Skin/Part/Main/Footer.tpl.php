        <div id="ft">
            <div id="footer" class="wp cl">
                <h6>
                    <a href="<?=WWW_WEB?>" title="<?=BLOG_WEB_NAME?>"><?=BLOG_WEB_NAME?></a>
                </h6>
                <div id="copyright">
                    <p>
                        Copyright © <a target="_blank" href="<?="http://www.".Blog_Plugin_Common::getHost()?>"><?=Blog_Plugin_Common::getHost()?></a> 京ICP备15048235号
                    </p>
                    <p>
                        想拥有自己专业的独立博客站，请点击<a target="_blank" href="<?="http://www.".Blog_Plugin_Common::getHost()."/index.php?c=apply"?>"> 开通博客 </a>或者联系：hongbo819@163.com
                    </p>
                </div>
            </div>
        </div>
        <div class="go-top">
            <div class="arrow"></div>
            <div class="stick"></div>
        </div>
        <?php if($pageType!=='webHome'){?>
            <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7/jquery.min.js"></script>
            <script type="text/javascript">
            	var mainPage = "<?=WWW_WEB?>";
            	var staticPage = "<?=$_SFP?>";
            	if (!window.jQuery) {
            		var script = document.createElement('script');
            		script.src = "<?=$_SFP?>js/jquery-1.7.1.min.js";
            		document.body.appendChild(script);
            	}
            </script>
            <script type="text/javascript" src="<?=$_SFP?>js/login.js"></script>
            <?php if($pageType == 'Detail'){?>
                <script type="text/javascript" src="<?=$_SFP?>js/jquery.qqFace.min.js"></script>
                <script type="text/javascript" src="<?=$_SFP?>js/comment.js"></script>
                <script>$.get("<?=WWW_WEB?>index.php?c=ajax_Article&a=addview&articleid=<?=$articleInfo['id']?>")</script>
            <?php }elseif($pageType == 'List' && $tag){?>
                <script>$.get("<?=WWW_WEB?>index.php?c=ajax_Article&a=addtagview&tag=<?=$tag?>&cate=<?=$cate?>")</script>
            <?php }?>
            <script>
                	//具体的参数以及意义可以参照百度分享官网share.baidu.com
                	window._bd_share_config={"common":{"bdText":document.title,"bdDesc":document.description,"bdUrl":window.location.href,"bdPic":"","bdSize":24},share:{}};
                	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
                	//向上滚动
            		$(function() {
            			$(window).scroll(function() {
            				if ($(window).scrollTop() > 1000)
            					$('div.go-top').show();
            				else
            					$('div.go-top').hide();
            			});
            			$('div.go-top').click(function() {
            				$('html, body').animate({scrollTop: 0}, 500);
            			});
            		});
            	</script>
        <?php }?>
        <?php if($pageType == "Default" && $showImgs) {?>
            <script>
            var imgScroll = function() {
                   var imgs = $("#img-scroll img");
                   var imgNum = imgs.length, preActive=0;
                   if(imgNum == 1){
               	        imgs.eq(0).addClass('active');
               	        return;
                   } 
                   if(imgNum < 2) return;
                   for(var i=0; i<imgNum; i++) {
                       if(imgs.eq(i).hasClass('active')) {
                   	      var preActive = i;
                      	   imgs.eq(i).slideUp().removeClass('active');
                       }
                   }
                   var nowActive = preActive == imgNum-1 ? 0 : preActive+1;
                   imgs.eq(nowActive).addClass('active').fadeIn();
                }
            setInterval("imgScroll()",3000);
            </script>
        <?php }?>
	<div style="display:none"><script src="http://s4.cnzz.com/z_stat.php?id=1256391835&web_id=1256391835" language="JavaScript"></script></div>
    </body>
</html>
