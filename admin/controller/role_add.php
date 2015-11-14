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