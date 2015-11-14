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
 