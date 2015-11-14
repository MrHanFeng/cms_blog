<?php 
  include_once "../controller/change_pwd.php";
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