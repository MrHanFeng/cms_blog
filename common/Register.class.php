<?php

	class Register{

		private $user_email;
		private $password;
		private $password_two;
		private $pwd_length=2;  	//规定注册时密码默认的长度
		private $validate;
		private $_table;		//所查询的表格

// 初始化
		function __construct($user_email,$password,$password_two,$validate,$table){
			$this->user_email = $user_email;
			$this->password = $password;
			$this->password_two = $password_two;
			$this->validate = strtolower($validate);
			$this->_table = $table;
		}



// 加密
		protected function md6($password){
			return md5(md5($password));	
		}


	/**
	*	验证注册信息时候正确
	*	@return 二维数组
	*		布尔值 $return['result']= true ; false
	*		错误信息 $return['error_info'];
	*/
	function checkreg(){
		$username_model="/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";		//正则验证用户名
		$return=array();
		$mysql =M($this->_table);
		$result = $mysql->where("user_email='$this->user_email' ")->find();
		if(!empty($result)){
			$return['result'] = false;
			$return["error_info"]="用户已经存在";	
		}elseif(!isset($_SESSION['validate']) || $this->validate != $_SESSION["validate"]){
			$return["result"] = false;
			// echo $this->validate."提交的验证码<br>";
			// print_r($_SESSION);	
			$return["error_info"] =$_SESSION["validate"]."是错误的验证码";
		}elseif(!preg_match($username_model,$this->user_email)){
			$return['result']=false;
			$return['error_info']="用户名不合法，请重新输入";
		}else if(strlen($this->password) < $this->pwd_length){
			$return['result']=false;
			$return['error_info']="密码过短，请重新设置";
		}else if($this->password_two != $this->password){
			// echo $this->password_two."<br>";
			// echo $this->password;
			$return['result']=false;
			$return["error_info"]="两次密码输入不一致";
		}else{
			$return['result']=true;
			$return["error_info"]="验证成功";
		}
		return $return;
	}


	/**
	*	注册插入数据
	*	@return 成功返回true 失败返回false
	*/
	function register(){
		$mysql = M($this->_table);
		$pwd = $this->md6($this->password);//把密码加密
		$data = array("user_email" =>$this->user_email , "password" => $pwd );
		$re = $mysql->data($data)->insert();
		// echo $mysql->getLastSql();
		// show($re);exit;
		if($re){
			return true;
		}
		return false;
	}

}


?>