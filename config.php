<?php 
// 调试函数
	function show($msg){
	    echo "<pre style='color:red'>";
	    var_dump($msg);
	    echo "</pre>";
	}    



// 定义根目录
	define("SITE_URL","http://localhost/cms_blog/");

// 定义当前执行文件的文件夹的绝度路径
	$dir_name = dirname($_SERVER['SCRIPT_NAME']);//返回当前文件的目录地址
	define("PATH","http://$_SERVER[HTTP_HOST]$dir_name/");//拼接上域名组成完整的域名常量

// 定义到/admin的绝对路径
	define("ADMIN_PATH",SITE_URL."admin/");

// 定义到/home的绝对路径
	define("HOME_PATH", SITE_URL."home/");

// 定义上传路径
	define('__PUBLIC__',SITE_URL."public/");


// 物理地址，到当前项目的根目录 cms_blog下【不管cms_blog的项目文件有多深】
	// define('__ROOT__', strstr($_SERVER['SCRIPT_FILENAME'],"cms_blog",true)."cms_blog/") ;
	// define('__ROOT__', __DIR__);//方法二

// 设置时区为中国
	date_default_timezone_set('PRC');

// 设置网站成立时间
	define('CREATE_TIME', strtotime("2015-11-03 14:00:00"));//2015/11/03

// 把数据库快捷操作的函数包含进来
	include_once("common/Mysql.class.php");
	
 ?>