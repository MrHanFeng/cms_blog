<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'auth');

  $auth_info=get_auth_two();


  if(isset($_GET['action'])&&$_GET['action']=="del" ){
    $re =del_auth($_GET['auth_id']);
    if($re){
      jump(2,PATH."auth.php","删除成功","success");
    }else{
      jump(2,PATH."auth.php","删除失败","error");
    }
  }
?>
