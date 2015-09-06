<?php 
	session_start();
	define('__ROOT__',dirname(__DIR__));//物理路径
	include_once(__ROOT__.'/config.php');//引入配置文件



	/**
	*	设置'user_id''username'的SESSION值
	*	@param  
	*	$id :用户的ID值
	*	$name:用户的name值
	*	目的：为了后期好维护,用到$_SESSION['username'],统一在这里改
	*/
	function set_user_session($id,$name){
		$_SESSION['mg_id'] = $id;
		$_SESSION['mg_name'] = $name;
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
		if(isset($_SESSION['mg_name'] )){
			return $_SESSION["mg_name"];
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



/*------------------------------------------------------------------------------*/
/*-----------------------------以下为【登录登出】操作---------------------------*/
/*------------------------------------------------------------------------------*/
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
			}elseif(md6($_POST['password']) == $user_info['mg_pwd']){
				if(isset($_POST['remember'])){//记住密码功能
					setcookie('username',$_POST['username'],time()+3600*24*7);
					$password = md6($user_info['mg_name'].$user_info['mg_pwd']);
					setcookie('password',$password,time()+3600*24*7);
				}
				set_user_session($user_info['mg_id'],$user_info['mg_name']);//通过了方法，减少了维护成本

				/*执行记录登录时间，登录次数加一操作*/
				$where=" mg_id = $user_info[mg_id] ";
				$data=array("mg_time"=>time(),"mg_num"=>$user_info['mg_num']+1);
				$user_table->data($data)->where($where)->update();
				
				jump('2',ADMIN_PATH."index.php",'登录成功','success');
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
		}elseif($_COOKIE['password'] == md6($user_info['mg_name'].$user_info['mg_pwd'])){
			set_user_session($user_info['mg_id'],$user_info['mg_name']);
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


	/**
	*	检测注册信息
	*	@param $data 一维数组
	*	@return 二维数组
	*		成功$result['bool']=true
	*		失败$result['bool']=false + $result['info']错误信息
	*/
	function check_reg($data){
		$user = M('cms_user');
		$where = array("user_email"=>$data['user_email']);
		$re = $user->where($where)->find();
		$result['bool']= false;
		if($re){
			$result['info']="邮箱已经注册";
			return $result;
		}

		if(strlen($_POST['password']) < 6 || empty($_POST['password']) || empty($_POST['c_password'])){
			$result['info']="请输入大于6位的密码";
		}elseif($_POST['password'] !== $_POST['c_password']){
			$result['info']="密码输入不一致";
		}else{
			$result['info']="注册成功";
			$result['bool']= true;
		}
		return $result;
	}


/*------------------------------------------------------------------------------*/
/*-------------------------------以下为【查询】操作-----------------------------*/
/*------------------------------------------------------------------------------*/

	/**
	* 	查询分类(category)与文章(article)与用户(user)对应关系
	*   @param 为查询文章的状态，
	*    $status 文章状态
	* 	 		默认为查询 1:已审核的文章，0:未审核,-1：已删除，2：审核未通过		
	* 	 $order 排序规则
	*			默认为创建时间降序排序
	*	$cur_page 当前的文章页数 
	* 	$per_num 每页显示条数 默认为10调
	*   @return 三维索引数组，
	*		$return['page_html'] :为分类的HTML代码
	*		$return['info'] :数据的信息，二维数组，下标为分类的ID，值为所搜索的对应字段，
	*	 
	*/
	function search_art_cate_user($cur_page=1,$per_num=10,$order=" article_create_time DESC",$status=1){
		  $article = M('cms_article');
		  $total_num = $article->count();//计算文章总数
		  $page_html = pager($total_num,$cur_page,$per_num);//返回分页HTML代码
		  $limit = ($cur_page-1)*$per_num	;// 设置limit第一个参数参数,前边已经显示了多少数据 

		  $join=" cms_category on cms_article.article_category_id = cms_category.cat_id LEFT JOIN cms_user ON cms_article.article_user_id = cms_user.user_id";
		  // $field = "article_title,article_status,cms_category.cat_name,cms_category.cat_id";
		  switch ($status) {
		  	case '1':
		  		$where = array("article_status"=>"1");
		  		break;	

	  		case '0':
		  		$where = array("article_status"=>"0");
	  		break;

	  		case '2':
	  			$where = array("article_status"=>"2");
	  			break;	

		  	case '-1':
		  		$where = array("article_status"=>"-1");
		  		break;
		  	default:
		  		$where = " article_status != '-1'";
		  		break;
		  }
		  $info = $article->join($join)->where($where)->order($order)->limit($limit,$per_num)->select();

		  $return['page_html'] = $page_html;
		  $return['info'] = $info;
		  // echo $article->getLastSql();
		  // show($return);exit;
		  return $return;
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
	*	查询分类表(cms_category)的信息
	*	@return
	*	分类表的ID,NAME, 二维数组
	*/
	function get_category_mes(){
		$cate = M('cms_category');
		return $re = $cate->select();
		// show($re);
	}

	/* 查询分类表,返回一维数组，特定的分类信息*/
	function get_category($id){
		$cate = M('cms_category');
		$where=" cat_id = $id";
		return $re = $cate->where($where)->find();
		// show($re);
	}


	/**
	*	查询链接表(cms_category)的信息
	*	@param 
	* 		$cur_page 当前为第几页
	* 		$per_num 每页条数
	*	@return
	*	成功返回 链接表的信息, 三维数组
	*		$return['page_html'] :为分类的HTML代码
	*		$return['info'] :数据的信息，二维数组，下标为分类的ID，值为所搜索的对应字段，
	*	失败返回false
	*/
	function get_link_mes($cur_page,$per_num){
		$link = M('cms_link');
		$total_num = $link->count();//计算文章总数
		$page_html = pager($total_num,$cur_page,$per_num);//返回分页HTML代码
		$limit = ($cur_page-1)*$per_num	;// 设置limit第一个参数参数,前边已经显示了多少数据 

		$order=(" link_update_time DESC ");
		$info = $link->order($order)->limit($limit,$per_num)->select();
		
		if(empty($info) ){
			return false;
		}

		// 数据归一
		$return['page_html'] = $page_html;
		$return['info'] = $info;
		return $return;
	}

	/* 查询链接表,返回一维数组，特定的链接信息*/
	function get_link($id){
		$link = M('cms_link');
		$where=" link_id = $id";
		$re = $re = $link->where($where)->find();
		if($re){
			return $re;
		}
		return false;
	}


	/**
	*	查询评论表(cms_comment)的信息
	*	@param $article_id 指定文章的ID
	*	@return 
	*	成功返回 指定文章的评论表的信息, 二维数组
	*	失败返回false
	*/
	function get_comment($id){
		$cm = M('cms_comment');
		$where=" cm_arid = $id";
		$re = $re = $cm->where($where)->select();
		// show($re);
		// echo $cm->getLastSql();
		if($re){
			return $re;
		}
		return false;
	}

	/**
	* 获得所有文章的评论条数
	* @return 一维数组，key为文章ID，value文章评论条数
	*/
	function get_com_num(){
		$cm = M('cms_comment');
		$sql = "select count(*) as com_num,cm_arid from cms_comment GROUP BY cm_arid ";
		$re = $cm->exec($sql);
		$result = "";
		while($a = $re->fetch_assoc()){
			$result[$a['cm_arid']]=$a['com_num'];
		}
		return $result;
	}


	/**
	* 获得所有会员用户的信息
	* @return 二维数组包含所有信息
	*/
	function get_user_mes(){
		$user = M('cms_user');
		return $user->select();
	}

	/* 查询特定会员,返回一维数组 所有信息*/
	function get_user($id){
		$user = M('cms_user');
		$where=" user_id = $id";
		$re = $re = $user->where($where)->find();
		if($re){
			return $re;
		}
		return false;
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
		if($re){
			return $re;
		}
		return false;
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


	/**
	*	插入友情链接信息
	*	@param $data(),数组形式传入要插入的值
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function insert_link($data){
		$data['link_update_time'] = time();
		$link = M('cms_link');
		// show($data);
		// show($_FILES);
		// 加载上传类
		$url = upload('link_img');
		if($url === false){
			return false;
		}
		$data['link_img'] = strstr($url,"upload");


		$re = $link->data($data)->insert();
		// echo $link->getLastSql();exit;
		// show($re);
		if($re){
			return $re;
		}
		return false;
	}

	/**
	*	插入会员用户信息
	*	@param $data(),数组形式传入要插入的用户值
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function insert_user($data){
		$data['user_time'] = time();
		$data['user_last'] = time();
		$data['password'] = md6($data['password']);
		$user = M('cms_user');
		$re = $user->data($data)->insert();
		// echo $link->getLastSql();exit;
		// show($re);
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
	*	注意$mess，因为前台POST提交了一个信息，为字符串格式，小心数据多了变数组
	*/
	function update_cate($id,$data){
		$cate = M('cms_category');
		if(!is_array($data)){
			$mess= $data;
			// $data=settype($data,"array");  
			$data= array();  
			$data['cat_name']=$mess;
			// show($data);exit;
		}
		$where = " cat_id = $id";
		$re = $cate->where($where)->data($data)->update();
		// echo $cate->getLastSql();exit;
		if($re){
			return $re;
		}
		return false;
	}


	/**
	*	修改分类信息
	*	@param $id 哪条分类 $data修改的值[数组形式]
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function update_link($id,$data){
		$link_info = get_link($id);//查询出此友情链接的信息
        //判断有无删除图片操作
        if(@$data['del_pic']){
           unlink(__ROOT__.'/public/'.$link_info['link_img']);
           unset($data['del_pic']);
           $data['link_img'] = " ";
        }
        if(!empty($_FILES['link_img']['name'])){
       		@unlink(__ROOT__."/public/".$link_info['link_img']);//先删除原来文件exit;
       		$url = upload('link_img');//移动文件
			if($url === false){
				return false;
			}
			$data['link_img'] = strstr($url,"upload");//赋新地址值
        }


		$link = M('cms_link');
		$where = " link_id = $id ";

		if(!is_array($data) && $data="up" ){//如果是置顶操作
			$data=array();
			$data['link_update_time']=time();
		}

		$re = $link->where($where)->data($data)->update();
		

		if($re){
			return true;
		}
		return false;
	}


	/**
	*	修改分类信息
	*	@param $id 哪条分类 $data修改的值[数组形式]
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function update_comm($id,$data){
		$link = M('cms_comment');
		$where = " cm_id = $id ";
		$re = $link->where($where)->data($data)->update();
		// echo $link->getLastSql();exit;
		if($re){
			return true;
		}
		return false;
	}


	/**
	*	修改会员信息
	*	@param $id 哪位会员 $data修改的值[数组形式]
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function update_user($id,$data){
		$user = M('cms_user');
		$data['user_last'] = time();
		$data['password'] = md6($data['password'] );
		$where = " user_id = $id ";
		$re = $user->where($where)->data($data)->update();
		// echo $link->getLastSql();exit;
		if($re){
			return true;
		}
		return false;
	}

	/**
	*	修改管理员密码
	*	@param $id 哪位管理员 $data修改的值[数组形式]
	*	@return 成功返回影响行数 ；失败返回false
	*/
	function update_mg_pwd($id,$data){
		$user = M('cms_manager');
		$mess['mg_pwd']=md6($data);
		$where = " mg_id = $id ";
		$re = $user->where($where)->data($mess)->update();
		// echo $link->getLastSql();exit;
		if($re){
			return true;
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
	*	不足，把删除的分类，能改到用户指定分分类，需要前台配合？？？
	*/
	function del_cate($id){
		$cat = M('cms_category');
		$art = M('cms_article');
		$cat ->startTrans();//开启事务

		$cat_where =" cat_id = $id";
		$cat_re = $cat->where($cat_where)->delete();
		// show($cat_re);

		$art_where =" article_category_id = $id";//找到此分类的所有文章
		$art_data['article_category_id'] = "0";//把删除的这类的文章，分到默认0类
		$art_re = $art->where($art_where)->data($art_data)->update();
		// echo $art->getLastSql();
		// show($art_re);

		if($cat_re && $art_re !== false){
			// echo "commit<br>";
			$cat->commit();//成功提交
			return true;
		}

		// echo "rollback<br>";
		$cat ->rollback();//失败回滚
		return false;

		$cat ->endTrans();//关闭事务
	}
	
	/**
	*	删除友情链接信息函数
	*	@param $id 所要删除链接的ID
	*	@return 成功返回影响行数；失败返回false
	*/
	function del_link($id){
		$link = M('cms_link');
		$where =" link_id = $id";
		$re = $link->where($where)->delete();
		if($re){
			return $re;
		}else{
			return false;
		}
	}

	/**
	*	删除会员用户信息函数
	*	@param $id 所要删除会员的ID
	*	@return 成功返回影响行数；失败返回false
	*/
	function del_user($id){
		$user = M('cms_user');
		$where =" user_id = $id";
		$re = $user->where($where)->delete();
		if($re){
			return $re;
		}else{
			return false;
		}
	}



/*------------------------------------------------------------------------------*/
/*---------------------------以下为【文件上传】操作-----------------------------*/
/*------------------------------------------------------------------------------*/
	/**
	*	文件上传函数，把文件保存到指定路径
	*	@param 
	*		$filename:表单里写的文件名称
	*	@return 成功返回图片存储物理路径，失败返回false
	*/
	function upload($filename){
		include_once(__ROOT__.'/common/Upload.class.php');//引入类文件
		$path  = __ROOT__."/public/upload/".date("Y-m-d",time());//定义路径
		$upload = new upload($filename,$path);
		$url  = $upload->uploadFile();//调用成员方法，成功返回保存的物理地址
		if(empty($url)){
			return false;
		}
		return $url;
	}




	/**
	*	获取文件后缀名字
	*	@param $filename:文件的名称【带后缀】
	*	@return 返回后缀名称
	*/
	function fileext($filename){
		return substr(strrchr($filename, '.'),1);
	}


	/**
	*	生成随机名称.
	*	@param 获得随机名字的长度
	*	@return 返回随机生成的名称
	*/
	function random_name($length=15){
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $chars_len = strlen($chars);
        $hash= "";
		for($i=0;$i<$length;$i++){
			$hash .= $chars[mt_rand(0,$chars_len-1)];
		}
		return $hash.date("_H_i_s",time());
	}


	/**
	*	生成并返回上传路径
	*
	*/
	function upload_path(){
		$path = __PUBLIC__."/upload/".date("H-m-d",time());
		mkdir($path);
	}

	/**
	*	上传文件移动函数
	*	@param $filename 文件名称
	*	@return
	*	成功返回true
	*	失败返回false
	*/
	function move_upload_file($filename){
		if(is_uploaded_file($filename)){
			if( move_uploaded_file(random_name(), upload_path()) ){
				return true;
			}
			return false;
		}
	}



/*------------------------------------------------------------------------------*/
/*---------------------------以下为【分页函数】操作-----------------------------*/
/*------------------------------------------------------------------------------*/
	
	/**
	*	分页显示
	*	@param 
	*	$table_name 查询的表格名称
	*	$per 每页要显示的条数
	*	$sql 查询的SQL语句，纯语句
	*	@return 返回三维数组
	*	$arr=("info"=>"查询的全部数据","pagelist"=>"页码的HTML代码")，
	*/
	// function page($table_name,$per,$sql){
	// 	$table = M("$table_name");
	// 	/*1.赋值配置*/
	// 	$total = $table->count();//计算总条数 【TP和自己写的SQL模版，count不知是否效果一样？】


	// 	/*2.实例化分页类*/
	// 	// $page = new \Component\Page($total,$per);//TP框架下用法：实例化分页类，分页类中相应要有命名空间
	// 	include_once(__ROOT__.'common/Page.class.php');//把分页类加载进来，与上边二选一

	// 	$page = new Page($total,$per);

	// 	///* 3.写SQL语句*/
	// 	$sql .= " ".$page->limit;//设置了每页限制

	// 	 /*4.获得页码列表*/

	// 	 // $info = $goods ->query($sql);//TP框架下的查询用法
	// 	$info = $table ->select($sql);//自定义的函数select用法，与上边二选一

	// 	$pagelist = $page->fpage();//获得分页信息

	// 	/*5.返回信息*/
	// 	$arr["info"]=$info;
	// 	$arr["pagelist"]=$pagelist;
	// 	return $arr;
	// }



	/**
	*	分页通用模版，调用次函数即可
	*  <--	此函数简单通用模版，当增加功能，需要约束各种数据条件时，重写即可   -->
	*	@param 
	* 		$cur_page 当前为第几页
	* 		$per_num 每页条数
	*		$table_name 查询那个表
	*	@return
	*	成功返回 链接表的信息, 三维数组
	*		$return['page_html'] :为分类的HTML代码
	*		$return['info'] :数据的信息，二维数组，下标为分类的ID，值为所搜索的对应字段，
	*	失败返回false
	*/
	function page($cur_page,$per_num,$table_name){
		$table = M($table_name);
		$total_num = $table->count();//计算数据总数
		$page_html = pager($total_num,$cur_page,$per_num);//返回分页HTML代码
		$limit = ($cur_page-1)*$per_num	;// 设置limit第一个参数参数,前边已经显示了多少数据 
		$info = $table->limit($limit,$per_num)->select();
		if(empty($info) ){
			return false;
		}
		// 数据归一
		$return['page_html'] = $page_html;
		$return['info'] = $info;
		return $return;
	}




	/**
	*	生成分页代码 ，与pager.class.php合用
	*	@param 
	*	$total_num 	  设置总数据量
	*	$get_page     当前为第几页,默认第一页
	*	$per_page_num 每页显示条数
	*	@return 
	*	$pageStr  根据数据编辑好的分页HTML代码
	*/
	function pager($total_num,$CurrentPage,$per_page_num){
		// echo __ROOT__.'/common/pager.class.php';exit;
		include_once(__ROOT__.'/common/pager.class.php');
/*		把该CSS加入到项目的CSS/base.css文件
		echo "<style>";
		include_once(__ROOT__.'/common/pager.css');
		echo "</style>";*/
		$myPage=new pager($total_num,intval($CurrentPage),$per_page_num);     //总页数，当前页数，每页数量
		// 获得并输出分页HTML
		$pageStr= $myPage->GetPagerContent();   	//获得分页代码
		return $pageStr;   							//输出分页的HTML代码
	}




/*------------------------------------------------------------------------------------------------------*/
/*---------------------------以下为【权限管理】操作-----------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------*/

/**
*	权限管理
*	@param 
*	$id  管理员ID
*	$page 这个页面的名字
*	@return 
*		有这个权限，返回true
*		没有权限，返回false
*/
	function check_auth($id,$page){
		$info = M('cms_manager');
		$role_id = $info->field('mg_role_id')->where("mg_id = $id")->find();
		$info = M('cms_role');
		$role_info = $info->field('role_auth_ac')->where("role_id = $role_id[mg_role_id]")->find();
		if(is_array($role_info['role_auth_ac'])){
			$str = implode(",",$role_info['role_auth_ac']);
		}
		$str = $role_info['role_auth_ac'];
		if(strpos($str,$page)){
			return true;
		}
        jump(2,ADMIN_PATH."index.php","没有权限","error");
	}

/*------------------------------------manager表---------------------------------------------------*/

	/**
	*	查询所有管理员信息
	*	@return 二维数组 成功返回所有管理员信息 失败返回false
	*/
	function get_manager_mes(){
		$mg = M("cms_manager");
		$re = $mg->select();
		if($re){
			return $re;
		}
		return false;
	}

	/**
	*	获取管理员的信息
	*	@param  $id 管理员的ID号
	*	@return 一位数组 该管理员的信息 失败返回false
	*/
	function get_manager($id){
		$where= (" mg_id = $id ");
		$mg = M("cms_manager");
		$re = $mg->where($where)->find();
		if($re){
			return $re;
		}
		return false;
	}


	/**
	*	增加管理员
	*	@param 数组，各种数据
	*	@return 成功返回true 失败返回false
	*/	
	function insert_manager($data){

		$info = M('cms_manager');
		$data['mg_time']=time();
		$data['mg_pwd']=md6($data['mg_pwd']);
		$re = $info->data($data)->insert();
		if($re){
			return $re;
		}
		return false;
	}

	/**
	*	修改管理员信息
	*	@param mg_id post
	*	@return 成功返回treu 失败返回false
	*/
	function update_manager($id,$data){
		$info = M('cms_manager');
		$data['mg_time']=time();
		$data['mg_pwd']=md6($data['mg_pwd']);
		$re = $info->data($data)->where("mg_id = $id")->update();
		if($re){
			return $re;
		}
		return false;
	}

	/**
	*	删除管理员
	*	@param mg_id
	*	@return 成功ture 失败false
	*/
	function del_manager($id){
		$info =M('cms_manager');
		$re = $info->where("mg_id=$id")->delete();
		if($re){
			return true;
		}
		return false;
	}


/*-----------------------------------------role表---------------------------------------------*/


	/**
	*	查询所有角色信息
	*	@return 二维数组，
	*		成功：返回所有角色信息
	*		失败：返回false
	*/	
	function get_role(){
		$info = M('cms_role');
		$re = $info->select();
		if($re){
			return $re;
		}
		return false;
	}
	/**
	*	返回特定角色信息
	*	@param $id role_id
	*	@return 一维数组，成功返回该角色权限ID，失败返回false
	*/
	function find_role($id){
		$info=M('cms_role');
		$re = $info->where("role_id=$id")->field('role_auth_ids')->find();
		$ids = explode(",",$re['role_auth_ids']);
		if($ids){
			return $ids;
		}
		return false;
	}

	/**
	*	添加角色
	*	@param $role_name
	*	@return 成功返回true 失败返回false
	*/
	function add_role($role_name){
		$info =M('cms_role');
		$data['role_name']=$role_name;
		$re = $info->data($data)->insert();
		if($re){
			return $re;
		}
		return false;
	}

	/**
	*	修改角色权限
	*	@param
	*		$role_id
	*		$arr_auth_id 为权限ID，一维数组形式
	*	@return
	*		成功 true
	*		失败 false
	*/
	function update_role($role_id,$arr_auth_id){
		$info = M('cms_role');

		/*分别获取每个auth_id对应的文件名字，便于后边限制权限*/
		$auth_a="";
		$auth = M('cms_auth');
		foreach ($arr_auth_id as  $value) {
			$re = $auth->where("auth_id = $value")->field("auth_a")->find();
			if(!empty($re['auth_a'])){
			  $auth_a .="$re[auth_a],";
			}
		}
		$auth_a =substr($auth_a, 0,-1);//以,为分割，存储页面名字

		$ids=implode(',', $arr_auth_id);//以,为分割，存储权限ID

		$data=array(
				"role_auth_ids"=>$ids,
				"role_auth_ac"=>$auth_a
			);
		$re = $info->data($data)->where("role_id=$role_id")->update();
		if($re){
			return true;
		}
		return false;

	}


	/**
	*	删除角色
	*	@param $id role_id
	*	@return
	*		成功返回true
	*		失败返回false
	*/
	function del_role($id){
		$info=M('cms_role');
		$re= $info->where("role_id=$id")->delete();
		if($re){
			return true;
		}
		return false;
	}

/*------------------------------------auth表--------------------------------------------------*/

	/**
	*	获取全部权限
	*	@return 二维数组
	*		
	*/
	function get_auth(){
		$info = M('cms_auth');

		$parent =$info ->where('auth_level=0')->select();
		$child =$info ->where('auth_level=1')->select();
		$re['parent']=$parent;
		$re['child']=$child;
		if($re){
			return $re;
		}
		return false;
	}




	/**
	*	添加权限
	*
	*/	
	function add_auth(){

	}
	function update_auth(){

	}





/*----------------------------------------------------------------------------------------------*/


/*------------------------------------------------------------------------------*/
/*------------------------------------END---------------------------------------*/
/*------------------------------------------------------------------------------*/

 ?>