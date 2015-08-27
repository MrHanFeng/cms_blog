<?php 
	session_start();
	define('PATH_ADMIN',dirname(__DIR__));
	// echo PATH_ADMIN;
	include_once(PATH_ADMIN.'/index.php');
	// echo "test in admin/function.php<br>";

	// 实例化对象快捷函数
	function M($table){
		try{
			$table=new MysqlClass($table);
		}catch(Exception $e){
			$e->getMessage();
			exit();
		}
		return $table;
	}



	/**
	*跳转到指定页面
	*@param
	* $time :跳转等待时间
	* $url:跳转的地址
	* $info：跳转是输出的信息
	*/
	function jump($time,$url,$info="请输入参数",$sta="error"){
		// header("Refresh:{$time};url={$url}");
		// echo "<script>alert('".$info."');</script>";
		include_once('jump.php');
		exit;
	}
	// jump(20,"http://www.baidu.com","百度");

	/**
	* 	MD6加密
	*	本质为两次MD5加密
	*	@param:$password
	*	@return:加密的$password
	*/
	function md6($password){
		return md5(md5($password));
	}







	/**
	 * 用户登录函数
	 * @param 无
	 * @return
	 */
	function login(){

		if(isset($_POST['username']) && isset($_POST['password']) ){
			// echo "<br>111";
			$user_table= M('cms_user');
			$where=array(
					'user_username'=>$_POST['username']
				);
			$user_info=$user_table->where($where)->find();
			// show($user_info);
			// exit;
			if($_SESSION['validate'] != $_POST['validate']){
				jump('2',ADMIN_PATH."log/login.php",'验证码错误','error');
			}
			if(!$user_info){
				jump('2',ADMIN_PATH."log/login.php",'用户名不存在','error');
			}elseif(md5($_POST['password']) == $user_info['user_pass']){
				if(isset($_POST['remember'])){//记住密码功能
					setcookie('username',$_POST['username'],time()+3600*24*7);
					$password = md5($user_info['user_username'].$user_info['user_pass']);
					setcookie('password',$password,time()+3600*24*7);
				}
				$_SESSION['user_id'] = $user_info['user_id'];
				$_SESSION['username'] = $user_info['user_username'];
				jump('2',ADMIN_PATH."index.php",'登陆成功','success');
			}else{
				jump('2',ADMIN_PATH."log/login.php",'密码错误','error');
			}
		}	
	}


	/**
	*检查是否登录
	*若已经登录，继续浏览
	*未登录，跳转到登录页面
	*/
	 function checkLogin(){
	 	// echo  $_SERVER['REQUEST_URI'];exit;
		if(!isset($_SESSION['username'])){
			// echo "<script>alert('session不存在');</script>";
			$result = loginByCookie();
			// echo show($result);
			// exit;
			if(!$result){
				echo "<script>alert('cookie不存在,');</script>";
				header("location:".ADMIN_PATH."/log/login.php");
				exit;
			}
		}
	}

	/**
	 * 根据COOKI判断进行登录
	 * @param
	 * @return
	 * 	没有COOKIE['username']返回false
	 * 	SQL中没有COOKIE['username']返回false
	 * 	账户密码匹配，返回true
	 * 	密码不匹配，返回false
	 */
	function loginByCookie(){
		if(!isset($_COOKIE['username'])){
			echo "无COOKI";
			return false;
		}
		$user_table= M('cms_user');
		$where=array(
				'user_username'=>$_COOKIE['username']
			);
		$user_info=$user_table->where($where)->find();
		// show($user_info);
		// echo "222";
		if(!$user_info){//如果数据库没有COOKI的用户名
			echo "删除COOKIE";
			setcookie('username','',time()-1);
			setcookie('password','',time()-1);
			return false;
		}elseif($_COOKIE['password'] == md5($user_info['user_username'].$user_info['user_pass'])){
			$_SESSION['user_id'] = $user_info['user_id'];
			$_SESSION['username'] = $user_info['user_username'];
			return true;
		}else{//
			return false;
		}
	}

	/**
	* 登出操作
	* 删除服务器端的SESSION
	*/
	function loginout(){
		session_unset($_SESSION['user_id']);
		session_destroy($_SESSION['username']);
		setcookie('username','',time()-1);
		setcookie('password','',time()-1);
	}




	/**
	*查询用户与文章对应关系
	* @param
	* @return 二维数组，里边有两个表的指定参数
	*/
	function search_art_user(){
		  $article = M('cms_article');
		  $join=" cms_user on cms_article.article_user_id = cms_user.user_id";
		  $field = "article_id,article_title,article_status,article_category_id,article_create_time,article_update_time,cms_user.username";
		  $arr = $article->join($join)->field($field)->select();
		  // show($arr);
		  return $arr;
	}


	/**
	* 查询分类(category)与文章(article)对应关系
	* @param 为查询文章的状态，
	*    默认为正常除了删除状态
	* 	 赋值为已删除，查询已删除		
	* @return 二维索引数组，
	*	下标为分类的ID，值为所搜索的对应字段，
	*/
	function search_art_cate($status="全部"){
		  $article = M('cms_article');
		  $join=" cms_category on cms_article.article_category_id = cms_category.cat_id";
		  $field = "article_title,article_status,cms_category.cat_name,cms_category.cat_id";
		  switch ($status) {
		  	case '已发布':
		  		$where = array("article_status"=>"已发布");
		  		break;	

	  		case '未审核':
		  		$where = array("article_status"=>"未审核");
	  		break;

	  		case '审核未通过':
	  			$where = array("article_status"=>"审核未通过");
	  			break;	

		  	case '审核已通过':
		  		$where = array("article_status"=>"审核已通过");
		  		break;	

		  	case '已删除':
		  		$where = array("article_status"=>"已删除");
		  		break;
		  	default:
		  		$where = " 1 = 1";
		  		break;
		  }
		  $cate = $article->join($join)->field($field)->where($where)->select();
		  echo $article->getLastSql();
		  show($cate);
		  //变二维数组为一维数组
		  $cate_arr = array();
		  foreach ($cate as $k => $v) {
		    $cate_arr[$v['cat_id']] = $v;
		  }
		  // show($cate_arr);
		  return $cate_arr;
	}












 ?>