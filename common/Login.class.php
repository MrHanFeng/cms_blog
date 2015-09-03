<?php
	// include "../MySql.class.php";


	class Login{
		private $user_id;			//用户ID
		private $user_email;	//用户登录帐号
		private $password;		//用户输入的面膜
		private $sql_password;	//数据库的正确密码
		private $affect_num = 0;	
		private $remember;		//是否有记住密码功能
		private $validate;		//存储验证码
		private $_table;		//设置操作的表

// 构造方法
	function __construct(){
			
	}

//传入参数 
	function set($user_email,$password,$remember,$validate,$table){
		$this->user_email = $user_email;
		$this->password = $this->md6($password);
		$this->remember = $remember;
		$this->_table = $table;
		$this->validate = strtolower($validate);
	}

// 加密方法
	protected function md6($password){
		return md5(md5($password));	
	}


	/**
	*	统一设置SESSION字段值，方便统一维护，不用改的时候一个去找
	*	[user_name]
	*	[user_id]
	*/
	function set_session(){
		$_SESSION['user_email'] = $this->user_email;
		$_SESSION['user_id'] = $this->user_id;
	}

	/**
	*	返回SESSION值
	*	@return 二维数组
	*		成功返回：key:[user_email],[user_id]
	*		失败返回 false
	*/
	function get_session(){
		if( $_SESSION['user_email'] && $_SESSION['user_id']){
			$return['user_email'] = $_SESSION['user_email'];
			$return['user_id'] = $_SESSION['user_id'];
			return $return;
		}
		return false;
	}



	/**
	*	检测是否登录
	*	@return 
	*		已登录返回true
	*		未登录返回false
	*/
	function check_login(){
		// print_r($_COOKIE);
		$session = get_session();
		if(!$session){
			if(isset($_COOKIE['user_email'])){
				$this->user_email = $_COOKIE['user_email'];//把COOKIE的帐号传入
				$this->password = $_COOKIE['password'];//把COOKIE的密码传入
				$this->get_user_info();//通过传入的数据查询出信息
				if($this->affect_num){
					$this->login();
					return true;
				}else{
					setcookie('username','',time()-1,"/");
					setcookie('password','',time()-1,"/");
				}
			}
			return false;
		}
		return true;
	}



// 登录
	function login(){
		$this->set_session();//设置session值
		if($this->remember == true){			// 记住一周,COOKI存储
			setcookie('user_email',$this->user_email,time()+3600*24*7,"/");
			setcookie('password',$this->password,time()+3600*24*7,"/");
		}
	}



	
	/**
	*	从数据库获取用户的正确信息
	*	执行存储操作,存储到成员属性  user_id || sql_password || affect_num
	*/
	public function get_user_info(){
		$mysql = M($this->_table);

		$result = $mysql->field(' user_id,password ')->where(" user_email='$this->user_email' ")->find();
		if($result){
			$this->affect_num = 1;		//如果有返回值，设置影响行数，方便后边判断
			$this->user_id = $result["user_id"];
			$this->sql_password = $result["password"];
		}
	}



	/**
	*	验证登录的信息，是否登录成功
	*	@return 二维数组
	*		['result']= bool
	*		['error_info']= 具体信息
	*/
	function do_login(){
		$return=array();
		$this->get_user_info();
		// print_r($_SESSION);	//输出正确验证码
		if(!isset($_SESSION['validate']) || $this->validate != $_SESSION["validate"]){
			$return["result"] = false;
			$return["error_info"] ="验证码输入错误,正确为：".$_SESSION["validate"];
		}elseif(empty($this->user_email) ){
			$return["result"] = false;
			$return["error_info"] = "请输入用户名";
		}elseif($this->password == ""){
			$return["result"] = false;
			$return["error_info"] = "请输入密码";
		}elseif( $this->affect_num == 0){
			// echo $this->affect_num."<br>";
			$return["result"] = false;
			$return["error_info"] = "用户不存在";
		}elseif($this->password != $this->sql_password){
			// echo "<br>输入的密码:".$this->password."<br>";
			// echo "数据的密码:".$this->sql_password."<br>";exit;
			$return["result"] = false;
			$return["error_info"] = "密码错误";
		}else{
			$return ["result"] = true;
			$return["error_info"] ="验证成功";
		}
		return $return;
	}






// 登出
	function loginout(){
		session_unset();
		session_destroy();
		setcookie('user_email',"",time()-1,"/");
		setcookie('password',"",time()-1,"/");
		return true;
	}
}

?>