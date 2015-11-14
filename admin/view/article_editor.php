<?php 
 include_once "../controller/article_editor.php";
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
              <input type="text" value="<?php   echo  $art_info['article_title']; ?>" name="article_title"  class="title_input" >
            </td>
          </tr>
          <tr>
            <td>分类:</td>
            <td>
              
              <select name="article_category_id" >
                <option value="0">--请选择--</option>
      <?php  foreach ($cate_info as $k =>$v){ ?>
                 <option value='<?php echo $v['cat_id']; ?>'  
                    <?php  
                              /*选中默认数据库里的值*/
                              if($v['cat_id'] == $art_info['article_category_id']){
                                 echo 'selected="selected"';
                               } 
                    ?>  
                  > <?php echo $v['cat_name']; ?>
                  </option>
      <?php  }  ?>
              </select>
            </td>
          </tr>


     
          <tr>
              <td>状态</td>
              <td>
                <select name="article_status" >
                  <option value="1" <?php if($art_info['article_status'] == "1"){echo 'selected="selected"';}?> >已审核</option>
                  <option value="0" <?php if($art_info['article_status'] == "0"){echo 'selected="selected"';}?>>未审核</option>
                  <option value="2" <?php if($art_info['article_status'] == "2"){echo 'selected="selected"';}?>>审核未通过</option>
                </select>
                <input type="hidden" name="article_update_time" value="<?php  echo time();?>">
              </td>
          </tr>
          <tr>
            <td>内容</td>
            <td align=center>
                <script name="article_content" id="editor"  type="text/plain" style="width:850px;height:400px;">
                    <?php  echo $art_info['article_content']; ?>
                </script>             
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="article_user_id" value=" <?php  echo $art_info['article_user_id']; ?> ">
              <input type="submit" value="提交"  >
            </td>
            <td></td>
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

