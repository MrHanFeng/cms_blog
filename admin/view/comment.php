<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
 include_once "../controller/comment.php";
?>

<html>
  <head>
    <title>评论列表</title>

    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/pager.css">
  </head>
  <body>
    <div class="contain">
      <table border=1 cellspacing=0 cellpadding=0 width="100%" align=center class="second_table">
        <tr class="f_tr">
          <td width="35%">文章标题</td>
          <td width="10%"><a href="<?php echo PATH."comment.php?order_a=true" ?>">作者</a></td>
          <td width="10%"><a href="<?php echo PATH."comment.php?order_c=true" ?>">所属分类</a></td>
          <td width="10%"><a href="<?php echo PATH."comment.php?order_s=true" ?>">发布状态</a></td>
          <td width="10%">评论条数</td>
        </tr>
 <?php  
      if(isset($list)){
            foreach ($list as $k => $v) {  
              // echo PATH."comment_details.php?cm_arid=".$v['article_id'] ;?>
              <tr>
                  <td><a href=" <?php echo PATH."comment_details.php?cm_arid=".$v['article_id'] ?>"><?php echo "$v[article_title]"; ?></a></td>              
                  <td><?php echo "$v[username]"; ?></td>              
                  <td><?php echo  $v['cat_name']; ?></td>              
                  <td><?php 
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
                  <td>
                    <?php
                      if(isset($com_num[$v['article_id']])){
                        echo  $com_num[$v['article_id']];
                      }else{
                        echo "0";
                      }
                       ?>
                    条
                  </td>              
              </tr>
<?php 
                }  
          }else{
            echo "<tr><td colspan=7><h1><br>抱歉，暂无文章信息</h1></td></tr>";
          }
         ?>

      </table>
    <?php  echo $page; ?>
    </div>
  </body>
</html>