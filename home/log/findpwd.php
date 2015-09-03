<?php

	$path = dirname(dirname(__DIR__));//获取根路径
    include($path.'/common/PHPMailer/PHPMailerAutoload.php');
	include($path.'/common/MySql.class.php');
	/*邮件发送，配置定义*/
		define('MAIL_HOST','smtp.163.com');
		define('MAIL_SMTPAUTH', true);
		define('MAIL_USERNAME', '@163.com');
		define('MAIL_FROM', '@163.com');
		define('MAIL_FROMNAME', 'MR.峰');
		define('MAIL_PASSWORD','');
		define('MAIL_CHARSET','utf-8');//谌哥，看我多信任你。
		define('MAIL_ISHTML',true);//谌哥，看我多信任你。

	if(isset($_POST['user_email'])){
		array_pop($_POST);
		$info = M('cms_user');
		$where = " user_email = '$_POST[user_email]' ";
		$field=" user_code,user_email ";
		$re = $info->where($where)->field($field)->find();
		// show($re);exit;
		 if($re){
                        $message=<<<str
                            你好！$_POST[user_email]
                                <h2>欢迎使用MR.峰的网站</h2>
                                点击如下地址设置新密码:<br/><br/>
                                <a href="http://localhost/shixun/cms_blog/home/log/setpwd.php?user_email=$re[user_email]&code=$re[user_code]">
                                http://localhost/shixun/cms_blog/home/log/setpwd.php?user_email=$re[user_email]&code=$re[user_code]</a>
                                <br/><br/>
str;

			if(SendMail("$_POST[user_email]",'找回密码',"$message")){
				echo '<script>alert("发送成功，请查看");</script>';
			}else{
				echo '<script>alert("发送失败");location="findpwd.php";</script>';
			}
		}else{
			echo '<script>alert("暂无此用户，请注册");location="register.php";</script>';
			echo "$return[error_info],若没有跳转，请<a href='login.php'>单击跳转</a>";
		}

}






		function SendMail($to, $title, $content) {
	          $mail = new PHPMailer(); //实例化
	          $mail->IsSMTP(); // 启用SMTP
	          $mail->Host=MAIL_HOST; //smtp服务器的名称（这里以QQ邮箱为例）
	          $mail->SMTPAuth =MAIL_SMTPAUTH; //启用smtp认证
	          $mail->Username = MAIL_USERNAME; //你的邮箱名
	          $mail->Password = MAIL_PASSWORD ; //邮箱密码
	          $mail->From = MAIL_FROM; //发件人地址（也就是你的邮箱地址）
	          $mail->FromName = MAIL_FROMNAME; //发件人姓名
	          $mail->AddAddress($to,"尊敬的客户");
	          $mail->WordWrap = 50; //设置每行字符长度
	          $mail->IsHTML(MAIL_ISHTML); // 是否HTML格式邮件
	          $mail->CharSet=MAIL_CHARSET; //设置邮件编码
	          $mail->Subject =$title; //邮件主题
	          $mail->Body = $content; //邮件内容
	          $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
	          return($mail->Send());
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
		<form action="" method="post">
			<h1>找回密码</h1>
			<div>
				<input type="text" placeholder="请输入您的邮箱帐号" required="" id="username" name="user_email" value=""/>
			</div>
			
			<div>
				<input type="submit" value="确定"  name="sub" class="btn btn-primary" id="js-btn-login"/>
				<a href="login.php">返回登录</a>
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