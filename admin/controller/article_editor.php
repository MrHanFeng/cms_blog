<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php

  // 获取分类信息
  $cate_info = get_category_mes();

// 获取该篇文章信息,一位数组
  $art_info = get_article($_GET['article_id']);//为了获取此文章的所有信息显示在对应空上
    // show($art_info);


// 判断是否提交文章
  if(isset($_POST['article_title'] )&& isset($_POST['article_content'])){
      $re = update_article($art_info['article_id'],$_POST);
      if($re){
          // echo "success";
          jump(20,PATH."article.php","修改成功","success");
      }else{
        // echo "error";
          jump(2,PATH."article.php","修改失败","error");
      }
  }



 ?>
