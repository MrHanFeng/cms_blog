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
