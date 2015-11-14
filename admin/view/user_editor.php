<?php 
include_once "../controller/user_editor.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>文章页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
    <style>

    </style>
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：会员操作</div>
      <form action="" method="post" enctype="multipart/form-data">
          <table class="first_table" border=2 cellpadding=2>
            <tr>
              <td>登录邮箱</td>
              <td>
                <?php if(isset($user_info)){ 
                   if(isset($user_info)){ echo $user_info['user_email']; } ?>
                <?php }else{ ?>
                   <input type="text" name="user_email" >
                <?php } ?>
              </td>
            </tr>            
            <tr>
              <td>用户名</td>
              <td>
                  <input type="text" name="username" value="<?php if(isset($user_info)){ echo $user_info['username']; } ?>">
                  <?php if(isset($_GET['action']) && $_GET['action']="update" ){ ?>
                      <input type="hidden" value="<?php echo $_GET['user_id'];?>" name="user_id">
                  <?php  } ?>
              </td>
            </tr>
            <tr>
              <td>密码</td>
              <td><input type="password" name="password"></td>
            </tr>          
            <tr>
              <td>确认密码</td>
              <td><input type="password" name="c_password"></td>
            </tr>          
            <tr>
              <td>电话号</td>
              <td><input type="text" name="user_tel" value="<?php if(isset($user_info)){ echo $user_info['user_tel']; } ?>"></td>
            </tr>
              <?php if( isset($_GET['user_id']) ){  ?>
                  <tr>
                      <td>图片预览</td>
                      <td>
                          <img src="<?php  echo __PUBLIC__."/". $user_info['user_img']?>" alt="链接图片" width=100 height=100>
                          删除<input type="checkbox" name="del_pic" value="1">
                      </td>
                  </tr>
              <?php  } ?>
              <tr>
                  <td>添加头像</td>
                  <td>
                      <input type="file" name="user_img">
                  </td>
              </tr>
            <tr>
              <td colspan=2>
                <input type="submit" value="提交">
              </td>
            </tr>
          </table>
      </form>
    </div>
  </body>
</html>