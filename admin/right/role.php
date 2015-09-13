<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'role');



  $role_info = get_role();



// 判断是否有删除操作
  if(isset($_GET['action']) && $_GET['action']=="del"){
      $re = del_role($_GET['role_id']);
      if($re){
        jump(2,PATH."role.php","删除成功","success");
      }
        jump(2,PATH."role.php","删除失败","error");

  }


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>角色设置</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/pager.css">

  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：角色设置
			 <div style="float:right;"><a href="role_add.php">添加角色</a></div>
      </div>
      <table border=1 cellspacing=5 cellpadding=5 width="100%" align=center>
      	<tr>
      		<td width=8%>角色ID</td>

      		<td width=10%>角色名称</td>
      		<td >角色权限</td>
          <td width=20%>角色权限ID</td>
          <td>修改</td>
          <td>删除</td>
      	</tr>
<?php 
	if($role_info){
	  foreach ($role_info as $k => $v) { 
?>
      	<tr>
            <td><?php echo $v['role_id'] ?></td>

      		<td><?php echo $v['role_name'] ?></td>
      		<td><?php echo $v['role_auth_ac'] ?></td>
      		<td><?php echo $v['role_auth_ids'] ?></td>
      		<td>
            <a href="role_editor.php?role_id= <?php echo $v['role_id']; ?> ">
             <img src="../images/edit.png" alt="修改">
            </a>
          </td>
          <td>
            <a href="<?php echo PATH."role.php?action=del&role_id=$v[role_id]" ?>" onclick="return confirm('确定要删除？');">
              <img src="../images/del.png" alt="删除">
            </a>
          </td>

      	
      	</tr>
<?php 
		} 
	}else{
?>		
		<tr>
			<td colspan=6 align=center> <h1>暂无角色信息，请添加角色</h1></td>
		</tr>

<?php  }  ?>


      </table>
    </div>
  </body>
</html>