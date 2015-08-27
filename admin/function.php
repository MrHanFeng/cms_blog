<?php 
	session_start();
	define('PATH_ADMIN',dirname(__DIR__));
	include_once(PATH_ADMIN.'/index.php');

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
	*	设置'user_id''username'的SESSION值
	*	@param  
	*	$id :用户的ID值
	*	$name:用户的name值
	*	目的：为了后期好维护,用到$_SESSION['username'],统一在这里改
	*/
	function set_user_session($id,$name){
		$_SESSION['user_id'] = $id;
		$_SESSION['username'] = $name;
	}


	/**
	*	获取user的SESSION值
	*	@param
	*	$name:要获取的SESSION名字
	*	@return
	*	存在，返回其SESSION['username']值
	*	不存在，返回false
	*	目的：为了后期好维护,用到$_SESSION['username'],统一在这里改
	*/
	function get_user_session(){
		if(isset($_SESSION['username'] )){
			return $_SESSION["username"];
		}
			return false;
	}


	/**
	*	跳转到指定页面
	*	@param
	* 	$time :跳转等待时间
	* 	$url:跳转的地址
	* 	$info：跳转是输出的信息
	* 	$sta 默认为
	*		error 失败
	*		success 成功
	*/
	function jump($time=2,$url,$info="请输入参数",$sta="error"){
		// header("Refresh:{$time};url={$url}");
		// echo "<script>alert('".$info."');</script>";
		include_once('jump.php');
		exit;
	}


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
	 * 判断验证码，用户名，用户密码
	 * @param 无
	 * @return
	 */
	function login(){

		if(isset($_POST['username']) && isset($_POST['password']) ){
			// echo "<br>111";
			$user_table= M('cms_manager');
			$where=array(
					'mg_name'=>$_POST['username']
				);
			$user_info=$user_table->where($where)->find();
			// show($user_info);
			// exit;
			if($_SESSION['validate'] != $_POST['validate']){
				jump('2',ADMIN_PATH."log/login.php",'验证码错误','error');
			}
			if(!$user_info){
				jump('2',ADMIN_PATH."log/login.php",'用户名不存在','error');
			}elseif(md5($_POST['password']) == $user_info['mg_pwd']){
				if(isset($_POST['remember'])){//记住密码功能
					setcookie('username',$_POST['username'],time()+3600*24*7);
					$password = md5($user_info['mg_name'].$user_info['mg_pwd']);
					setcookie('password',$password,time()+3600*24*7);
				}
				set_user_session($user_info['mg_id'],$user_info['mg_name']);//通过了方法，减少了维护成本
				jump('2',ADMIN_PATH."index.php",'登陆成功','success');
			}else{
				jump('2',ADMIN_PATH."log/login.php",'密码错误','error');
			}
		}	
	}


	/**
	*	检查是否登录
	*	若已经登录，继续浏览
	*	未登录，跳转到登录页面
	*/
	 function checkLogin(){
	 	$session_username = get_user_session();
		if(!$session_username){
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
	 * 	根据COOKI判断进行登录
	 *  @param
	 *  @return
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
		$user_table= M('cms_manager');
		$where=array(
				'mg_name'=>$_COOKIE['username']
			);
		$user_info=$user_table->where($where)->find();
		// show($user_info);
		// echo "222";
		if(!$user_info){//如果数据库没有COOKI的用户名
			echo "删除COOKIE";
			setcookie('username','',time()-1);
			setcookie('password','',time()-1);
			return false;
		}elseif($_COOKIE['password'] == md5($user_info['mg_name'].$user_info['mg_pwd'])){
			$_SESSION['user_id'] = $user_info['mg_id'];
			$_SESSION['username'] = $user_info['mg_name'];
			return true;
		}else{//
			return false;
		}
	}

	/**
	*	 登出操作
	* 	 删除服务器端的SESSION
	*/
	function loginout(){
		session_unset();
		session_destroy();
		setcookie('username','',time()-1);
		setcookie('password','',time()-1);
	}





/*------------------------------------------------------------------------------*/
/*-------------------------------以下为【查询】操作-----------------------------*/
/*------------------------------------------------------------------------------*/

	/**
	*	查询分类表(cms_category)的信息
	*	@return
	*	分类表的ID,NAME, 二维数组
	*/
	function get_category_mes(){
		$cate = M('cms_category');
		return $re = $cate->select();
		// show($re);
	}
	/*返回一维数组，特定的分类信息*/
	function get_category($id){
		$cate = M('cms_category');
		$where=" cat_id = $id";
		return $re = $cate->where($where)->find();
		// show($re);
	}


	/**
	*	查询文章表(article)中指定文章的信息
	*	@param $id :文章的ID
	*	@return 一维数组，文章的所有信息
	*/
	function get_article($id){
		$art = M("cms_article");
		$where=" article_id=$id ";
		return $re = $art->where($where)->find();
		// echo $art->getLastSql();
		// show($re);
	}


	/**
	* 	查询分类(category)与文章(article)与用户(user)对应关系
	*   @param 为查询文章的状态，
	*    默认为正常除了删除状态
	* 	 赋值为已删除，查询已删除		
	*   @return 二维索引数组，
	*	 下标为分类的ID，值为所搜索的对应字段，
	*/
	function search_art_cate_user($status="全部"){
		  $article = M('cms_article');
		  $join=" cms_category on cms_article.article_category_id = cms_category.cat_id LEFT JOIN cms_user ON cms_article.article_user_id = cms_user.user_id";
		  // $field = "article_title,article_status,cms_category.cat_name,cms_category.cat_id";
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
		  		$where = " article_status != '已删除'";
		  		break;
		  }
		  $cate = $article->join($join)->where($where)->select();
		  // echo $article->getLastSql();
		  // show($cate);
		  return $cate;
	}



