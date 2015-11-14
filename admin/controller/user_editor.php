<?php 
  include_once "../function.php";
  checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'user_editor');


//获取信息填默认值
  if(isset($_GET['action']) && $_GET['action']="update" ){
      $user_info = get_user($_GET['user_id']);
  }


// 添加用户页面
  if(!empty($_POST)){
    // 修改用户信息页面
    if(isset($_GET['action']) && $_GET['action']="update" ){
//        if(strlen($_POST['password']) < 6 ){
//           jump(2,PATH."user.php","密码并不能小于6位","error");
//        }elseif($_POST['password'] !== $_POST['c_password']){
//           jump(2,PATH."user.php","两次密码不相同","error");
//        }
        unset($_POST['c_password']);
        $re = update_user($_GET['user_id'],$_POST);
        if($re){
          jump(2,PATH."user.php","修改成功","success");
        }else{
          jump(2,PATH."user.php","修改失败","error");
        }
    }else{//添加用户页面
//        $result_check = check_reg($_POST);//进行注册验证
//        if($result_check['bool']){
        $result_check = check_reg($_POST);//进行注册验证
      if($result_check['bool']){
        if(array_key_exists("c_password", $_POST)){
          unset($_POST['c_password']);
        }

        $re_insert = insert_user($_POST);
        if($re_insert){
          jump(2,PATH."user.php","插入成功","success");
        }else{
          jump(2,PATH."user_editor.php","插入失败","error");
        }
      }else{
        jump(2,PATH."user_editor.php","$result_check[info]","error");
      }
    }

    
  }


?>