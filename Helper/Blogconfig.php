<?php
    /**
     * blogconfig,统计业务相关
     * @author cuihb
     */
	class Helper_Blogconfig extends Helper_Abstract {
	    /**
		 * 查询管理员信息
		 */
		public static function getAdminInfo($paramArr) {
		    $options = array(
		        'username' => '',
		        'password' => '',
		        'website'  => '',
		        'webname'  => '',
		        'status'   => 0,
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    $where = ' where 1=1 ';
		    if($username)
		        $where .= " and adminName='{$username}' ";
		    if($password)
		        $where .= " and adminPassword='{$password}' ";
		    if($website)
		        $where .= " and webSite='{$website}' ";
		    if($webname)
		        $where .= " and webName='{$webname}' ";
		    if($status)
		        $where .= " and status='{$status}' ";
		    $sql = " select * from blog_web_list {$where} ";
		    $db = Db_Blogconfig::instance();
		    return $db->getRow($sql);
		}
		
		/**
		 * 获取管理员列表
		 */
		public static function getAdminList($paramArr) {
		    $options = array(
		        'page'     => 1,//当前页
		        'pageSize' => 10,//limit
		        'fields'   => array(),//要查询的字段
		        'isCount'  => 0, //是否是查询总数
		        'status'   => 1, //线上的项目状态为ok
		        'order'    => 'order by id desc',
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if(!is_array($fields)) $fields = explode(',', $fields);
		    $formatData = self::setSelectField($fields);
		    $limit      = ' limit '.($page-1)*$pageSize.','.$pageSize;
		    
		    if($status){
		        $where = ' where status='.$status.' ';
		    }else{
		        $where = ' where 1=1 ';
		    }
		    
		    $db = Db_Blogconfig::instance();
		    if($isCount){
		        $sql = "select count(*) from blog_web_list {$where}";
		        return $db->getOne($sql);
		    }
		    
		    $sql = "select {$formatData} from blog_web_list {$where} {$order} {$limit}";
		    return $db->getAll($sql);
		}
		/**
		 * 修改管理员表
		 */
		public static function updateAdminInfo($paramArr) {
		    $options = array(
		        'webSite'   => 0,
		        'updateData'  =>  array(), #array('name'=>'cuihb')
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    if(!$webSite) return false;
		    
		    $formatData = self::setUpdateCondition($updateData);
		    $sql = "update blog_web_list set {$formatData} where webSite='{$webSite}'";
		    $db = Db_Blogconfig::instance();
		    return $db->query($sql);
		}
		/**
		 * 插入管理员信息
		 */
		public static function insertAdminInfo($paramArr){
		    $options = array(
		        'insertData' =>  array(), #array('name'=>'cuihb');
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    $formatData = self::setInsertCondition($insertData);
		    $sql = "insert into blog_web_list({$formatData['fileds']}) values({$formatData['values']})";
		    $db = Db_Blogconfig::instance();
		    $db->query($sql);
		}
		/**
		 * *************************文章排行相关*****************************
		 */
		/**
		 * 最新、最热文章的 replace table 插入
		 */
		public static function insertHotnew($paramArr) {
		    $options = array(
		        'insertData' =>  array(), #array('name'=>'cuihb');
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    	
		    $formatData = self::setInsertCondition($insertData);
		    $sql = "REPLACE INTO blog_hotnew_list({$formatData['fileds']}) VALUES({$formatData['values']})";
		    $db = Db_Blogconfig::instance();
		    $db->query($sql);
		    return $db->lastInsertId();
		}
		/**
		 * 获取博文详细信息信息
		 */
		public static function getArticleInfo($paramArr){
		    $options = array(
		        'articleId' => 0, #文章id
		        'webSite'   => '',#博客站
		        'fileds'    =>  array(), #要查询的字段
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $filedStr = self::setSelectField($fileds);
		    $where = " where articleId='{$articleId}' ";
		    if($webSite)
		        $where .= " and webSite='{$webSite}' ";
		    $sql = "select {$filedStr} from blog_hotnew_list {$where}";
		    $db = Db_Blogconfig::instance();
		    $res =  $db->getRow($sql);
		    return $res;
		}
		/**
		 * 博文排行榜文章查询
		 */
		public static function getBlogRankList($paramArr) {
		    $options = array(
		        'page'     => 1,//当前页
		        'pageSize' => 10,//limit
		        'fields'   => array(),//要查询的字段
		        'isCount'  => 0, //是否是查询总数
		        'order'    => 'order by id desc',
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    
		    $formatData = self::setSelectField($fields);
		    $limit      = ' limit '.($page-1)*$pageSize.','.$pageSize;
		    
		    $where = ' where 1=1 ';
		    
		    $db = Db_Blogconfig::instance();
		    if($isCount){
		        $sql = "select count(*) from blog_hotnew_list {$where}";
		        return $db->getOne($sql);
		    }
		    
		    $sql = "select {$formatData} from blog_hotnew_list {$where} {$order} {$limit}";
		    return $db->getAll($sql);
		}
		/**
		 * ********************博文搜索词记录表********************
		 */
		/**
		 * 记录搜索
		 */
		public static function searchRecord($webSite, $keyword=''){
		    if(!$webSite || !$keyword || $keyword==='*') return;
		    $db = Db_Blogconfig::instance();
		    //先查询有没有改记录，有改记录则加1
		    $sql = " select id from blog_search_words where webSite='{$webSite}' and keyword='{$keyword}'";
		    $searchId = $db->getOne($sql);
		    
		    $pinyin = API_Item_Base_String::getPinyin(array('input' => $keyword,));
		    $insertData = array(
		        'webSite' => $webSite,
		        'keyword' => $keyword,
		        'pinyin' => $pinyin,
		    );
		    //有则记录加1
		    if($searchId){
		        $sql = "update blog_search_words set times=times+1 where id={$searchId} ";
		    }else{//没有记录则插入
		        $formatData = self::setInsertCondition($insertData);
		        $sql = "insert into blog_search_words({$formatData['fileds']}) values({$formatData['values']})";
		    }
		    $db->query($sql);
		}
		/**
		 * ********************用户表 用户登录表相关********************
		 */
		/**
		 * 插入用户信息
		 */
		public static function insertUser($paramArr){
		    $options = array(
		        'insertData' =>  array(), #array('name'=>'cuihb');
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		     
		    $formatData = self::setInsertCondition($insertData);
		    $sql = "INSERT INTO blog_users({$formatData['fileds']}) VALUES({$formatData['values']})";
		    $db = Db_Blogconfig::instance();
		    $db->query($sql);
		    return $db->lastInsertId();
		}
		/**
		 * 修改用户信息
		 */
		public static function updateUser($paramArr) {
		    $options = array(
		        'username'   => 0,
		        'updateData'  =>  array(), #array('name'=>'cuihb')
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		
		    if(!$username) return false;
		
		    $formatData = self::setUpdateCondition($updateData);
		    $sql = "update blog_users set {$formatData} where username='{$username}'";
		    $db = Db_Blogconfig::instance();
		    $res = $db->query($sql);
		}
		/**
		 * 查询用户信息
		 */
		public static function getUserInfo($paramArr) {
		    $options = array(
		        'username' => '',
		        'email'    => '',
		        'password' => '',
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		    $where = ' where 1=1 ';
		    if($username)
		        $where .= " and username='{$username}' ";
		    if($email)
		        $where .= " and email='{$email}' ";
		    if($password)
		        $where .= " and password='{$password}' ";
		    $sql = " select * from blog_users {$where} ";
		    $db = Db_Blogconfig::instance();
		    return $db->getRow($sql);
		}
		/**
		 * 插入用户登录信息
		 */
		public static function insertLoginData($paramArr){
		    $options = array(
		        'insertData' =>  array(), #array('name'=>'cuihb');
		    );
		    if (is_array($paramArr))$options = array_merge($options, $paramArr);
		    extract($options);
		     
		    $formatData = self::setInsertCondition($insertData);
		    $sql = "INSERT INTO blog_users_login({$formatData['fileds']}) VALUES({$formatData['values']})";
		    $db = Db_Blogconfig::instance();
		    $db->query($sql);
		    return $db->lastInsertId();
		}
	}