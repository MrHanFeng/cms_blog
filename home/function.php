<?php 
	session_start();
	define('__ROOT__',dirname(__DIR__));//����·��
	include_once(__ROOT__.'/config.php');//���������ļ�



	/**
	*	����'user_id''username'��SESSIONֵ
	*	@param  
	*	$id :�û���IDֵ
	*	$name:�û���nameֵ
	*	Ŀ�ģ�Ϊ�˺��ں�ά��,�õ�$_SESSION['username'],ͳһ�������
	*/
	function set_user_session($id,$name){
		$_SESSION['username'] = $id;
		$_SESSION['user_id'] = $name;
	}


	/**
	*	��ȡuser��SESSIONֵ
	*	@param
	*	$name:Ҫ��ȡ��SESSION����
	*	@return
	*	���ڣ�������SESSION['username']ֵ
	*	�����ڣ�����false
	*	Ŀ�ģ�Ϊ�˺��ں�ά��,�õ�$_SESSION['username'],ͳһ�������
	*/
	function get_user_session(){
		if(isset($_SESSION['username'] )){
			return $_SESSION["user_id"];
		}
			return false;
	}

	/**
	* 	MD6����
	*	����Ϊ����MD5����
	*	@param:$password
	*	@return:���ܵ�$password
	*/
	function md6($password){
		return md5(md5($password));
	}





	/*------------------------------------------------------------------------------*/
	/*-----------------------------����Ϊ����¼�ǳ�������---------------------------*/
	/*------------------------------------------------------------------------------*/









	/*------------------------------------------------------------------------------*/
	/*-----------------------------����Ϊ����ѯ����������---------------------------*/
	/*------------------------------------------------------------------------------*/
	/**
	*	��ѯ�����(cms_category)����Ϣ
	*	@return
	*	������ID,NAME, ��ά����
	*/
	function get_category_mes(){
		$cate = M('cms_category');
		return $re = $cate->select();
		show($re);
	}

	/**
	*	@return �������±�ͷ�����������Ϣ����ά����
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
	* ����������µ���������
	* @return һά���飬keyΪ����ID��value������������
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
	*	������۱���������ۣ�������ʱ�併������
	*	@return ����һά���� key[cm_id]  value['cm_content']
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
	*	�����ѯ��������۵�������Ϣ�����µ� id name
	* 	@param ��������
	*	@return �ɹ�������ά����  ʧ�ܷ���false
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
	*	������������Ϣ�����µ� id name
	* 	@param ��������
	*	@return ��ά���� 
	*		�ɹ�����[����ID] [����title]
	*		ʧ�ܷ���false
	*/
	function get_rand_ar($limit=5){
		$info = M('cms_article');
		$where=" article_status = '1' ";
		$order=" rand() ";
		$re = $info->order($order)->limit($limit)->where($where)->select();//��ȡ�������µ�ID
		// echo $info->getLastSql();exit;
		if($re){
			return $re;
		}else{
			return false;
		}
	}


	/**
	*	ͳ�����������������ʱ��
	*	@return ����
	*/
	function count_article_num(){
		$info = M('cms_article');
		return $info->count();
	}

	/*
	*	ͳ����������
	*/
	function count_com_num($limit){
		$info = M('cms_comment');
		return $info->limit($limit)->count();
	}


	/**
	*	������������
	*	@return ��������
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
	*	��ȡ������ʱ��
	*	@return ʱ���
	*/
	function get_last_update_time(){
		$info = M("cms_article");
		return $info->max('article_update_time');
	}


	/**
	*	�����������������Ϣ
	*	@return ��ά����
	*		�ɹ����ض�ά����
	*		ʧ�ܷ���false
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
	*	��ú�������������Ϣ
	*	@param ����ID
	*	@return 
	*		�ɹ�����һλ����
	*		ʧ�ܷ���false
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
	*	���ĳƪ�������۵�������Ϣ
	*	@param ����ID
	*	@return 
	*		�ɹ����ض�ά����
	*		ʧ�ܷ���false
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
	/*-----------------------------����Ϊ���������������---------------------------*/
	/*------------------------------------------------------------------------------*/
	
	/**
	*	����ǰ̨��������ۣ�����е�¼������ԱIDһ�����
	*	@param 
	*		$data ǰ̨�����������Ϣ 
	*	@return 
	*	 	�ɹ�true
	*	 	ʧ��false
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
	/*-----------------------------����Ϊ����Ա���ġ�����---------------------------*/
	/*------------------------------------------------------------------------------*/







	/*------------------------------------------------------------------------------*/
	/*---------------------------����Ϊ����ҳ����������-----------------------------*/
	/*------------------------------------------------------------------------------*/
		

		/**
		*	��ҳͨ��ģ�棬���ôκ�������
		*  <--	�˺�����ͨ��ģ�棬�����ӹ��ܣ���ҪԼ��������������ʱ����д����   -->
		*	@param 
		* 		$cur_page ��ǰΪ�ڼ�ҳ
		* 		$per_num ÿҳ����
		*		$table_name ��ѯ�Ǹ���
		*	@return
		*	�ɹ����� ���ӱ����Ϣ, ��ά����
		*		$return['page_html'] :Ϊ�����HTML����
		*		$return['info'] :���ݵ���Ϣ����ά���飬�±�Ϊ�����ID��ֵΪ�������Ķ�Ӧ�ֶΣ�
		*	ʧ�ܷ���false
		*/
		function page($cur_page,$per_num,$table_name){
			$table = M($table_name);
			$total_num = $table->count();//������������
			$page_html = pager($total_num,$cur_page,$per_num);//���ط�ҳHTML����
			$limit = ($cur_page-1)*$per_num	;// ����limit��һ����������,ǰ���Ѿ���ʾ�˶������� 
			$info = $table->limit($limit,$per_num)->select();
			if(empty($info) ){
				return false;
			}
			// ���ݹ�һ
			$return['page_html'] = $page_html;
			$return['info'] = $info;
			return $return;
		}




		/**
		*	���ɷ�ҳ���� ����pager.class.php����
		*	@param 
		*	$total_num 	  ������������
		*	$get_page     ��ǰΪ�ڼ�ҳ,Ĭ�ϵ�һҳ
		*	$per_page_num ÿҳ��ʾ����
		*	@return 
		*	$pageStr  �������ݱ༭�õķ�ҳHTML����
		*/
		function pager($total_num,$CurrentPage,$per_page_num){
			// echo __ROOT__.'/common/pager.class.php';exit;
			include_once(__ROOT__.'/common/pager.class.php');
	/*		�Ѹ�CSS���뵽��Ŀ��CSS/base.css�ļ�
			echo "<style>";
			include_once(__ROOT__.'/common/pager.css');
			echo "</style>";*/
			$myPage=new pager($total_num,intval($CurrentPage),$per_page_num);     //��ҳ������ǰҳ����ÿҳ����
			// ��ò������ҳHTML
			$pageStr= $myPage->GetPagerContent();   	//��÷�ҳ����
			return $pageStr;   							//�����ҳ��HTML����
		}

	
 ?>
