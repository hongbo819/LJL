<?php 
    /**
     * 分页类(样式可根据项目更改)
     * @author cuihb
     */
     class Libs_Global_Page{
         
         public static $prev_class   = "former_no";
         public static $next_class   = "down";
         public static $number_class = "page_link";
         public static $curr_class   = "page_hover";
         public static $dian         = "...";
         
         public static function getPageString($paramArr){
             $options = array(
                 'page'      => 1,//当前页
                 'pageTotal' => 0,//总页数
                 'urlClass'  => '',//获取url的类
                 'urlFunc'   => '',//url方法
                 'args'      => array(),//传参
             );
             if (is_array($paramArr))$options = array_merge($options, $paramArr);
             extract($options);
             $page = $page > $pageTotal ? $pageTotal : $page;
             
             $prevPage  = ($page-1) > 1 ? ($page-1) : 1;
             $nextPage  = ($page+1) < $pageTotal ? ($page+1) : $pageTotal;
             
             $pageStr = '';
             
             
             
             $args['page'] = $prevPage;
             $prevUrl = $urlClass::$urlFunc($args);//上一页地址
             
             $args['page'] = $nextPage;
             $nextUrl = $urlClass::$urlFunc($args);//下一页地址
             
             $args['page'] = 1;
             $firstUrl = $urlClass::$urlFunc($args);//第一页地址
             
             $args['page'] = $pageTotal;
             $endUrl = $urlClass::$urlFunc($args);//最后一页地址
             	
             if($page != 1 && $pageTotal){
                 $pageStr .= '<a href="'.$prevUrl.'" class="'.self::$prev_class.'">上一页</a>';
             }
             
             $begin = 0; $end = 0;
             if($pageTotal == 1){
                 $pageStr = "<span>1</span>";
             }elseif($pageTotal <= 5){
                 $begin = 1;
                 $end   = $pageTotal;
             }else{
                 $begin = $page-2>1 ? $page-2 : ($page-1>1?$page-1:1);
                 $end   = $page+2<$pageTotal ? $page+2 : ($page+1<$pageTotal ? $page+1 : $pageTotal);
             }
             
            if($begin > 2){
				$pageStr .= "<a class='".self::$number_class."'  href='{$firstUrl}'>1</a>".self::$dian;
			}elseif($begin == 2){
				$pageStr .= "<a class='".self::$number_class."' href='{$firstUrl}'>1</a>";
			}
             
             if($begin > 0 && $end > 0){
                 for($begin;$begin <= $end;$begin++){
                     $args['page'] = $begin;
                     $curr_url     = $urlClass::$urlFunc($args);
                     
                     if($begin == $page){
                         $pageStr .= "<span class='".self::$curr_class."' >$begin</span>";
                     }else{
                         $pageStr .= "<a class='".self::$number_class."' href='{$curr_url}'>$begin</a>";
                     }
                 }
                 
                if($end+1 < $pageTotal){
					$pageStr .= self::$dian."<a class='".self::$number_class."' href='{$endUrl}'>$pageTotal</a>";
				}elseif($end+1 == $pageTotal){
					$pageStr .= "<a class='".self::$number_class."' href='{$endUrl}'>$pageTotal</a>";
	            }
             }
             	
             if($page != $pageTotal && $pageTotal){
                 $pageStr .= '<a href="'.$nextUrl.'" class="'.self::$next_class.'">下一页</a>';
             }
             return $pageStr;
             	
         }
     }
?>