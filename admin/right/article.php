<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php

  // 检测在哪个页面，回收站和文章列表
  if(isset($_GET['sign'])){
    $status = "已删除";
  }else{
    $status = "全部";
  }

  // 设置默认排序规则
  $order = " article_create_time DESC ";
  // 根据用户需求设置排序规则
  if(isset($_GET['order_a'])){
    $order = "  article_user_id DESC ";
  }elseif(isset($_GET['order_c'])){
    $order = " article_category_id DESC ";
  }elseif(isset($_GET['order_s'])){
    $order = " article_status DESC ";
  }

// 查询文章信息
  $list = search_art_cate_user($status,$order);

  // 检测是否有恢复操作
  if(isset($_GET['recover']) && $_GET['recover']="true"){
    $data['article_status']="未审核";
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
    $data['article_status']="已删除";
    $re = update_article($_GET['article_id'],$data);
    if($re){
      jump(2,PATH."article.php","删除成功","success");
    }else{
      jump(2,PATH."article.php","删除失败","error");
    }
  }

?>

<html>
  <head>
  <?php if(isset($_GET['sign'])){ ?>
    <title>文章页面</title>
  <?php }else{ ?>
    <title>回收站</title>
  <?php } ?>

    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
  <?php if(!isset($_GET['sign'])){ ?>
      <div class="title">当前位置：文章列表 
        <div style="float:right;"><a href="article_add.php">添加文章</a></div>
  <?php }else{ ?>
      <div class="title">当前位置：回收站 
  <?php } ?>
      </div><br>
          <table border=1 cellspacing=0 cellpadding=0 width="100%" align=center>
            <tr class="f_tr">
              <td width="35%">文章标题</td>
              <td width="10%"><a href="<?php echo PATH."article.php?order_a=true" ?>">作者</a></td>
              <td width="10%"><a href="<?php echo PATH."article.php?order_c=true" ?>">所属分类</a></td>
              <td width="10%"><a href="<?php echo PATH."article.php?order_s=true" ?>">发布状态</a></td>
              <td width="10%">发布时间</td>
              <td width="10%">修改时间</td>
              <td width="10%">操作</td>
            </tr>
 <?php  
          if(isset($list)){
                foreach ($list as $k => $v) {  ?>
                  <tr>
                      <td><?php echo "$v[article_title]"; ?></td>              
                      <td><?php echo "$v[username]"; ?></td>              
                      <td><?php echo  $v['cat_name']; ?></td>              
                      <td><?php echo "$v[article_status]"; ?></td>              
                      <td><?php echo date("Y-m-d H:i:s",$v['article_create_time']); ?></td>              
                      <td><?php echo date("Y-m-d H:i:s",$v['article_update_time']); ?></td>   
                      <td>
                        <?php if(isset($_GET['sign'])){ ?>
                        <a href="<?php  PATH?>article.php?recover=true&article_id=<?php echo $v['article_id']?>">恢复</a> 
                        <?php }else{ ?>
                        <a href="<?php  PATH?>article.php?del=true&article_id=<?php echo $v['article_id']?>">删除</a> 
                        <a href="article_editor.php?article_id=<?php echo $v['article_id']?>">修改</a>
                        <?php } ?>
                      </td>
                           
                  </tr>
<?php 
                }  
          }else{
            echo "<tr><td colspan=7><h1><br>抱歉，暂无信息</h1></td></tr>";
          }
         ?>

          </table>
    </div>
  </body>
</html>