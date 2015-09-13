<?php
	// function __autoload($a){
	// 	echo $a;
	// 	include $a.".class.php";
	// }
	session_start();

	/*引入类*/
	$path = dirname(dirname(__DIR__));//获取根路径
	include($path.'/common/MySql.class.php');
	include($path.'/common/Login.class.php');


	if(isset($_POST["sub"])){		
		$remember=isset($_POST['rem'])?1:0;
		$login = new Login();
		$login -> set($_POST["user_email"],$_POST["password"],$remember,$_POST["validate"],"cms_user");

		$result = $login->do_login();
		// show($result);exit;
		if($result["result"] ){

			$login->login();

			$info = M('cms_user');
			$data['user_last'] = time();

			$info->data($data)->where("user_id=$_SESSION[user_id] ")->update();
			echo "<script>alert('登录成功');window.location.href='../index.php';</script>";
		}else{
			echo "<script>alert('".$result["error_info"]."');location='login.php';</script>";
		}
	}



?>