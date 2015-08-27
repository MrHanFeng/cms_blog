<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
	include_once "../function.php";
	if(isset($_POST['sub'])){
		login();
	}
 ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../css/login.css" />
	<title>博客管理系统后台登录界面</title>
</head>

<body class="b">
	<div class="lg">
		<form action="login.php" method="POST">
		    <div class="lg_top"></div>
		    <div class="lg_main">
		        <div class="lg_m_1">
		        
		        <input name="username" value="username" placeholder="用户名" class="ur" />
		        <input name="password" type="password" placeholder="密码" value="password" class="pw" />
		        <input type="text" name="validate" placeholder="验证码" class="va"/>
				<img src="image.php" alt="验证码" class="validate_img"  onClick="this.src=this.src+'?'+Math.random()">

		        </div>
		    </div>
		    <div class="lg_foot">
		    	<input type="submit" name="sub" value="Login In" class="bn" />
			</div>
		</form>
	</div>
</body>
</html>
