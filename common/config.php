<?php
	define('DB_HOST','127.0.0.1');
	define('DB_USER','root');
	define('DB_PASS','root');
	define('DB_NAME','cms');

	// 实例化对象快捷函数
	function M($table){
		try{
			$table=new MysqlClass($table);
		}catch(Exception $e){
			$e->getMessage();
			exit();
		}
		return $table;
	}
?>