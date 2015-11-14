<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'role_editor');

// 查询出所有的权限信息
  $auth_info = get_auth();
  $parent = $auth_info['parent'];
  $child = $auth_info['child'];
  // show($child);

// 查询出该角色有的权限ID
  $role_auth_id = find_role($_GET['role_id']);

  if($_POST){
      $re = update_role($_POST['role_id'],$_POST['auth_id']);
      if($re){
        jump(2,PATH."role.php","更新成功","success");
      }
        jump(2,PATH."role.php","更新失败","error");
  }

?>