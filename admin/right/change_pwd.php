<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php


  if(!empty($_POST)){
    $mg_info=get_manager($_POST['mg_id']);
    if(md6($_POST['old_password']) != $mg_info['mg_pwd']){
      jump(2,PATH."change_pwd.php","原密码不对","error");
    }elseif(strlen($_POST['new_password']) < 4){
      jump(2,PATH."change_pwd.php","密码长度小于4位","error");
    }elseif($_POST['new_password'] != $_POST['c_password']){
      jump(2,PATH."change_pwd.php","两次密码不相同","error");
    }else{
      $re = update_mg_pwd($_POST['mg_id'],$_POST['new_password']);
      if($re){
        jump(2,PATH."article.php","修改成功","success");
      }else{
        jump(2,PATH."change_pwd.php","修改失败","error");
      }
    }
  }
  ?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>密码修改</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <style>

    </style>
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：后台登录密码修改
      </div>
      <form action="" method="post">
        <table class="frist_table" border=1 cellspacing=5 cellpadding=2>
        <tr>
          <td>原密码</td>
          <td><input type="password" name="old_password"></td>
        </tr>

        <tr>
          <td>新密码</td>
          <td><input type="password" name="new_password"></td>
        </tr>

        <tr>
          <td>确认新密码</td>
          <td><input type="password" name="c_password"></td>
        </tr>
        <tr>
          <input type="hidden" name="mg_id" value="<?php echo $_SESSION['mg_id'] ?>">
          <td colspan=2><input type="submit" value="提交"></td>
        </tr>
        </table>
      </form>
          
    </div>
  </body>
</html>