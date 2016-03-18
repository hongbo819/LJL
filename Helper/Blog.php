<?php
    /**
     * blog业务相关
     * @author cuihb
     */
	class Helper_Blog extends Helper_Abstract{
	    /**
	     * 插入文章信息
	     * @param unknown $paramArr
	     */
		public static function insertArticleInfo($paramArr){
			$options = array(
				'insertData'       =>  array(), #array('name'=>'cuihb');
			);
			if (is_array($paramArr))$options = array_merge($options, $paramArr);
			extract($options);
			
			$contentKey = array_key_exists('content', $insertData);
			if($contentKey){
			    $content = $insertData['content'];
			    unset($insertData['content']);
			}
			
			$imgKey = array_key_exists('imgArr', $insertData);
			if($imgKey){
			    $imgArr = $insertData['imgArr'];
			    unset($insertData['imgArr']);
			}
			
			$formatData = self::setInsertCondition($insertData);
			$sql = "insert into blog_article_info({$formatData['fileds']}) values({$formatData['values']})";
			//echo $sql;die;
			$db = Db_Blog::instance();
			$db->query($sql);
			$articleId = $db->lastInsertId();
			if($contentKey){
			    $sql = "insert into blog_article_content(articleId, content) values('{$articleId}', '{$content}')";
			    //echo $sql;die;
			    $db->query($sql);
			    
			}
			if(is_array($imgArr)){
			    foreach($imgArr as $imgId){
			        self::updatePic(array(
			            'imgId'=>$imgId,
			            'updateData'=>array('articleId'=>$articleId),
			        ));
			    }
			}
			
			return $articleId;
		}
		/**
		 * 查询文章列表
		 */
		public static function getArticleList($paramArr){
		    $options = array(
		        'page'        => 1,//当前页
		        'pageSize'    => 10,//limit
		        'fields'      => array(),//要查询的字段或者以 英文'，'分开
		        'cate'        => '', //要查询的cate
		        'tag'         => '',//要查询的tag
		        'isPublished' => 1, //查询添加是否已发布
		        'articleid'   => 0,
		        'updateTime'  => 0, //查询大于该时间
		        'isCount'     => 0, //是否是查询总数  
		        'order'       => 'order by insertTime desc',
		    );
		    //var_dump($options);die;
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if($tag)//如果有标签则需要从标签表中查询文章
		        return self::_getArticleListByTag($options);
		    
		    if(!is_array($fields)) $fields = explode(',', $fields);
		    $formatData = self::setSelectField($fields);
		    $limit      = ' limit '.($page-1)*$pageSize.','.$pageSize;
		    
		    if($isPublished){
		        $where = ' where isPublished=1 ';
		    }else{
		        $where = ' where 1=1 ';
		    }
		    if($articleid)
		        $where .= " and id={$articleid} ";
		    
		    if($cate)
		        $where .= " and cate='{$cate}' ";
		    if($updateTime)
		        $where .= " and updateTime>'{$updateTime}' ";

		    $db = Db_Blog::instance();
		    if($isCount){
		        $sql = "select count(*) from blog_article_info {$where}";
		        return $db->getOne($sql);
		    }
		    
		    $sql = "select {$formatData} from blog_article_info {$where} {$order} {$limit}";
		    //echo $sql;die;
		    //var_dump($db->getAll($sql));die;
		    return $db->getAll($sql);
		}
		/**
		 * 根据标签来查询文章的列表
		 */
		private static function _getArticleListByTag($paramArr){
		    $options = array(
		        'page'     => 1,//当前页
		        'pageSize' => 10,//limit
		        'fields'   => array(),//要查询的字段
		        'cate'     => '', //要查询的cate
		        'tag'      => '',//要查询的tag
		        'isPublished' => 1,
		        'isCount'     => 0, //是否是查询总数
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $formatData = self::setSelectField($fields);
		    $limit      = ' limit '.($page-1)*$pageSize.','.$pageSize;
		   
		    $where = ' where 1=1 ';
		    
		    if($cate)
		        $where .= " and cate='{$cate}' ";
		    if($tag)
		        $where .= " and tag='{$tag}' ";
		    
		    $db = Db_Blog::instance();
		    if($isCount){
		        $sql = "select count(*) from blog_tags {$where}";
		        return $db->getOne($sql);
		    }
		    
		    $sql = "select articleId from blog_tags {$where} order by updateTime desc {$limit}";
		    $articleIds = $db->getCol($sql);
		    return self::getArticleInfos(array(
		        'articleIds' => $articleIds,
		        'fields'     =>  array('id', 'firstImgId', 'title', 'descript'), 
		    ));
		}
		/**
		 * 根据文章idArr取文章信息 
		 */
		public static function getArticleInfos($paramArr){
		    $options = array(
		        'articleIds' => array(),
		        'fields'     =>  array(), #array('name'=>'cuihb')
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $out = array();
		    if($articleIds){
		        foreach($articleIds as $key=>$aid){
		            $out[$key] = self::getArticleInfo(array(
        		        'articleId'     => $aid, #文章id
        		        'fileds'        => $fields, #要查询的字段
        		    ));
		        }
		    }
		    return $out;
		}
		/**
		 * 修改文章基本信息
		 */
		public static function updateArticleInfo($paramArr){
		    $options = array(
		        'articleId'   => 0,
		        'updateData'  =>  array(), #array('name'=>'cuihb')
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if(!$articleId) return false;
		    
		    $contentKey = array_key_exists('content', $updateData);
		    if($contentKey){
		        $content = $updateData['content'];
		        unset($updateData['content']);
		    }
		    
		    $imgKey = array_key_exists('imgArr', $updateData);
		    $imgArr = array();
		    if($imgKey){
		        $imgArr = $updateData['imgArr'];
		        unset($updateData['imgArr']);
		    }
		    
		    $formatData = self::setUpdateCondition($updateData);
		    $sql = "update blog_article_info set {$formatData} where id='{$articleId}'";
		    $db = Db_Blog::instance();
		    $res = $db->query($sql);
		    
		    if($contentKey){
		        $sql = "update blog_article_content set content='{$content}' where articleId='{$articleId}'";
		        $res = $db->query($sql);
		    }
		    if(is_array($imgArr)){
		        foreach($imgArr as $imgId){
		            self::updatePic(array(
		                'imgId'=>$imgId,
		                'updateData'=>array('articleId'=>$articleId),
		            ));
		        }
		    }
		    return $res;
		}
		/**
		 * 查询文章信息，可查询content
		 */
		public static function getArticleInfo($paramArr){
		    $options = array(
		        'articleId'     => 0, #文章id
		        'fileds'        =>  array(), #要查询的字段
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    if(!is_array($fileds)) $fileds = explode(',', $fileds);
		    $contentKey = array_search('content', $fileds);
		    if($contentKey)
		        unset($fileds[$contentKey]);
		    
		    $filedStr = self::setSelectField($fileds);
		    $sql = "select {$filedStr} from blog_article_info where id='{$articleId}'";
		    $db = Db_Blog::instance();
		    $res =  $db->getRow($sql);
		    
		    if($contentKey){
		        $sql = "select content from blog_article_content where articleId='{$articleId}'";
		        $res['content'] = $db->getOne($sql);
		    }
		    return $res;
		}
		/**
		 * 获取上n篇/下n篇文章
		 */
		public static function getPreNextArticle($paramArr){
		    $options = array(
		        'articleId' => 0,//文章id
		        'fileds'    => array(),//要查询的字段
		        'limit'     => 1,//上下多少篇
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    $filedStr = self::setSelectField($fileds);
		    
		    $sqlPrev = "select {$filedStr} from blog_article_info where id<{$articleId} and isPublished=1 order by id desc limit {$limit}";
		    $sqlNext = "select {$filedStr} from blog_article_info where id>{$articleId} and isPublished=1 limit {$limit}";
		    $db = Db_Blog::instance();
		    
		    return array($db->getAll($sqlPrev), $db->getAll($sqlNext));
		}
		/**
		 * 文章浏览数加1
		 */
		public static function addArticleView($articleId) {
		    if(!$articleId) return false;
		    
		    $sql = "update blog_article_info set view=view+1 where id='{$articleId}'";
		    $db = Db_Blog::instance();
		    $res = $db->query($sql);
		}
		/**
		 * 根据文章cate、title确人库中是否已经有了该文章的信息(之所以不用联合唯一索引1、多个库已经存在2、属于常写入类型表3、报错不友好)
		 */
		public static function ishasArticle($cate='', $title='', $url='') {
		    $where = " where 1=1 ";
		    if($title)
		        $where .= " and title='{$title}' ";
		    if($cate) 
		        $where .= " and cate='{$cate}' ";
		    if($url)
		        $where .= " and source='{$url}' ";
		    $sql = "select id from blog_article_info {$where}";
		    $db = Db_Blog::instance();
		    if($db->getOne($sql)){
		        return true;
		    }
		    return false;
		}
		/**
		 * ++++++++++++++++++++++++图片表相关操作+++++++++++++++++++++++
		 */
		/**
		 * 图片表中插入图片
		 * @param unknown $paramArr
		 */
		public static function insertPic($paramArr){
		    $options = array(
		        'articleId' => 0,
		        'picName'       =>  '', #图片名称
		        'picExt'    =>  '', #图片扩展名
		        'time'         =>  '', #上传时间
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		     
		    $sql = "insert into blog_img(articleId, picName, picExt, time) values('{$articleId}', '{$picName}', '{$picExt}', '{$time}')";
		    $db = Db_Blog::instance();
		    $db->query($sql);
		    return $db->lastInsertId();
		}
		/**
		 * 修改图片表信息
		 */
		public static function updatePic($paramArr){
		    $options = array(
		        'imgId'   => 0,
		        'updateData'  =>  array(), #array('name'=>'cuihb')
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if(!$imgId) return false;
		    
		    $formatData = self::setUpdateCondition($updateData);
		    $sql = "update blog_img set {$formatData} where id='{$imgId}'";
		    $db = Db_Blog::instance();
		    $res = $db->query($sql);
		}
		/**
		 * 获取图片id
		 */
		public static function getPicId($paramArr){
		    $options = array(
		        'picName'       =>  '', #图片名称
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    if(!$picName) return 0;
		    $sql = "select id from blog_img where picName='{$picName}'";
		    $db = Db_Blog::instance();
		    return $db->getOne($sql);
		}
		/**
		 * 查询图片信息
		 */
		public static function getPicInfo($paramArr){
		    $options = array(
		        'articleId'       =>  '', #图片名称
		        'picId'       =>  '', #图片名称
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    if(!$articleId && !$picId) return false;
		    $db = Db_Blog::instance();
		    if($articleId){
		        $sql = "select * from blog_img where articleId={$articleId}";
		        return $db->getAll($sql);
		    } 
		    if($picId) {
		        $sql = "select * from blog_img where id={$picId}";
		        return $db->getRow($sql);
		    }
		}
		/**
		 * 根据图片信息，返回图片网络路径
		 */
		public static function getPicWebPath($paramArr){
		    $options = array(
		        'imgName' => '',//图片名称
		        'imgExt'  => '',//图片后缀
		        'time'    => '',//图片上传时间
		        'rootdir' => '',//图片上传根目录
		        'size'    => '',//'110x66_'
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $imgPath = LJL_Api::run("Image.DFS.getImgDir" , array(
		        'imgName' => $imgName,
		        'time'    => $time,
		        'rootdir' => $rootdir,
		    ));
		    $webPath = self::getImgWebPath($imgPath);
		    return $webPath.'/'.$size.$imgName.'.'.$imgExt;
		}
		/**
		 * 根据图片在服务器上的路径，返回图片的网络路径
		 */
		public static function getImgWebPath($path){
		    return rtrim(WWW_WEB_IMG, '/').str_replace(trim(UPLOAD_IMG_PATH, '/'), '', trim($path, '/'));
		}
		/**
		 * ++++++++++++++++++++++++标签表相关操作+++++++++++++++++++++++
		 */
		/**
		 * 根据文章id或分类id查询标签列表，按cate查找则按热门排序
		 */
		public static function getTags($paramArr){
		    $options = array(
		        'articleId' =>  0, #文章id
		        'cate'    =>  '', #分类
		        'limit'     =>  20, #限制
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    if(!$articleId && !$cate) return false;
		    $limit = " LIMIT {$limit} ";
		    if($articleId)
		        $sql = "SELECT * FROM blog_tags WHERE articleId={$articleId} {$limit}";
		    if($cate)
		        $sql = "SELECT * FROM blog_tags WHERE cate='{$cate}' GROUP BY tag ORDER BY SUM(view) DESC {$limit}";
		    $db = Db_Blog::instance();
		    return $db->getAll($sql);
		}
		/**
		 * replace插入标签
		 */
		public static function insertTag($paramArr) {
		    $options = array(
				'insertData' =>  array(), #array('name'=>'cuihb');
			);
			if (is_array($paramArr))$options = array_merge($options, $paramArr);
			extract($options);
			
			$formatData = self::setInsertCondition($insertData);
			$sql = "REPLACE INTO blog_tags({$formatData['fileds']}) VALUES({$formatData['values']})";
			$db = Db_Blog::instance();
			$db->query($sql);
			return $db->lastInsertId();
		}
		/**
		 * 标签浏览数加1
		 */
		public static function addTagView($tag, $cate=''){
		    if(!$tag) return false;
		    $where = " where tag='{$tag}' ";
		    if($cate)
		        $where .= " and cate='{$cate}'";
		    $sql = "update blog_tags set view=view+1 {$where}";
		    $db = Db_Blog::instance();
		    $res = $db->query($sql);
		}
		/**
		 * ======================评论表相关操作======================
		 */
		/**
		 * 获取最新评论的文章id
		 */
		public static function getCommentsArticles($paramArr) {  
		    $options = array(
		        'limit'     => '', #限制
		        'order'     => ' order by id desc', 
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $sql = "SELECT articleId FROM `blog_comment` GROUP BY articleId {$order} limit {$limit} ";
		    $db = Db_Blog::instance();
		    return $db->getCol($sql);
		}
		/**
		 * 获取评论列表
		 */
		public static function getCommentsList($paramArr) {
		    $options = array(
		        'articleId' => 0, #文章id
		        'limit'     => '', #限制
		        'order'     => ' order by id ',
		        'isCount'   => 0,
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    $db = Db_Blog::instance();
		    //肯定是查询总评论数的
		    if(!$articleId){
		        $sql = "SELECT count(*) FROM blog_comment where isDel=0";
		        return $db->getOne($sql);
		    }
		    if($isCount){
		        $sql = "SELECT count(*) FROM blog_comment WHERE articleId={$articleId} and isDel=0";
		        return $db->getOne($sql);
		    }
		    if($limit) $limit = " LIMIT {$limit} ";
		    $sql = "SELECT * FROM blog_comment WHERE articleId={$articleId} and isDel=0 {$order} {$limit}";
		    return $db->getAll($sql);
		}
		/**
		 * 插入评论
		 * @author cuihb
		 * @since 2015-8-11
		 */
		public static function insertComment($paramArr) {
		    $options = array(
		        'insertData' =>  array(), #array('name'=>'cuihb');
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		     
		    $formatData = self::setInsertCondition($insertData);
		    $sql = "INSERT INTO blog_comment({$formatData['fileds']}) VALUES({$formatData['values']})";
		    $db = Db_Blog::instance();
		    $db->query($sql);
		    return $db->lastInsertId();
		}
		/**
		 * 顶评论
		 */
		public static function updateComment($paramArr){
		    $options = array(
		        'commentid'   => 0,
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if(!$commentid) return false;
		    
		    $sql = "update blog_comment set zan=zan+1 where id='{$commentid}'";
		    $db = Db_Blog::instance();
		    $res = $db->query($sql);
		}
	}
?>
