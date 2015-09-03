<?php
	session_start();
//验证是否登录
	// print_r($_COOKIE);
	if(isset($_SESSION["username"]) && $_SESSION["username"] != ""){
		// echo "<script>alert('您已经登录');location='index.php'</script>";
	}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录界面</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/body.css"/> 
</head>
<body>

<div class="container">
	<section id="content">
		<form action="dologin.php" method="post">
			<h1>会员登录</h1>
			<div>
				<input type="text" placeholder="邮箱" required="" id="username" name="user_email" value=""/>
			</div>
			<div>
				<input type="password" placeholder="密码" required="" id="password" name="password" value=""/>
			</div>
			<div class="validate">&nbsp&nbsp&nbsp
				<input type="text" placeholder="验证码" required="" id="username" name="validate" />
				<img src="image.php" alt="验证码"   onClick="this.src=this.src+'?'+Math.random()">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<input type="checkbox" name="rem" id="rem_input">记住一周 
			</div>
			 <div class="">
				<span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>			
			</div> 
			<div>
				<input type="submit" value="登录"  name="sub" class="btn btn-primary" id="js-btn-login"/>
				<a href="findpwd.php">忘记密码?</a>
				<a href="register.php">注册</a>
			</div>
		</form><!-- form -->

		 <div class="button">
			<span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>
			<a href="../index.php">返回首页</a>	
		</div> <!-- button -->
	</section><!-- content -->
</div>
<!-- container -->


<br><br><br><br>

</body>
</html>