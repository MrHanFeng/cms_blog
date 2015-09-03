
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册界面</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/body.css"/> 
</head>
<body>
<div class="container">
	<section id="content">
		<form action="doregister.php" method = "post">
			<h1>会员注册</h1>
			<div>
				<input type="text" placeholder="邮箱" required="" id="username" name="user_email" />
			</div>
			<div>
				<input type="password" placeholder="密码" required="" id="password" name="password"/>
				<input type="password" placeholder="确认密码" required="" id="password" name="password2"/>
			</div>
			<div class="validate">&nbsp&nbsp
				<input type="text" placeholder="验证码" required="" id="username" name="validate" />
				<img src="image.php" alt="验证码" class="validate_img" onClick="this.src=this.src+'?'+Math.random()">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</div>
			<!-- CheckNum.class.php -->
			<div class="">
				<span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>			
			</div> 
			<div>
				<!-- <input type="submit" value="Log in" /> -->
				<input type="submit" value="注册" class="btn btn-primary" id="js-btn-login" name="sub"/>
				<a href="login.php">返回登录</a>
				<!-- <a href="#">Register</a> -->
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