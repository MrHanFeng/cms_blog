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