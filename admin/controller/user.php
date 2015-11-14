<?php 
 	 include_once "../function.php";
 	 checkLogin();//检测是否登录，未登录，返回到login.php
check_auth($_SESSION['mg_id'],'user');

   /*分页开始*/
   // 定义默认查看第一页
   if(!isset($_GET['page'])){
     $_GET['page']=1;
   }
 	 // $user_info = get_user_mes();
   $arr = page(@$_GET['page'],6,"cms_user");
   $user_info = $arr['info'];
   $page = $arr['page_html'];
  	// show($user_info);

	// 删除用户信息页面
	if(isset($_GET['action']) && $_GET['action']="del" ){
	  $re = del_user($_GET['user_id']);
	  if($re){
	    jump(2,PATH."user.php","删除成功","success");
	  }else{
	    jump(2,PATH."user.php","删除失败","error");
	  }
}
  ?>