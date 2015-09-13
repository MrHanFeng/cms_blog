<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'role_add');

  if(!empty($_POST['role_name']) ){
    $re = add_role($_POST['role_name']);
    if($re){
      jump(2,PATH."role.php","添加成功","success");
    }
      jump(2,PATH."role_add.php","添加失败","error");
  }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>添加角色</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：添加角色</div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td class="first_td">角色名称</td>
          <td class="second_td">
            <input type="text" name="role_name">
          </td>
        </tr>
       
        <tr>
          <td colspan=2>
            <input type="submit" value="提交" >
          </td>
        </tr>
      </table>
      </form>
    </div>
  </body>
</html>