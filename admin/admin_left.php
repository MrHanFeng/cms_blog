<?php 
  include_once "function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
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
      


      <h1 class="type"><a href="javascript:void(0)">文章管理</a></h1>
      <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
          </tr>
        </table>
        <ul class="MM">
          <li><a href="right/article.php" target="main">文章列表</a></li>
          <li><a href="right/article_add.php" target="main">添加文章</a></li>
          <li><a href="right/category.php" target="main">分类列表</a></li>
          <li><a href="right/category_add.php" target="main">添加分类</a></li>
          <li><a href="right/article.php?sign=1" target="main">回收站</a></li>
        </ul>
      </div>


      <h1 class="type"><a href="javascript:void(0)">留言管理</a></h1>
      <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
          </tr>
        </table>
        <ul class="MM">
		  <li><a href=" " target="main">评论列表</a></li>
		  <li><a href=" " target="main">回收站</a></li>
          
        </ul>
      </div>
      <h1 class="type"><a href="javascript:void(0)">注册用户管理</a></h1>
      <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
          </tr>
        </table>
        <ul class="MM">
          <li><a href=" " target="main">会员管理</a></li>
          <li><a href=" " target="main">留言管理</a></li>
          <li><a href=" " target="main">回复管理</a></li>
          <li><a href=" " target="main">订单管理</a></li>
          <li><a href=" " target="main">举报管理</a></li>
          <li><a href="right/comment.php" target="main">评论管理</a></li>
        </ul>
      </div>

	      <h1 class="type"><a href="javascript:void(0)">网站常规管理</a></h1>
	      <div class="content">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
	          </tr>
	        </table>
	        <ul class="MM">
	          <li><a href=" " target="main">基本设置</a></li>
	          <li><a href=" " target="main">邮件设置</a></li>
	          <li><a href=" " target="main">广告设置</a></li>
	          <li><a href=" " target="main">联系方式</a></li>
	          <li><a href=" right/link.php" target="main">管理链接</a></li>
            <li><a href="right/link_add.php" target="main">增加链接</a></li>
	        </ul>
	      </div>
    </div>
        <h1 class="type"><a href="javascript:void(0)">其它参数管理</a></h1>
      <div class="content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="images/menu_topline.gif" width="182" height="5" /></td>
            </tr>
          </table>
        <ul class="MM">
            <li><a href=" " target="main">管理设置</a></li>
          <li><a href=" " target="main">主机状态</a></li>
          <li><a href=" " target="main">攻击状态</a></li>
          <li><a href=" " target="main">登陆记录</a></li>
          <li><a href=" " target="main">运行状态</a></li>
        </ul>
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
