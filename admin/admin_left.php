<?php 
  include_once "function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  $all_list = get_list();
  $p_list=$all_list['p_list'];
  $c_list=$all_list['c_list'];
  // show($p_list);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理页面</title>

<script src="js/prototype.lite.js" type="text/javascript"></script>
<script src="js/moo.fx.js" type="text/javascript"></script>
<script src="js/moo.fx.pack.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/admin_left.css" />

</head>

<body>
<table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
  <tr>
    <td width="182" valign="top">
    <div id="container">
      
      <?php foreach ($p_list as $v): ?>
        
      
      <h1 class="type"><a href="javascript:void(0)"><?php echo $v['auth_name'] ?></a></h1>
      <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
          </tr>
        </table>
        <ul class="MM">
          <?php foreach ($c_list as $vv): ?>
          <?php if($vv['auth_pid'] ==$v['auth_id']){ ?>
            <li><a href="right/<?php echo $vv['auth_a'] ?>.php" target="main"><?php echo $vv['auth_name'] ?></a></li>
          <?php } ?>
          <?php endforeach ?>
        </ul>
      </div>
      <?php endforeach ?>







      </div>
      </div>
        <script type="text/javascript">
		var contents = document.getElementsByClassName('content');
		var toggles = document.getElementsByClassName('type');
	
		var myAccordion = new fx.Accordion(
			toggles, contents, {opacity: true, duration: 400}
		);
		myAccordion.showThisHideOpen(contents[0]);
	</script>
    </td>
  </tr>
</table>
</body>
</html>
