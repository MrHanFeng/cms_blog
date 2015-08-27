<html>
	<head>
		<title>跳转中</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<meta http-equiv="refresh" content="<?php echo "{$time};url={$url}" ?>">
		<script>


		var timeobj= document.getElementById("time");
		setInterval("settime()",1000);//方法可按照指定的周期（以毫秒计）来调用函数或计算表达式。
		var t=<?php echo $time+1; ?>;

		function settime(){
			timeobj.innerHTML='111';
		}

		</script>
	</head>
	<body>
		<?php  if($sta=="error"){ ?>
			<h1>
				<font color=red>
					<?php echo $info; ?>
				</font>
			</h1>
		<?php }elseif($sta=="success"){ ?>

		<h1>
			<font color=green>
				<?php echo $info; ?>
			</font>
		</h1>
		<?php  } ?>

		<h2 ><div id="time">后即将跳转</div></h2>
		<h2>
			如果页面没有跳转，<a href="<?php echo $url;?>">请点击此处跳转</a>
		</h2>
	</body>
</html>