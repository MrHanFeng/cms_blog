<?php 
  include_once "../controller/category_add.php";
  ?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
  <html>
    <head>
      <title>分类添加</title>
      <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
      <link rel="stylesheet" href="../css/article.css">
      <style>

      </style>
    </head>
    <body>
      <div class="contain">
        <div class="title">当前位置：分类添加 
        	<form action="" method="post">
        		<table border=1 cellpadding=5 cellspacing=5 align=center ><br>
        			<tr>
        				<td>分类名称</td>
        				<td><input type="text" name="cat_name"></td>
        			</tr>
        			<tr>
        				<td colspan=2 align=center> <input type="submit" value="提交"></td>
        			</tr>
        		</table>
        	</form>
		</div>
        <table border=1>
        	<tr></tr>
        </table>
            
      </div>
    </body>
  </html>