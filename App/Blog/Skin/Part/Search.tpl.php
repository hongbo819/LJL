<div class="hidden2 searchBlk">
    <form target="_blank" action="<?=Blog_Plugin_Urls::getIndexUrl(array());?>" autocomplete="off" method="get" id="scbar_form">
        <input type="hidden" name="c" value="list"></input>
        <input type="hidden" name="a" value="search"></input>
        <div class="search_goal">
            <p>
                <input type="text" autocomplete="off" class="search_goal_input" value="<?php if(empty($cate) && !empty($tag)){echo $tag;}?>" name="keyword">
            </p><input type="submit" value="搜索" class="search_goal_btn">
        </div>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="60">
                        <input type="radio" <?php if(!isset($type) || $type!='tags'){?>checked<?php }?> value="fulltext" id="sear1" name="type"><label for="sear1">全文</label>
                    </td>
                    <td>
                        <input type="radio" value="tags" <?php if(isset($type) && $type=='tags'){?>checked<?php }?> id="sear2" name="type"><label for="sear2">标签</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
