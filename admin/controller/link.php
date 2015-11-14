<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'link');


  // 定义默认查看第一页
  if(!isset($_GET['page'])){
    $_GET['page']=1;
  }
  $link_arr = get_link_mes(@$_GET['page'],5);
  // $link_arr = page(@$_GET['page'],5,"cms_link");
  $link_info =$link_arr['info'];//通用分页,但满足不了不加排序条件
  $page =$link_arr['page_html'];

// 列表置顶功能
  if(@$_GET['action']=="up"){
  	$re = update_link($_GET['link_id'],$_GET['action']);
  	if($re){
  	  jump(2,PATH."link.php","置顶成功","success");
  	}else{
  	  jump(2,PATH."link.php","置顶失败","error");
  	}
  }

  // 删除指定列表
  if(@$_GET['action']=="del"){
  	$re = del_link($_GET['link_id']);
  	if($re){
  	  jump(2,PATH."link.php","删除成功","success");
  	}else{
  	  jump(2,PATH."link.php","删除失败","error");
  	}
  }
?>
