<?php 
// 调试函数
	function show($msg){
	    echo "<pre style='color:red'>";
	    var_dump($msg);
	    echo "</pre>";
	}    




// /*前台*/
// 	define("CSS_URL",SITE_URL."cms_blog/public/home/css"); //css
// 	define("IMG_URL",SITE_URL."cms_blog/public/home/images/"); //img
// 	define("JS_URL",SITE_URL."cms_blog/public/home/js/"); //js

// /*后台*/
// 	define("ADMIN_CSS_URL",SITE_URL."cms_blog/public/admin/css/"); //css
// 	define("ADMIN_IMG_URL",SITE_URL."cms_blog/public/admin/images/"); //img
// 	define("ADMIN_JS_URL",SITE_URL."cms_blog/public/admin/js/"); //js

// /*公共*/
// 	define("IMG_UPLOAD",SITE_URL."cms_blog/public/");//上传图片的根目录

// /*类*/
// 	define("CLASS_URL",SITE_URL."cms_blog/common/"); 	



// 定义当前执行文件的文件夹的绝度路径
	 $dir_name = dirname($_SERVER['SCRIPT_NAME']);//返回当前文件的目录地址
	define("PATH","http://$_SERVER[HTTP_HOST]$dir_name/");//拼接上域名组成完整的域名常量

// 定义根目录
	define("SITE_URL","http://localhost/shixun/cms_blog/");

// 定义到/admin的绝对路径
	define("ADMIN_PATH",SITE_URL."admin/");

// 定义到/home的绝对路径
	define("HOME_PATH", SITE_URL."home/");

// 定义上传路径
	define('__PUBLIC__',SITE_URL."public/");


// 设置时区为中国
	date_default_timezone_set('PRC');

	
	// 把数据库快捷操作的函数包含进来
	include_once("common/mysql.class.php");
	
 ?>