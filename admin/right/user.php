<?php 
 	 include_once "../function.php";
 	 checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'user');

   /*分页开始*/
   // 定义默认查看第一页
   if(!isset($_GET['page'])){
     $_GET['page']=1;
   }
 	 // $user_info = get_user_mes();
   $arr = page(@$_GET['page'],6,"cms_user");
   $user_info = $arr['info'];
   $page = $arr['page_html'];
  	// show($user_info);

	// 删除用户信息页面
	if(isset($_GET['action']) && $_GET['action']="del" ){
	  $re = del_user($_GET['user_id']);
	  if($re){
	    jump(2,PATH."user.php","删除成功","success");
	  }else{
	    jump(2,PATH."user.php","删除失败","error");
	  }
}
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>会员页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/pager.css">
    <style>

    </style>
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：会员管理
         <div style="float:right;"><a href="user_editor.php">添加会员</a></div>
      </div>
      <table class="first_table" border=1 cellpadding=6 cellspacing=3 >
      	<tr>
      		<td width=5%>ID号</td>
			<td width="10%"> 会员头像</td>
      		<td width=20%>登录帐号</td>
      		<td width=11%>用户名</td>
      		<td width=12%>电话</td>
      		<td width=15%>注册时间</td>
      		<td width=15%>上次登陆时间</td>
      		<td>修改</td>
      		<td>删除</td>
      	</tr>
<?php foreach ($user_info as $k => $v) {?>
      	<tr>
      		<td> <?php echo $v['user_id'] ?></td>
			<td>
				<img src="<?php   echo __PUBLIC__."/".$v['user_img'] ?>" alt="" width="150px" height="100px">
			</td>      		<td> <?php echo $v['user_email'] ?></td>
      		<td> <?php echo $v['username'] ?></td>
      		<td> <?php echo $v['user_tel'] ?></td>
      		<td> <?php echo date("Y-m-d H:i:s",$v['user_time']) ?></td>
      		<td> <?php echo date("Y-m-d H:i:s",$v['user_last']) ?></td>
      		<td>
      			<a href="<?php echo PATH."user_editor.php?action=editor&user_id=$v[user_id]" ?>">
					<img src="../images/edit.png" alt="修改">
				</a>
			</td>
			<td>
      			<a href="<?php echo PATH."user.php?action=del&user_id=$v[user_id]" ?>">
					<img src="../images/del.png" alt="删除">
				</a>
      		</td>
      	</tr>
<?php  }?>
      </table>
          <?php echo $page; ?>
    </div>
  </body>
</html> 