/*------------------------------------------------------------------------------*/
/*-------------------------------以下为【插入】操作-----------------------------*/
/*------------------------------------------------------------------------------*/

	/**
	*	插入文章信息
	*	@return
	*	成功返回插入行数
	*	失败返回false
	*/
	function insert_article($mess){
		$mess['article_create_time'] = time();
		$mess['article_update_time'] = time();
		$art = M('cms_article');
		// show($mess);
		$re =  $art->data($mess)->insert();
		// echo $art->getLastSql();
		// show($re);
		return $re;
	}


	/**
	*	插入分类信息
	*	@param $data 分类信息的名称，必须为数组
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function insert_cate($data){
		$cate = M('cms_category');
		$re = $cate->data($data)->insert();
		if($re){
			return $re;
		}
		return false;
	}



/*------------------------------------------------------------------------------*/
/*-------------------------------以下为【更新】操作-----------------------------*/
/*------------------------------------------------------------------------------*/

	/**
	* 	修改文章的信息
	* 	@param
	*	$id,所修改文章的ID
	*	$data 修改文章的数据，数组形式传入
	* 	@return
	*	成功返回受影响行数
	*	失败返回false
	*/
	function update_article($id,$data){
		  $article = M('cms_article');
		  $data['article_update_time']=time();
		  $where=" article_id = {$id}";
		  $re = $article->data($data)->where($where)->update();
		  // echo $article->getLastSql();exit;
		  return $re;
	}

	/**
	*	修改分类信息
	*	@param $id 哪条分类 $data修改的值[数组形式]
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function update_cate($id,$mess){
		$cate = M('cms_category');
		if(!is_array($mess)){
			$data['cat_name']=$mess;
		}
		$where = " cat_id = $id";
		$re = $cate->where($where)->data($data)->update();
		// echo $cate->getLastSql();
		if($re){
			return $re;
		}
		return false;
	}


/*------------------------------------------------------------------------------*/
/*-------------------------------以下为【删除】操作-----------------------------*/
/*------------------------------------------------------------------------------*/

	/**
	*	删除分类信息函数
	*	@param $id 所要删除分类的ID
	*	@return 成功返回影响行数；失败返回false
	*/
	function del_cate($id){
		$cat = M('cms_category');
		$where =" cat_id = $id";
		$re = $cat->where($where)->delete();
		if($re){
			return $re;
		}else{
			return false;
		}

	}
	


 ?>