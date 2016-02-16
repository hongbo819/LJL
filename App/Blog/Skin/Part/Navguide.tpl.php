<div id="dongtai">
    <div class=" a1L">
        <div class="keyword" id="curlocal">
            当前位置：
            <?php 
                foreach($nav as $val){
                    if(isset($val['url'])){
                        ?><a href="<?=$val['url']?>"><?=$val['title']?></a> &gt; <?php 
                    }else{
                        echo ' '.$val['title'];
                    }
                }
            ?>
        </div>
    </div>
    <div class=" a1R">
        <div class="bdsharebuttonbox" data-tag="share_1">
        	<a class="bds_tsina" data-cmd="tsina"></a>
        	<a class="bds_weixin" data-cmd="weixin"></a>
        	<a class="bds_qzone" data-cmd="qzone"></a>
        	<a class="bds_tqq" data-cmd="tqq"></a>
        	<a class="bds_tieba" data-cmd="tieba"></a>
        	<a class="bds_more" data-cmd="more">更多</a>
        </div>
    </div>
</div>