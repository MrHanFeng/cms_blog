<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'manager');


  $manager_info = get_manager_mes();


// 如果有删除操作
  if(@$_GET['mg_id']){
    $re = del_manager($_GET['mg_id']);
    if($re){
         jump(2,PATH."manager.php","删除成功","success");
     }else{
         jump(2,PATH."manager.php","删除失败","error");
     }
  }

  

?>