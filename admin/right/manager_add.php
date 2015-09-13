<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'manager_add');

  // 获得管理员角色信息，做下拉选项
   $role_info = get_role();


   // 区分是修改页面还是添加页面
    if(isset($_GET['mg_id'])&& $_GET['action']="editor" ){
       $mg_info = get_manager($_GET['mg_id']);
    }
   // 对新添加的信息进行检查
   if($_POST){

        if(strlen($_POST['mg_pwd'])<6 ){
          echo "请输入大于6位的密码";exit;
        }elseif($_POST['mg_pwd'] !=$_POST['mg_pwd2']){
          echo "两次密码不相同";exit;
        }else{
          array_pop($_POST);
        }

        if(isset($_GET['mg_id'])&& $_GET['action']="editor" ){
          $re = update_manager($_GET['mg_id'],$_POST);
          $word="更新";
        }else{
          $re = insert_manager($_POST);
          $word="插入";
        }

        if($re){
          jump(2,PATH."manager.php",$word."成功","success");
        }else{
          jump(2,PATH."manager.php",$word."失败","error");
        }


    }
   
    
  



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>管理员添加</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：管理员添加</div>
      <form action="" method="post" enctype="multipart/form-data">
        
      <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
        <tr>
          <td >管理员姓名</td>
          <td>
            <input type="text" name="mg_username" value="<?php  if( isset($_GET['mg_id']) ){echo $mg_info['mg_username'];} ?>">
          </td>
        </tr>
        <tr>
          <td>管理员角色</td>
          <td>
              <select name="mg_role_id" >
                <option value="0">---请选择--</option>
                <?php foreach ($role_info as $k => $v): ?>
                    <option value=" <?php echo $v['role_id'] ;?> "  <?php if(@$mg_info['mg_role_id'] == $v['role_id']) {echo 'selected';} ?>  > <?php echo $v['role_name'] ?></option>
                <?php endforeach ?>
              </select>
          </td>
        </tr>
        <tr>
          <td class="first_td">登录帐号</td>
          <td class="second_td">
            <input type="text" name="mg_name" value="<?php   if( isset($_GET['mg_id']) ){ echo $mg_info['mg_name'] ;} ?>">
          </td>
        </tr>
        <tr>
          <td>密码</td>
          <td>
          <?php  
            if( isset($_GET['mg_id']) ){
           ?>
              <input type="hidden" name="mg_id" value="<?php echo $_GET['mg_id'];?>">

          <?php
           }
          ?>
            <input type="password" name="mg_pwd" >
          </td>
        </tr>
        <tr>
          <td>确认密码</td>
          <td>
            <input type="password" name="mg_pwd2" >
          </td>
        </tr>
        <tr>
          <td colspan=2><input type="submit" value="提交"></td>
        </tr>
      </table>
      </form>
    </div>
  </body>
</html>