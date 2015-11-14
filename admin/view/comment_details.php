<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../controller/comment_details.php";
?>

<html>
  <head>
    <title>评论列表</title>

    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <table border=1 cellspacing=0 cellpadding=0 width="100%" align=center class="second_table">
        <tr class="f_tr">
          <td width="10%">评论者ID</td>
          <td width="30%">评论内容</td>
          <td width="20%">评论时间</td>
          <td width="10%">评论状态</td>
          <td width="15%">操作</td>
        </tr>
 <?php  
      if(!empty($comm_info)){ 
          foreach ($comm_info as $key => $value) {
        ?>
              <tr>
                  <td><?php echo $value['cm_user_id'] ?></td>              
                  <td><?php echo $value['cm_content']; ?></td>              
                  <td><?php echo  date("Y-m-d H:i:s",$value['cm_time']); ?></td>              
                  <td>
                    <?php
                      if( $value['cm_status'] == 1) {
                          $stu ="已审核";
                       } else{
                          $stu ="未审核";
                       }
                      echo $stu;
                     ?>
                  </td>              
                  <td>
                    <?php if($value['cm_status'] == "1" ){?>
                      <a href="<?php echo PATH."comment_details.php?action=check_cel&cm_id=$value[cm_id]&cm_arid=$value[cm_arid]" ?>">取消审核</a>
                    <?php }else{ ?>
                       <a href="<?php echo PATH."comment_details.php?action=check_go&cm_id=$value[cm_id]&cm_arid=$value[cm_arid]" ?>">通过审核</a>
                    <?php } ?>
                  </td>              
              </tr>
<?php       }
      }else{
        echo "<tr><td colspan=7><h1><br>抱歉，暂无评论信息</h1></td></tr>";
      }
         ?>

      </table>
    </div>
  </body>
</html>