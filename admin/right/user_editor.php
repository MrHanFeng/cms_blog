<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php


//获取信息填默认值
  if(isset($_GET['action']) && $_GET['action']="update" ){
      $user_info = get_user($_GET['user_id']);
  }


// 添加用户页面
  if(!empty($_POST)){
    // 修改用户信息页面
    if(isset($_GET['action']) && $_GET['action']="update" ){
        if(strlen($_POST['password']) < 6 ){
           jump(2,PATH."user.php","密码并不能小于6位","error");
        }elseif($_POST['password'] !== $_POST['c_password']){
           jump(2,PATH."user.php","两次密码不相同","error");
        }
        unset($_POST['c_password']);
        $re = update_user($_GET['user_id'],$_POST);
        if($re){
          jump(2,PATH."user.php","修改成功","success");
        }else{
          jump(2,PATH."user.php","修改失败","error");
        }
    }else{//添加用户页面
        $result_check = check_reg($_POST);//进行注册验证
        if($result_check['bool']){
        if(array_key_exists("c_password", $_POST)){
          unset($_POST['c_password']);
        }
        $re_insert = insert_user($_POST);
        if($re_insert){
          jump(2,PATH."user.php","插入成功","success");
        }else{
          jump(2,PATH."user_editor.php","插入失败","error");
        }
      }else{
        jump(2,PATH."user_editor.php","$result_check[info]","error");
      }
    }

    
  }


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>文章页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <style>

    </style>
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：会员操作</div>
      <form action="" method="post">
          <table class="first_table" border=2 cellpadding=2>
            <tr>
              <td>登录邮箱</td>
              <td>
                <?php if(isset($user_info)){ 
                   if(isset($user_info)){ echo $user_info['user_email']; } ?>
                <?php }else{ ?>
                   <input type="text" name="user_email" >
                <?php } ?>
              </td>
            </tr>            
            <tr>
              <td>用户名</td>
              <td><input type="text" name="username" value="<?php if(isset($user_info)){ echo $user_info['username']; } ?>"></td>
            </tr>          
            <tr>
              <td>密码</td>
              <td><input type="password" name="password"></td>
            </tr>          
            <tr>
              <td>确认密码</td>
              <td><input type="password" name="c_password"></td>
            </tr>          
            <tr>
              <td>电话号</td>
              <td><input type="text" name="user_tel" value="<?php if(isset($user_info)){ echo $user_info['user_tel']; } ?>"></td>
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