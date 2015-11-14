<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'link_add');

// 判断如果为修改页面，获取链接信息
  if(@$_GET['action']=="editor" &&  $_GET['link_id']){
    $link_info = get_link($_GET['link_id']);
  }

  if($_POST){
     if(@$_GET['action']=="editor" &&  $_GET['link_id']){//如果是修改页面，执行更行操作，否则执行插入操作

        $re = update_link($_GET['link_id'],$_POST);
        $word="修改";
     }else{
      $re = insert_link($_POST);
      $word="添加";
     }
     if($re){
         jump(2,PATH."link.php",$word."成功","success");
     }else{
         jump(2,PATH."link.php",$word."失败","error");
     }
     
  }
  


  

  

?>