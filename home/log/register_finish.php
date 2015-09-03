<?php 
	$path = dirname(dirname(__DIR__));//获取gen路径
	include($path.'/common/MySql.class.php');
	$sql = M('cms_user');
	$where = "  user_email='$_GET[user_email]' and user_code = '$_GET[code]'";
	$data=array("user_identify"=>"1");
	$info = $sql->data($data)->where($where)->update();
	// echo $sql->getLastSql();
	// show($info);exit;
	if($info){
		echo '<script>alert("激活成功,请登录");location="login.php";</script>';
	}else{
		echo '<script>alert("激活失败,请重新注册");location="register.php";</script>';
	}

 ?>