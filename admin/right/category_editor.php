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
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
  <html>
    <head>
      <title>分类列表</title>
      <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
      <link rel="stylesheet" href="../css/article.css">
      <style>

      </style>
    </head>
    <body>
      <div class="contain">
        <div class="title">当前位置：修改分类信息 
		</div>
      <form action="" method="post">
        <table border=1 align=center cellpadding=5>
          <tr >
            <td width=10%>分类编号</td>
            <td width=10%>分类名称</td>
          </tr>
          <tr>
            <td>  <?php echo $value['cat_id'] ?> </td>
            <td> 
              <input type="hidden" name="cat_id" value="<?php echo $value['cat_id'] ?> "> 
              <input type="text" name="cat_name" value="<?php echo $value['cat_name'] ?> "> 
            </td>
          </tr>
          <tr>
            <td colspan=2 align=center>
              <input type="submit" value="提交">
            </td>
          </tr>
        </table>
      </form>
            
      </div>
    </body>
  </html>