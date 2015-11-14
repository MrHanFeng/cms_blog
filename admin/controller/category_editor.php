<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php


  $value = get_category($_GET['cat_id']);
  if(isset($_POST['cat_id']) && !empty($_POST['cat_name']) ){
    // show($_POST);exit;
      $re = update_cate($_POST['cat_id'],$_POST['cat_name']);
      // show($re);exit;
      if($re){
        jump(2,PATH."category.php","修改分类成功","success");
      }else{
        jump(2,PATH."category.php","修改分类失败","error");
      }
  }
  ?>
 