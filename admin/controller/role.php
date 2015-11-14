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