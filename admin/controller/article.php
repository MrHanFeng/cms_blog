
<?php 
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'article');

  // 检测在哪个页面，回收站和文章列表
  if(isset($_GET['sign'])){
    $status = "-1";
  }else{
    $status = "3";//查询默认值，即查询非删除类
  }

 
  // 根据用户需求设置排序规则 (switch)
  if(isset($_GET['order_a'])){
    $order = "  article_user_id DESC "; //按用户排序
  }elseif(isset($_GET['order_c'])){
    $order = " article_category_id DESC ";//分类排序
  }elseif(isset($_GET['order_s'])){
    $order = " article_status DESC ";//按发布状态排序
  }elseif(isset($_GET['order_c'])){
    $order = " article_create_time DESC ";//按发布时间排序
  }elseif(isset($_GET['order_u'])){
    $order = " article_update_time DESC ";//按更新时间排序
  }else{
    $order = " article_update_time DESC "; // 设置默认排序规则
  }


  // 查询文章信息(分页)返回三维信息
  if(!isset($_GET['page'])){
    $_GET['page']=1;
  }
  $ar_page = search_art_cate_user( $_GET['page'],10,$order,$status);
  $list = $ar_page['info'];//把数据信息给list
  $page = $ar_page['page_html'];//把HTML 代码返给page;

  // 检测是否有恢复操作
  if(isset($_GET['recover']) && $_GET['recover']="true"){
    $data['article_status']="0";
    $re = update_article($_GET['article_id'],$data);
    if($re){
      jump(2,PATH."article.php?sign=1","恢复成功","success");
    }else{
      jump(2,PATH."article.php?sign=1","恢复失败","error");
    }
    // echo  $_GET['article_id'];
    // echo "执行恢复";
  }

  // 检测是否有删除操作
  if(isset($_GET['del']) &&$_GET['del']="true"){
    $data['article_status']="-1";
    $re = update_article($_GET['article_id'],$data);
    if($re){
      jump(2,PATH."article.php","删除成功","success");
    }else{
      jump(2,PATH."article.php","删除失败","error");
    }
  }

?>
