<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../function.php";
  include_once "../controller/article.php";
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
    <link rel="stylesheet" href="../css/pager.css"><!--引入分页CSS-->
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
              <td width="10%"><a href="<?php echo PATH."article.php?order_c=true" ?>">发布时间</a></td>
              <td width="10%"><a href="<?php echo PATH."article.php?order_u=true" ?>">修改时间</a></td>
              <td width="10%">操作</td>
            </tr>
 <?php  
          if(isset($list)){
                foreach ($list as $k => $v) {  ?>
                  <tr>
                      <td><?php echo "$v[article_title]"; ?></td>              
                      <td><?php echo "$v[username]"; ?></td>              
                      <td><?php echo  $v['cat_name']; ?></td>              
                      <td>
                        <?php 
                          switch ($v['article_status']) {
                            case '0':
                              $_sta = "未审核";
                              break;
                            case '1':
                              $_sta = "已审核";
                              break;
                            case '2':
                              $_sta = "审核未通过";
                              break;
                            case '-1':
                              $_sta = "已删除";
                              break;
                            default:
                              $_sta = "状态出错，请联系管理员";
                              break;
                          }
                          echo $_sta; 
                        ?>
                      </td>              
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
          <?php echo $page; ?>
    </div>
  </body>
</html>