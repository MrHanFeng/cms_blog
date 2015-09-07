<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
  check_auth($_SESSION['mg_id'],'category');

  $cate_info = get_category_mes();

  // 执行删除操作
  if(isset($_GET['del']) && $_GET['del']=="true"){
  		$re = del_cate($_GET['cat_id']);
      // echo $re;exit;
  		 if($re){
  			jump(2,PATH."category.php","删除分类成功","success");
  		 }else{
  		 	exit;
  			jump(2,PATH."category.php","删除分类失败","error");
  		 }
  }


  ?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
  <html>
    <head>
      <title>分类列表</title>
      <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
      <link rel="stylesheet" href="../css/article.css">
      <style>

      </style>
    </head>
    <body>
      <div class="contain">
        <div class="title">当前位置：分类列表 
        	<div style="float:right;"><a href="category_add.php">添加分类</a></div>
		</div>
        <table border=1 align=center cellpadding=5>
        	<tr >
        		<td width=10%>分类编号</td>
        		<td width=10%>分类名称</td>
        		<td width=50% align=center>操作</td>

        	</tr>
        	<?php foreach ($cate_info as $key => $value) {?>
        	 <tr>
            <td><?php echo $value['cat_id'] ?></td>
            <td><?php echo $value['cat_name'] ?></td>
            <td align=center>
              <a href="category.php?del=true&cat_id=<?php echo $value['cat_id']?>">删除</a>
              <a href="category_editor.php?cat_id=<?php echo $value['cat_id']?>">修改</a>
              

          <!-- 想写删除此类前，把这类的文章所属类，归入其他类 ==》失败。
              <button onclick="document.getElementById('del_sel<?php echo $value['cat_id']?>').style.display='block';">删除</button>
              <select name="cat_id" id="del_sel<?php echo $value['cat_id']?>" style="display:none;clear:both;">
                  <option value="0">--归入其他分类--</option>
                  <option value="<?php echo $value['cat_id'] ?>" onclick="alert('11')">
                      <?php echo $value['cat_name'] ?>
                  </option>
              </select>
            </td>
          -->
          </tr> 
        	<?php } ?>
        </table>
            
      </div>
    </body>
  </html>