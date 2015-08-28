<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php

  $link_info = get_link_mes();
  // show($link_info);

// 列表置顶功能
  if(@$_GET['action']=="up"){
  	$re = update_link($_GET['link_id'],$data='up');
  	if($re){
  	  jump(2,PATH."link.php","置顶成功","success");
  	}else{
  	  jump(2,PATH."link.php","置顶失败","error");
  	}
  }

  // 删除指定列表
  if(@$_GET['action']=="del"){
  	$re = del_link($_GET['link_id']);
  	if($re){
  	  jump(2,PATH."link.php","删除成功","success");
  	}else{
  	  jump(2,PATH."link.php","删除失败","error");
  	}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>链接页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">

  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：链接页面
			 <div style="float:right;"><a href="link_add.php">添加链接</a></div>
      </div>
      <table border=1 cellspacing=5 cellpadding=5 width="100%" align=center>
      	<tr>
      		<td width=8%>链接序号</td>
      		<td width=10%>名称</td>
      		<td width=20%>介绍</td>
      		<td >链接地址</td>
      		<td width=15%>链接图片</td>
      		<td width=18%>操作</td>
      	</tr>
<?php 
	if($link_info){
	  foreach ($link_info as $k => $v) { 
?>
      	<tr>
      		<td><?php echo $v['link_id'] ?></td>
      		<td><?php echo $v['link_name'] ?></td>
      		<td><?php echo $v['link_introduce'] ?></td>
      		<td><?php echo $v['link_url'] ?></td>
      		<td><img src="<?php  $v['link_img']?>" alt="链接图片" width=150 height=100></td>

      		<td>
      			<a href=""><a href=" <?php echo PATH."link.php?action=up&link_id=".$v['link_id'] ?> ">置顶</a></a><br><br>
      			<a href=""><a href=" <?php echo PATH."link.php?action=del&link_id=".$v['link_id'] ?> ">删除</a></a>
      			<a href=""><a href=" <?php echo PATH."link_add.php?action=editor&link_id=".$v['link_id'] ?> ">修改</a></a>
      		</td>
      	</tr>
<?php 
		} 
	}else{
?>		
		<tr>
			<td colspan=6 align=center> <h1>暂无信息，请插入链接</h1></td>
		</tr>

<?php  }  ?>


      </table>
    </div>
  </body>
</html>