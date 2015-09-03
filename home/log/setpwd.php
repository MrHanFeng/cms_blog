<?php 
	$path = dirname(dirname(__DIR__));//获取根路径
	include($path.'/common/MySql.class.php');


	/*设置新CODE*/
    $num = rand(100000,999999);
    $code = md5($num);//生成随机验证数，防止冒激活

    if(isset($_POST['password'])){
    	if(strlen($_POST['password']) <6){
    		echo "<script>alert('请输入大于6位的密码')</script>";
    	}elseif($_POST['password'] !=$_POST['password2']){
    		echo "<script>alert('两次密码不一致')</script>";
    	}else{
			$sql = M('cms_user');
			$where=" user_email = '$_GET[user_email]' ";
			$pwd = md5(md5($_POST['password']));
			$data=array("user_code"=>"$code","password"=>"$pwd");
			$re = $sql->data($data)->where($where)->update();
			// echo $sql->getLastSql();exit;
			if($re){
    			echo "<script>alert('设置成功');location='login.php';</script>";
			}else{
    			echo "<script>alert('设置失败');</script>";
			}
    	}

    }
 ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>找回密码</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/body.css"/> 
</head>
<body>
<div class="container">
	<section id="content">
		<form action="" method = "post">
			<h1>设置新密码</h1>

			<div>
				<input type="password" placeholder="新密码" required="" id="password" name="password"/>
				<input type="password" placeholder="确认新密码" required="" id="password" name="password2"/>
			</div>
			<div class="">
				<span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>			
			</div> 
			<div>
				<input type="submit" value="确认" class="btn btn-primary" id="js-btn-login" name="sub"/>
			</div>
		</form><!-- form -->
	</section><!-- content -->
</div>
<!-- container -->


<br><br><br><br>

</body>
</html>