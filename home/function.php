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
		$_SESSION['username'] = $id;
		$_SESSION['user_id'] = $name;
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
			return $_SESSION["user_id"];
		}
			return false;
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









	/*------------------------------------------------------------------------------*/
	/*-----------------------------以下为【查询操作】操作---------------------------*/
	/*------------------------------------------------------------------------------*/
	/**
	*	查询分类表(cms_category)的信息
	*	@return
	*	分类表的ID,NAME, 二维数组
	*/
	function get_category_mes(){
		$cate = M('cms_category');
		return $re = $cate->select();
		show($re);
	}

	/**
	*	@return 返回文章表和分类表的所有信息，二维数组
	*/
	function get_article_cate($cur_page,$per_num,$cate_id,$search_name=0){
		$info = M('cms_article');
		if($cate_id< 0){
			$where = " article_status = '1' and article_category_id != '$cate_id' ";
		}else{
			$where = " article_status = '1' and article_category_id ='$cate_id' ";
		}

		if($search_name){
			$where .=" and article_title like '%$search_name%'";
		}

		$total_num = $info->where($where)->count();
		// echo $info->getLastSql();exit;
		$page_html = pager($total_num,$cur_page,$per_num);
		$limit = ($cur_page-1)*$per_num;

		$order=" article_read_num  DESC";
		$join = " cms_category on cms_article.article_category_id = cms_category.cat_id ";
		$re =  $info ->join($join)->where($where)->order($order)->limit($limit,$per_num)->select();
		// echo $info->getLastSql();exit;
		if(empty($re) ){
			return false;
		}

		$return['page_html']=$page_html;
		$return['info']=$re;
		return $return;

	

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
	*	获得评论表的所有评论，按发布时间降序排列
	*	@return 返回一维数组 key[cm_id]  value['cm_content']
	*/
	function get_com(){
		$cm = M('cms_comment');
		$re = $cm->select();
		$arr = array();
		foreach ($re as $key => $value) {
			$arr[$value['cm_id']] = $value['cm_content'];
		}
		return $arr;
	}

	/**
	*	联表查询，获得评论的所有信息，文章的 id name
	* 	@param 限制条数
	*	@return 成功返回三维数组  失败返回false
	*/
	function get_cm_art_user($limit=1){
		$info = M('cms_comment');
		$order = " cm_time DESC ";
		$join = " cms_article ar on cms_comment.cm_arid =ar.article_id 
					left join cms_user user on cms_comment.cm_user_id = user.user_id";
		$re = $info ->limit($limit)->order($order)->join($join)->select();
		// echo $info->getLastSql(); exit;
		return $re;
	}


	/**
	*	随机获得文章信息，文章的 id name
	* 	@param 限制条数
	*	@return 二维数组 
	*		成功返回[文章ID] [文章title]
	*		失败返回false
	*/
	function get_rand_ar($limit=5){
		$info = M('cms_article');
		$where=" article_status = '1' ";
		$order=" rand() ";
		$re = $info->order($order)->limit($limit)->where($where)->select();//获取所有文章的ID
		// echo $info->getLastSql();exit;
		if($re){
			return $re;
		}else{
			return false;
		}
	}


	/**
	*	统计文章数量，与更新时间
	*	@return 数量
	*/
	function count_article_num(){
		$info = M('cms_article');
		return $info->count();
	}

	/*
	*	统计评论数量
	*/
	function count_com_num($limit){
		$info = M('cms_comment');
		return $info->limit($limit)->count();
	}


	/**
	*	计算运行天数
	*	@return 运行天数
	*/
	function count_run_time(){
		$run_d = floor( (time()-CREATE_TIME)/(60*60*24) );
		$run_y = floor($run_d/365);
		$run_d -= $run_y*365;
		$run_m = floor($run_d/30);
		$run_d -= $run_m*30;

		$time['year']=$run_y;
		$time['month']=$run_m;
		$time['day']=$run_d;
		return $time;
	}


	/**
	*	获取最后更新时间
	*	@return 时间戳
	*/
	function get_last_update_time(){
		$info = M("cms_article");
		return $info->max('article_update_time');
	}


	/**
	*	获得所有友情链接信息
	*	@return 二维数组
	*		成功返回二维数组
	*		失败返回false
	*
	*/
	function get_link_info(){
		$link = M('cms_link');
		$order=(" link_update_time DESC ");
		$re = $link->order($order)->select();
		if($re ){
			return $re;
		}
		return false;
	}


	/**
	*	获得后面文章所有信息
	*	@param 文章ID
	*	@return 
	*		成功返回一位数组
	*		失败返回false
	*/
	function get_article($id){
		$info = M('cms_article');
		$where = " article_id = $id";
		$re = $info->where($where)->find();
		// show($re);exit;
		if($re){
			return $re;
		}
		return false;
	}


	/**
	*	获得某篇文章评论的所有信息
	*	@param 文章ID
	*	@return 
	*		成功返回二维数组
	*		失败返回false
	*/
	function get_comment($id){
		$info = M('cms_comment');
		$where = " cm_arid = $id";
		$re = $info->where($where)->select();
		// show($re);exit;
		if($re){
			return $re;
		}
		return false;
	}

	/*------------------------------------------------------------------------------*/
	/*-----------------------------以下为【插入操作】操作---------------------------*/
	/*------------------------------------------------------------------------------*/
	
	/**
	*	插入前台输入的评论，如果有登录，连会员ID一起插入
	*	@param 
	*		$data 前台传入的评论信息 
	*	@return 
	*	 	成功true
	*	 	失败false
	*/
	function insert_comment($data){
		$info =M('cms_comment');
		$data['cm_time']=time();
		// show($data);exit;
		$re = $info->data($data)->insert();
		// echo $info->getLastSql();exit;
		if($re){
			return true;
		}
		return false;
	}




	/*------------------------------------------------------------------------------*/
	/*-----------------------------以下为【会员中心】操作---------------------------*/
	/*------------------------------------------------------------------------------*/







	/*------------------------------------------------------------------------------*/
	/*---------------------------以下为【分页函数】操作-----------------------------*/
	/*------------------------------------------------------------------------------*/
		

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

	
 ?>
