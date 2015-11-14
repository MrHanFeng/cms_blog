<?php 
  include_once "../function.php";
  include_once "../controller/article_add.php";
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>文章页面</title>
    <meta http-equiv="content-type" content="texl/html;charset=utf-8" >
    <!--  文章编辑器 -->
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js"></script>
    <!--  END文章编辑器 -->
    <link rel="stylesheet" href="../css/article.css">
    <style>

    </style>
  </head>
 <body>
    <div class="contain">
      <div class="title">当前位置：添加文章</div>
      <form action="" method="post">
        <table class="first_table" >
          <tr>
            <td class="first_td">文章标题: </td>
            <td class="second_td">
              <input type="text" value="" name="article_title" class="title_input" >
            </td>
          </tr>
          <tr>
            <td>分类:</td>
            <td>
              
              <select name="article_category_id" >
                <option value="0">--请选择--</option>
      <?php  foreach ($cate_info as $k =>$v){ ?>
                 <option value='<?php echo $v['cat_id']; ?>' > <?php echo $v['cat_name']; ?>
                  </option>
      <?php  }  ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>内容</td>
            <td align=center>
                <script name="article_content" id="editor" value="111" type="text/plain" style="width:860px;height:400px;">
                </script>             
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="article_user_id" value="0">
              <input type="submit" value="提交"  >
            </td>
            <td>
            </td>
          </tr>
        </table>
      </form>
  


    <!--  文章编辑器 -->
      <script>
        var ue = UE.getEditor('editor');
      </script>

    </div>
  </body>
</html>

