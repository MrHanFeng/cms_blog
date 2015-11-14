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