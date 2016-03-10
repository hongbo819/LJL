<?php
    /**
     * blogconfig,用户映射相关
     * @author cuihb
     */
	class Helper_User extends Helper_Abstract {
	    /**
	     * 判断映射表中是否有该用户信息
	     */
	    public static function getApiUserInfo($paramArr){
	        $options = array(
	            'apiuid' => '',
	            'apiname'=> '',
	        );
	        if (is_array($paramArr))$options = array_merge($options, $paramArr);
	        extract($options);
	        
	        if(!$apiuid && !$apiname) return false;
	        $where = $apiuid ? " where apiuid={$apiuid} " : " where api_name='{$apiname}' ";
	        $sql = "select * from api_user_map {$where} ";
	        $db = Db_User::instance();
	        return $db->getRow($sql);
	    }
	    /**
	     * 插入映射数据
	     */
	    public static function insertUserMap($paramArr) {
	        $options = array(
	            'insertData' =>  array(), #array('name'=>'cuihb');
	        );
	        if (is_array($paramArr))$options = array_merge($options, $paramArr);
	        extract($options);
	         
	        $formatData = self::setInsertCondition($insertData);
	        $sql = "REPLACE INTO api_user_map({$formatData['fileds']}) VALUES({$formatData['values']})";
	        $db = Db_User::instance();
	        $db->query($sql);
	        return $db->lastInsertId(); 
	    }
	    /**
	     * 插入聊天库数据
	     */
	    public static function insertChatuser($paramArr) {
	        $options = array(
	            'insertData' =>  array(), #array('name'=>'cuihb');
	        );
	        if (is_array($paramArr))$options = array_merge($options, $paramArr);
	        extract($options);
	        
	        $formatData = self::setInsertCondition($insertData);
	        $sql = "REPLACE INTO webchat_user({$formatData['fileds']}) VALUES({$formatData['values']})";
	        $db = Db_Webchat::instance();
	        $db->query($sql);
	        return $db->lastInsertId();
	    }
	}