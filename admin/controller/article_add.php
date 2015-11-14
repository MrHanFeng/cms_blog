<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'article_add');
  $cate_info = get_category_mes();

// 判断是否提交文章
  if( isset($_POST['article_title']) ){
      if(empty($_POST['article_title'] )&& empty($_POST['article_content'])){
          jump(2,PATH."article_add.php","标题和内容不能为空","error");
      }
      $re = insert_article($_POST);
      if($re){
          // echo "success";
          jump(2,PATH."article.php","插入成功","success");
      }else{
        // echo "error";
          jump(2,PATH."article_add.php","插入失败","error");
      }
  }



 ?>
