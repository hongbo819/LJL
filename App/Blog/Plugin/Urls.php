<?php 
    /**
     * blog 项目相关url
     * @author cuihb
     */
    class Blog_Plugin_Urls{
        /**
         * 首页url
         */
        public static function getIndexUrl($paramArr){
            $options = array(
                'page' => 0,
            );
            if (is_array($paramArr))$options = array_merge($options, $paramArr);
//             $args = self::_formatQueryString($options);
//             return WWW_WEB.'index.php?c=default&a=default'.$args;
            if($options['page']){
                return WWW_WEB.'page/'.$options['page'].'/';
            }else{
                return WWW_WEB;
            }
        }
        /**
         * 列表页 url
         */
        public static function getListUrl($paramArr) {
            $options = array(
				'cate' => '', #
				'tag'  => '', #
				'page' => 1,
			);
			if (is_array($paramArr))$options = array_merge($options, $paramArr);
			
// 			$args = self::_formatQueryString($options);
// 			return WWW_WEB.'index.php?c=list&a=default'.$args;
			if(!$options['cate']){
			    return WWW_WEB;
			}elseif(!$options['tag']){
			    return WWW_WEB."list/{$options['cate']}/{$options['page']}/";
			}else{
			    //if(false !== strpos($options['tag'], '#'))
			    $options['tag'] = urlencode($options['tag']);
			    return WWW_WEB."list/{$options['cate']}/{$options['tag']}/{$options['page']}/";
			}
			
        }
        /**
         * 详情页url
         */
        public static function getDetailUrl($paramArr){
            $options = array(
                'articleid' =>  0, #
            );
            if (is_array($paramArr))$options = array_merge($options, $paramArr);
//             $args = self::_formatQueryString($options);
//             return WWW_WEB.'index.php?c=detail&a=default'.$args;
            return WWW_WEB.'article/'.$options['articleid'].'.html';
        }
        /**
         * 搜索页url
         */
        public static function getSearchUrl($paramArr){
            $options = array(
                'type' => '', #
                'keyword'  => '', #
                'page' => 0,
            );
            if (is_array($paramArr))$options = array_merge($options, $paramArr);
            	
            $args = self::_formatQueryString($options);
            	
            return WWW_WEB.'index.php?c=list&a=search'.$args;
        }
        
        /**
         * 后台文章列表页url
         */
        public static function getAdminListUrl($paramArr){
            $options = array(
                'page' =>  1, #
            );
            if (is_array($paramArr))$options = array_merge($options, $paramArr);
            $args = self::_formatQueryString($options);
            return WWW_WEB.'index.php?c=admin&a=list'.$args;
        }
        
        /**
         * 后台文章编辑页url
         */
        public static function getAdminEditUrl($paramArr){
            $options = array(
                'articleid' =>  0, #
            );
            if (is_array($paramArr))$options = array_merge($options, $paramArr);
            $args = self::_formatQueryString($options);
            return WWW_WEB.'index.php?c=admin&a=default'.$args;
        }
        
        /**
         * 搜索字段格式化
         * date 2015-06-01
         * @author cuihb
         */
        private static function _formatQueryString($param){
            $returnStr  = '';
            if(is_array($param)){
                foreach($param as $key=>$val){
                    if(!$val) continue;
                    $returnStr .= '&'.$key.'='.$val;
                }
            }
            return $returnStr;
        }
    }
?>