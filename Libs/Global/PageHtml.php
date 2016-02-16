<?php
/**
* 本文件存放所有与页面HTML相关的函数
* @version v1.0
*/
class Libs_Global_PageHtml
{
    /**
    * 获得页面的Meta信息
    *
    * @param array $paramArr 参数数组
    * @return string 返回所有的meta标签
    * @example $paramArr = array(
    *                  'title'=>$seo['title'],
    *                  'keywords'=>$seo['keywords'],
    *                  'description'=>$seo['description'],
    *             );
    *             echo Libs_Global_PageHtml::getPageMeta($paramArr);
    */
    public static function getPageMeta($paramArr) {
        if (is_array($paramArr)) {
			$options = array(
				'noFollow' => 0,#是否允许搜索引擎抓取
                'noCache'=>0,#是否缓存
                'chartSet'=>'UTF-8',#默认字符集
                'pageType'=>'',#页面类型，暂时没用到
                'title'=>'',#页面标题
                'keywords'=>'',#页面关键字
                'description'=>'',#页面表述
			);
			$options = array_merge($options, $paramArr);
			extract($options);
		}
        $metaStr="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$chartSet."\" />\n";
        //$metaStr.="<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />\n";
         if($noFollow){
            $metaStr.="<meta name=\"ROBOTS\" content=\"NOINDEX, NOFOLLOW\" />\n";
        }
        if($noCache){
            $metaStr.="<meta http-equiv=\"pragma\" content=\"no-cache\" />\n";
        }
        $metaStr.="<title>".$title."</title>\n";
        if($keywords){
            $metaStr.="<meta name=\"keywords\" content=\"".$keywords."\" />\n";
        }
        if($description){
            $metaStr.="<meta name=\"description\" content=\"".$description."\" />\n";
        }
        return $metaStr;
    }


}
