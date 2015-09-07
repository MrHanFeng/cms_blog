<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php


  $comm_info = get_comment($_GET['cm_arid']);
  // show($comm_info);exit;


// 判断是否存在审核通过或取消操作
  if(isset($_GET['action']) && isset($_GET['cm_id'])){
    switch ($_GET['action']) {
      case 'check_go':
        $data['cm_status']="1";
        break;
      case 'check_cel':
        $data['cm_status']="0";
        break;
    }
    $re = update_comm($_GET['cm_id'],$data);
    // show($re);exit;
    if($re){
      // echo "$_GET[cm_id]";exit;
// echo PATH."comment_details.php?cm_arid=".$_GET['cm_id'];exit;
      jump(2, PATH."comment_details.php?cm_arid=".$_GET['cm_arid'] ,"操作成功","success");
    }else{
      jump(2,PATH."comment_details.php?cm_arid=".$_GET['cm_arid'],"操作失败","error");
    }
  }

// http://localhost/shixun/cms_blog/admin/right/comment_details.php?cm_arid=2
// http://localhost/shixun/cms_blog/admin/right/comment_details.php?cm_arid=9
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