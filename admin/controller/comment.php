<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'comment');


  // 检测在那个页面，回收站和文章列表
  $order = " article_create_time DESC ";

  //确定排序方式 
  if(isset($_GET['order_a'])){
    $order = "  article_user_id DESC ";
  }elseif(isset($_GET['order_c'])){
    $order = " article_category_id DESC ";
  }elseif(isset($_GET['order_s'])){
    $order = " article_status DESC ";
  }

  /*默认为第一页*/
  if(!isset($_GET['page'])){
    $_GET['page']=1;
  }
  $ar_page = search_art_cate_user( $_GET['page'],10,$order);
  $list = $ar_page['info'];//把数据信息给list
  $page = $ar_page['page_html'];//把HTML 代码返给page;

// 返回评论数
  $com_num = get_com_num();
?>

