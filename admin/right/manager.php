<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'manager');


  $manager_info = get_manager_mes();


// 如果有删除操作
  if(@$_GET['mg_id']){
    $re = del_manager($_GET['mg_id']);
    if($re){
         jump(2,PATH."manager.php","删除成功","success");
     }else{
         jump(2,PATH."manager.php","删除失败","error");
     }
  }

  

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>管理员列表页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：管理员列表
       <div style="float:right;"><a href="manager_add.php">添加管理员</a></div>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table  border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td >管理员帐号</td>
          <td >管理员姓名</td>
          <td>管理员角色</td>
          <td>上次登录时间</td>        
          <td>登录次数</td> 
          <td>修改</td> 
          <td>删除</td> 
        </tr>
        <?php foreach ($manager_info as  $v): ?>
        <tr>
          <td><?php echo $v['mg_name'] ?></td>
          <td><?php echo $v['mg_username'] ?></td>
          <td><?php echo $v['mg_role_id'] ?></td>
          <td><?php echo date("Y-m-d H:i:s",$v['mg_time'] )?></td>
          <td><?php echo $v['mg_num'] ?></td>
          <td>
            <a href=" <?php echo PATH."manager_add.php?action=editor&mg_id=$v[mg_id]" ?>">
             <img src="../images/edit.png" alt="修改">
            </a>
          </td>
          <td>
            <a href=" <?php echo PATH."manager.php?action=del&mg_id=$v[mg_id]" ?>" onclick="return confirm('确定删除？');">
              <img src="../images/del.png" alt="删除">
            </a>
          </td>

        </tr>
        <?php endforeach ?>
      </table>
      </form>
    </div>
  </body>
</html>