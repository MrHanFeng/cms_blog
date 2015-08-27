<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php

  $arr = search_art_user();

// 如果有回收信号，为回收页面，否则为正常页面
  if(isset($_GET['del_signal']) && $_GET['del_signal'] ==1){
    $cate_arr = search_art_cate("已删除");
  }else{
    $cate_arr = search_art_cate("全部");
  }



?>

<html>
  <head>
    <title>文章页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <style>

      .contain{
        width:100%;
        height:650px;
        background:#EEF2FB;
      }
      .title{
        height:30px;
        line-height: 30px;
        background: url('../images/bg.gif');
        border-top: 6px solid black;
        border-bottom: 3px solid gray;
      }

      .f_tr{
          height: 40px;
          line-height: 42px;
          font: normal 600 16px/18px "宋体";
          background:#3C5E7C;
      }

      td{
        text-align: center;   
        height: 30px;
        line-height: 32px;
      }
    </style>
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：文章列表 
        <div style="float:right;"><a href="article_add.php">添加文章</a></div>
      </div><br>
          <table border=1 cellspacing=0 cellpadding=0 width="100%" align=center>
            <tr class="f_tr">
              <td width="35%">文章标题</td>
              <td width="10%">作者</td>
              <td width="10%">所属分类</td>
              <td width="10%">发布状态</td>
              <td width="8%">发布时间</td>
              <td width="8%">修改时间</td>
              <td width="10%">操作</td>
            </tr>
          <?php  foreach ($arr as $k => $v) {  ?>
          <tr>
              <td><?php echo "$v[article_title]"; ?></td>              
              <td><?php echo "$v[username]"; ?></td>              
              <td><?php echo  $cate_arr[$v['article_category_id']]['cat_name']; ?></td>              
              <td><?php echo "$v[article_status]"; ?></td>              
              <td><?php echo "$v[article_create_time]"; ?></td>              
              <td><?php echo "$v[article_update_time]"; ?></td>   
              <?php if(isset($_GET['del_signal']) && $_GET['del_signal'] ==1){ ?>  
                <a href="article_recover.php?article_id=<?php echo $v['article_id']?>">恢复</a> 
              <?php }else{ ?>         
              <td>
                <a href="article_del.php?article_id=<?php echo $v['article_id']?>">删除</a> 
                <a href="article_editor.php?article_id=<?php echo $v['article_id']?>">修改</a>
              </td>  
              <?php } ?>                         
          </tr>
        <?php } ?>

          </table>
    </div>
  </body>
</html>