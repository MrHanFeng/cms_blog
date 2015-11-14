<?php 
 include_once "../controller/role_editor.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>修改角色权限页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <link rel="stylesheet" href="../css/article.css">
  </head>
  <body>
    <div class="contain">
      <div class="title">当前位置：修改角色权限</div>
      <form action="" method="post" enctype="multipart/form-data">
        
          <table class="first_table" border=1 cellspacing=2 cellpadding=5 >
            <?php foreach ($parent as $k => $v): ?>
              <tr>
                <td width=17%>
                  <strong>
                    <?php  
                      echo $v['auth_name']

                      ?>:
                    <input type="checkbox" name="auth_id[]" value= "<?php echo $v['auth_id']; ?>" <?php if(in_array($v['auth_id'],$role_auth_id))echo "checked"; ?> >
                  </strong></td> 
                <td>
                  <table  cellspacing=2 cellpadding=5>
                  <?php  
                  foreach ($child as $kk => $vv) { 
                    if($v['auth_id']==$vv['auth_pid']){
                  ?>  
                
                    <tr>
                      <td><?php echo $vv['auth_name']; ?></td>
                      <td><input type="checkbox" name="auth_id[]" value="<?php echo $vv['auth_id'] ?>" <?php if(in_array($vv['auth_id'],$role_auth_id))echo "checked"; ?>></td>
                    </tr>
                   
                  <?php }
                  } ?> 
                  </table>
                </td>  
              </tr>
            <?php endforeach ?>
              <tr>
                <td colspan=2>
                    <input type="hidden" value="<?php echo $_GET['role_id']?>" name="role_id">
                    <input type="submit" value="提交">
                </td>
              </tr>
          </table>
      </form>
    </div>
  </body>
</html>