<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'category_add');

  if(isset($_POST['cat_name'])){
  	$arr['cat_name'] =$_POST['cat_name'];
  	$re = insert_cate($arr);
  	if($re){
  		jump(2,PATH."category.php","插入分类成功","success");
  	}else{
  		jump(2,PATH."category_add.php","插入分类失败","error");
  	}
  }

  ?>
 