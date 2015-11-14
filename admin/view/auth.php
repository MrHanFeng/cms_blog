<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php 
   include_once "../controller/auth.php";
?>

<html>
  <head>
    <title>权限页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/pager.css"><!--引入分页CSS-->
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：权限 
        <div style="float:right;"><a href="auth_add.php">添加权限</a></div>
      </div><br>
          <table border=1 cellspacing=1 cellpadding=2 width="100%" align=center>
            <tr class="f_tr">
              <td width="5%">权限ID</td>
              <td width="5%">权限父级ID</td>
              <td width="10%">权限名称</td>
              <td width="10%">页面名称</td>
              <td width="10%">权限路径</td>
              <td width="10%">权限等级</td>
              <td width="5%">修改</td>
              <td width="5%">删除</td>
            </tr>
 <?php if(isset($auth_info)){
          foreach ($auth_info as $k => $v) {  ?>
          <tr>
              <td><?php echo $v['auth_id'] ?></td>            
              <td><?php echo $v['auth_pid'] ?></td>            
              <td><?php echo $v['auth_name'] ?></td>            
              <td><?php echo $v['auth_a'] ?></td>            
              <td><?php echo $v['auth_path'] ?></td>            
              <td><?php echo $v['auth_level'] ?></td>            
              <td>
                <a href="<?php echo PATH."auth_add.php?auth_id=$v[auth_id]" ?>">
                   <img src="../images/edit.png" alt="修改">
                </a>
              </td>   
              <td>                                                                   
                <a href="<?php echo PATH."auth.php?action=del&auth_id=$v[auth_id]" ?> " onclick="return confirm('确定要删除？')"; >
                   <img src="../images/del.png" alt="删除">
                </a>
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