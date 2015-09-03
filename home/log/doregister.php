<?php
	header("Content-type:text/html;charset=utf-8");
	session_start();
	$path = dirname(dirname(__DIR__));//获取gen路径
	include($path.'/common/MySql.class.php');
	include($path.'/common/Register.class.php');
    include($path.'/common/PHPMailer/PHPMailerAutoload.php');

/*邮件发送，配置定义*/
	define('MAIL_HOST','smtp.163.com');
	define('MAIL_SMTPAUTH', true);
	define('MAIL_USERNAME', '@163.com');
	define('MAIL_FROM', '@163.com');
	define('MAIL_FROMNAME', 'MR.峰');
	define('MAIL_PASSWORD','');
	define('MAIL_CHARSET','utf-8');//谌哥，看我多信任你。
	define('MAIL_ISHTML',true);//谌哥，看我多信任你。



	$register = new Register($_POST["user_email"],$_POST["password"],$_POST["password2"],$_POST["validate"],"cms_user");
	// show($_POST);exit;
	$return = $register->checkreg();
	if($return["result"]){
		$re = $register->register();
		if($re){
		    $num = rand(100000,999999);
            $code = md5($num);//生成随机验证数，防止冒激活
            $code_sql = M('cms_user');
            $where = " user_email = '$_POST[user_email]' ";
            $data=array("user_code"=>$code);
            $re = $code_sql->where($where)->data($data)->update();
            // show($re);
            // echo $code_sql->getLastSql();exit;

			$message=<<<str
                        你好！$_POST[user_email]
                        <h2>欢迎注册MR.峰网站</h2>
                        请点击如下地址激活帐号:<br/><br/>
                        <a href="http://localhost/shixun/cms_blog/home/log/register_finish.php?user_email=$_POST[user_email]&code=$code">
                        http://localhost/shixun/cms_blog/home/log/register_finish.php?user_email=$_POST[user_email]&code=$code</a>
                        <br/><br/>
str;
		}

		if(SendMail("$_POST[user_email]",'欢迎注册网站',"$message")){
			echo '<script>alert("发送成功，请激活");</script>';
		}else{
			echo '<script>alert("发送失败");location="register.php";</script>';
		}
	}else{
		echo '<script>alert("'.$return['error_info'].',请重新注册");location="register.php";</script>';
		echo "$return[error_info],若没有跳转，请<a href='register.php'>单击跳转</a>";
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