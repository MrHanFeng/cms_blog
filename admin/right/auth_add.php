<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'auth_add');

  // 获得父级权限下拉列表的信息
  $auth_pid_info = get_auth();



  if(isset($_GET['auth_id'])){
    $auth_info = get_auth_find($_GET['auth_id']);
  }

  if($_POST){
     if(isset($_GET['auth_id'])){
        $re = update_auth($_GET['auth_id'],$_POST);
        if($re){
          jump(2,PATH."auth.php","更新成功","success");
        }
        jump(2,PATH."auth.php","更新失败","error");
     }

     $re = insert_auth($_POST);
     if($re){
       jump(2,PATH."auth.php","添加成功","success");
     }
     jump(2,PATH."auth_add.php","添加失败","error");
  }



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>权限添加</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：权限添加</div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td class="first_td">权限名称</td>
          <td class="second_td">
            <input type="text" name="auth_name" value="<?php   if( isset($_GET['auth_id']) ){ echo $auth_info['auth_name'] ;} ?>">
          </td>
        </tr>
        <tr>
          <td >页面名称</td>
          <td>
            <input type="text" name="auth_a" value="<?php  if( isset($_GET['auth_id']) ){echo $auth_info['auth_a'];} ?>">
          </td>
        </tr>
        <tr>
          <td>父级权限</td>
          <td>
            <select name="auth_pid" >
              <option value="0">--请选择--</option>
              <?php foreach ($auth_pid_info['parent'] as $kk =>$vv): ?>
                <option value="<?php echo $vv['auth_id'];?>" <?php if($vv['auth_id'] == @$auth_info['auth_pid']) echo "selected"; ?> ><?php echo $vv['auth_name'] ?></option>
              <?php endforeach ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan=2>
            <input type="submit" value="提交">
          </td>
        </tr>
      </table>
      </form>
    </div>
  </body>
</html>