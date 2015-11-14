<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'category');

  $cate_info = get_category_mes();

  // 执行删除操作
  if(isset($_GET['del']) && $_GET['del']=="true"){
  		$re = del_cate($_GET['cat_id']);
      // echo $re;exit;
  		 if($re){
  			jump(2,PATH."category.php","删除分类成功","success");
  		 }else{
  		 	exit;
  			jump(2,PATH."category.php","删除分类失败","error");
  		 }
  }


  ?>
 