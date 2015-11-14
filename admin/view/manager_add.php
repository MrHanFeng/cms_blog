<?php 
 include_once "../controller/manager_add.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>管理员添加</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：管理员添加</div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td >管理员姓名</td>
          <td>
            <input type="text" name="mg_username" value="<?php  if( isset($_GET['mg_id']) ){echo $mg_info['mg_username'];} ?>">
          </td>
        </tr>
        <tr>
          <td>管理员角色</td>
          <td>
              <select name="mg_role_id" >
                <option value="0">---请选择--</option>
                <?php foreach ($role_info as $k => $v): ?>
                    <option value=" <?php echo $v['role_id'] ;?> "  <?php if(@$mg_info['mg_role_id'] == $v['role_id']) {echo 'selected';} ?>  > <?php echo $v['role_name'] ?></option>
                <?php endforeach ?>
              </select>
          </td>
        </tr>
        <tr>
          <td class="first_td">登录帐号</td>
          <td class="second_td">
            <input type="text" name="mg_name" value="<?php   if( isset($_GET['mg_id']) ){ echo $mg_info['mg_name'] ;} ?>">
          </td>
        </tr>
        <tr>
          <td>密码</td>
          <td>
          <?php  
            if( isset($_GET['mg_id']) ){
           ?>
              <input type="hidden" name="mg_id" value="<?php echo $_GET['mg_id'];?>">

          <?php
           }
          ?>
            <input type="password" name="mg_pwd" >
          </td>
        </tr>
        <tr>
          <td>确认密码</td>
          <td>
            <input type="password" name="mg_pwd2" >
          </td>
        </tr>
        <tr>
          <td colspan=2><input type="submit" value="提交"></td>
        </tr>
      </table>
      </form>
    </div>
  </body>
</html>