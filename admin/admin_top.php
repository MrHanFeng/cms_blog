<?php 
  include_once "function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  if(isset($_GET['clear_s'])){
  	// echo "11111111111";
  	loginout();
  }
?>
<html>
<head>
<title>管理页面</title>

<script language=JavaScript1.2>
function showsubmenu(sid) {
	var whichEl = eval("submenu" + sid);
	var menuTitle = eval("menuTitle" + sid);
	if (whichEl.style.display == "none"){
		eval("submenu" + sid + ".style.display=\"\";");
	}else{
		eval("submenu" + sid + ".style.display=\"none\";");
	}
}
</script>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
<meta http-equiv="refresh" content="60">
<script language=JavaScript1.2>
function showsubmenu(sid) {
	var whichEl = eval("submenu" + sid);
	var menuTitle = eval("menuTitle" + sid);
	if (whichEl.style.display == "none"){
		eval("submenu" + sid + ".style.display=\"\";");
	}else{
		eval("submenu" + sid + ".style.display=\"none\";");
	}
}
</script>
<base target="main">
<link href="images/skin.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="64" border="0" cellpadding="0" cellspacing="0" class="admin_topbg">
  <tr>
    <td width="61%" height="64"><a href="<?php echo HOME_PATH ?>" title="点击返回前台首页" target="_blank "><img src="images/logo.gif" width="262" height="64"></a></td>
    <td width="39%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="74%" height="38" class="admin_txt">管理员：<b><?php echo @$_SESSION['mg_name']; ?></b> 您好,感谢登陆使用！</td>
        <td width="22%">
          <a href= <?php PATH ?> "right/change_pwd.php" target="main">
            <img src="images/editor.jpg" alt="修改密码" width="46" height="20" border="0">
          </a>
        </td>
        <td width="22%"><a href= <?php PATH ?> "admin_top.php?clear_s=1" target="_parent" onclick="return confirm('确定要退出？');"><img src="images/out.gif" alt="安全退出" width="46" height="20" border="0"></a></td>
        <td width="4%">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" colspan="3">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
