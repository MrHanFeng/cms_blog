<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php

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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>链接页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：添加链接</div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td class="first_td">链接名称</td>
          <td class="second_td">
            <input type="text" name="link_name" value="<?php   if( isset($_GET['link_id']) ){ echo $link_info['link_name'] ;} ?>">
          </td>
        </tr>
        <tr>
          <td >介绍</td>
          <td>
            <input type="text" name="link_introduce" value="<?php  if( isset($_GET['link_id']) ){echo $link_info['link_introduce'];} ?>">
          </td>
        </tr>
        <tr>
          <td>链接地址</td>
          <td>
            <input type="text" name="link_url" value="<?php if( isset($_GET['link_id']) ){ echo $link_info['link_url'] ;}?>">
          </td>
        </tr>

        <?php if( isset($_GET['link_id']) ){  ?>
        <tr>
          <td>图片预览</td>          
          <td>
            <img src="<?php  echo __PUBLIC__."/". $link_info['link_img']?>" alt="链接图片" width=150 height=100>
            删除<input type="checkbox" name="del_pic" value="1">
          </td>
        </tr>
        <?php  } ?>

        <tr>
          <td>链接图片</td>
          <td>
            <input type="file" name="link_img">
          </td>
        </tr>     
        <tr>
          <td colspan=2>
            <?php if(  isset($_GET['link_id']) ){ ?>
                <input type="hidden" name="link_id" value="<?php if( isset($_GET['link_id']) ){echo  $link_info['link_id'] ;}?>">
            <?php } ?>
            <input type="submit" value="提交">
          </td>
        </tr>
      </table>
      </form>
    </div>
  </body>
</html>