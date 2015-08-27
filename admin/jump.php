<html>
	<head>
		<title>跳转中</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<meta http-equiv="refresh_error" content="<?php echo "{$time};url={$url}" ?>">
		<script>
			//设定倒数秒数  
			var t = <?php  echo $time; ?> ;
			//显示倒数秒数  
			function showTime(){  
			    t -= 1;  
			    if(t==0){  
			    	clearInterval(time);
			        location.href=<?php  echo "'".$url."'" ?>;  
			        return;
			    }  
			    document.getElementById("time").innerHTML= t;
			    //每秒执行一次,showTime()  
			}  
			time=setInterval("showTime()",1000);  
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

		<h2 ><span id="time"> <?php  echo $time; ?></span>后即将跳转</h2>
		<h2>
			如果页面没有跳转，<a href="<?php echo $url;?>">请点击此处跳转</a>
		</h2>
	</body>
</html>