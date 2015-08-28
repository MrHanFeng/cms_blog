<?php 
	include_once __DIR__."/config.php";


	Class Mysqlclass{

		static $mysqli;				//存储mysqli对象
		private $_table;			//当前的表名
		private $field="*";			//查询字段
		private $where;				//where条件
		private $sql;				//执行的语句
		private $error_info;		//用于存储错误信息
		private $group;				//分组条件
		private $order;				//排序条件
		private $limit;				//limit条件
		private $join;				//join条件
		private $data;				//insert或update是数据内容
		private $error=array(		//错误库,把所有的错误类型，放在这里
				'E01'=>'没有数据项',
				'E02'=>'没有设置where条件',
			);


		/**
  		 * @param $table
		 * $table 表名
		 *
		 */
		function __construct($table){
			// 首次实力化mysqli对象
			if(!self::$mysqli){//如果没有实力化过这个对象
				self::$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
				if(mysqli_connect_errno()){
					throw new Exception(mysqli_connect_errno());
				}
				self::$mysqli->set_charset('utf8');
			}
			$this->_table=$table;
		}

		/**
		 * 设置查询要返回的字段值
		 * @param $field
		 * $field 字段
		 * 可以是数组，也可以是字符串
		 * @return $this
		 */
        function field($field){
			if(is_array($field)){
				$sql=implode(',',$field);// $field=array('name','sid');
			}else if(is_string($field)){
				$sql=$field;// $field='name,sid';
			}
			$this->field=$sql;
			return $this;
		}

		/**
		 * 设置表连接的条件
		 * @param $join
		 * $join 连接条件
		 * 只能是字符串
		 * 示例：t2 on t2.id=id
		 * @param string $type （可选）
		 * $type 连接类型
		 * 参考值：left inner right
		 * @return $this
		 */
		function join($join,$type="left"){
			 $this->join = " {$type} join {$join}";// $join=('s on s.id=t.sid');
			return $this;
		}

		/**
		 *	设置查询语句中的where条件
		 *	@param $where
		 *  	
		 *	@return $this	
		 *
		*/
		function where($where){
			if(is_string($where)){
				$sql = "where {$where}";//$where="id>1"
			}elseif(is_array($where)){
				$sql = " where ";
				foreach ($where as $k => $v) {
					if(is_array($v)){//如果数组的第一个元素还是数组，即参数为二维数组
						switch ($v[0]) {
							case '>':
							case '<':
							case '>=':
							case '<=':
							case '!=':
							case '=':
								$sql .=" {$k}{$v[0]}'{$v[1]}' and";// $where=array('id'=>array(">",1));
								break;
							case "is":
							case "is not":
								$sql .=" {$k} {$v[0]} null and";//$where=array('name'=>array('is',"tom"));
								break;
							case "between":
								if(is_array($v[1])){
									$sql .="{$k} between {$v[1][0]} and {$v[1][1]} and";//$where = array('id'=>array('between',array(4,6))) 三维数组
								}elseif(is_numeric($v[1]) && is_numeric($v[2])){
									$sql .="{$k} between {$v[1]} and {$v[2]} and";//$where = array('id'=>array('between',4,6)) 二维数组
								}
								break;
							case "like":
							case "not like":
								$sql .="{$k} {$v[0]} '{$v[1]}' and";// $where =array('name'=>array('not like','tom'));
								break;
							case "in":
							case "not in":
								if(is_array($v[1])){
									$sql .=" {$k} {$v[0]} ('".implode("','", $v[1])."') and";// $where =array('name'=>array('in',array('tom','jam','dim')));
								}elseif(is_string($v[1]))
									$sql .="{$k} {$v[0]} ({$v[1]}) and";  // $where =array('name'=>array('in','"tom","jam"'));

						}
					}elseif(is_string($v)){//$where=array("id"=>"1")
						$sql .=" {$k}='{$v}' and";
					}
				}
				$sql = substr($sql,0,-4);
			}
			$this->where = $sql;
			return $this;
		}
	
		/**
		 *设置查询语句中的group条件
		 * @param $group
		 * $group 分组条件
		 * 可以是字符串，也可以是数组
		 * 字符串示例: id,name
		 * 数组示例: array('id','name')
		 * @return $this
		 */
		function group($group){
			$sql = " group by ";
			if(is_array($group)){
				$sql .=implode(',',$group);//$group=array('id','name');
			}elseif(is_string($group)){
				$sql .=$group;//$group='name,sid';
			}
			$this->group = $sql;
			return $this;
		}

		/**
		 * 设置查询语句中的order条件
		 * @param $order
		 * $order 排序条件
		 * 可以是字符串，也可以是数组
		 * 字符串示例: id DESC,name
		 * 数组示例: array('id'=>"DESC",'name'=>"ASC")
		 * @return $this
		 */
		function order($order){
			$sql = "order by ";
			$order_arr=array('ASC','DESC');
			if(is_string($order)){
				$sql .= $order;// $order=('id DESC');
			}elseif(is_array($order)){
				foreach ($order as $k => $v) {
					$v=strtoupper($v);
					if(in_array($v,$order_arr)){
						$sql .= "{$k} {$v},";// $order=(array('id'=>'DESC','name'=>'asc'));
					}
				}
				// echo $sql = substr($sql,0,-1);
				// echo $sql = substr($sql,0,strlen($sql)-1);
				$sql = substr_replace($sql, "", -1);
			}
			$this->order = $sql;
			return $this;
		}

		/**
		 * 设置查询语句中的limit条件
		 * @param $start
		 * $start 开始位置
		 * 只能是整型
		 * 整型示例:3
		 * @param int $length （可选）
		 * $length 数据条数
		 * 只能整型
		 * @return $this
		 */
		function limit($limit,$length=0){
			if(!$length){
				$sql = "limit {$limit}";// $limit=(2);
			}else{
				$sql = "limit {$limit},{$length}";// $limit=('1,2');
			}
			$this->order = $sql;
			return $this;
		}

		/**
		 * 设置insert update时的数据内容
		 * @param $data
		 * 只能是数组
		 * 数组示例：array('id'=>'','name'=>'test')
		 * @return $this
		 */
		function data($data){
		    $this->data=$data;
		    return $this;
		}

// --------------------------------------------------------------------------------
// 上面为SQL的条件
// --------------------------------------------------------------------------------

		/**
		 * 	执行查询单条结果操作
		 * @return array|bool|null
		 * 当有结果时返回一维数组
		 * 查询失败返回 false
		 * 没有结果返回 null
		 * 需要使用===false判断是否执行成功
		 */
		function find(){
			$sql = "select {$this->field} from {$this->_table} {$this->join} {$this->where} {$this->group} {$this->order} limit 1";
			$this->sql = $sql;
			return $this->query_one($sql);

		}

		/**
		 * 执行查询多条结果操作
		 * @return array|bool|null
		 * 当有结果时返回二维数组
		 * 查询失败返回 false
		 * 没有结果返回 null
		 * 需要使用===false判断是否执行成功
		 */
		function select(){
			$sql = "select {$this->field} from {$this->_table} {$this->join} {$this->where} {$this->group} {$this->order} {$this->limit}";
			$this->sql = $sql;
			return $this->query($sql);
		}

		/**
		 *	@return 
		 *	执行成功返回受影响行数
		 *	执行失败返回bool值 false
		*/
		function delete(){
			$sql = "delete from {$this->_table} {$this->where}";
			$re = self::$mysqli -> query($sql);
			$this->sql = $sql;//把SQL语句赋值，方便调用查看
			if($re){
				return self::$mysqli->affected_rows;
			}else{
				return false;
			}
		}

        /**
         * 执行插入操作
         * @return bool|mixed
         * 执行失败返回false
         * 执行成功返回insert_id(自增长id)
         */
        function insert(){
			$insert_sql=$this->createInsertData();
			if(!$insert_sql){
				return false;
			}
			$sql="insert into {$this->_table} {$insert_sql}";
			$result=$this->exec($sql);
			if($result){
				return self::$mysqli->insert_id;
			}
			return false;	
		}

        /**
         * 执行更新操作
         * @return bool|int
         * 执行失败返回false
         * 执行成功返回受影响的行数
         */
        function update(){
			$update_sql=$this->createUpdateData();
			if(!$update_sql){
				return false;
			}
			if(!$this->where){//防止出现数据库事故
				$this->setError('E02',$this->error['E02']);
				return false;
			}
			 $sql="update {$this->_table} set {$update_sql} {$this->where}";
			$result=$this->exec($sql);
			if($result){
				return self::$mysqli->affected_rows;
			}
			return false;			
		}

		/**
		 * 执行统计总数操作
		 * @return bool|int
		 * 查询失败返回 false
		 * 查询成功返回一个整型数字
		 */
		function count(){
			$sql = "select count(*) as hf_sum from {$this->_table}{$this->join}{$this->where}{$this->group}{$this->order} limit 1";
			$result=$this->query_one($sql);
			if($result){
				return (int)$result['hf_sum'];
				// return $result;
			}else{
				return false;
			}
		}

// --------------------------------------------------------------------------------
// 上面为SQL的具体操作
// --------------------------------------------------------------------------------

		/**
		 * 执行查询单条结果的sql语句 select单条
		 * @param $sql
		 * $sql 查询语句
		 * 只能是字符串
		 * @return array|bool|null
		 * 当有结果时返回一维数组
		 * 查询失败返回 false
		 * 没有结果返回 null
		 * 需要使用===false判断是否执行成功
		 */
		function query_one($sql){
			$re = self::$mysqli->query($sql);
			$this->sql = $sql;
			$this->clearParam();//清空属性的条件值
			if($re ===false){
				$this->setError();//?????????????????????????????????????????????
				return false;
			}elseif ($re->num_rows == 0) {
				$re->num_rows;
				return null;
			}else{
				return $re->fetch_assoc();//返回一位数组
			}
		}

        /**
         * 执行查询多条结果的sql语句 select
         * @param $sql
         * $sql 查询语句
         * 只能是字符串
         * @return array|bool|null
         * 当有结果时返回二维数组
         * 查询失败返回 false
         * 没有结果返回 null
         * 需要使用===false判断是否执行成功
         */
		function query($sql){
			$re = self::$mysqli->query($sql);
			// print_r($re);
			$this->sql = $sql;
			$this->clearParam();//清空属性的条件值
			if($re === false){
				$this->setError();//?????????????????????????????????????????????
				return false;
			}elseif ($re->num_rows == 0) {
				return null;
			}else{
				$list=array();
				while($r = $re->fetch_assoc()){
					$list[]=$r;
				}
				return $list ;//返回二维数组
			}
		}

		/**
          * 执行查询操作语句的sql,insert,update用到
          * 《--也可以对外开放，做一些直接输入SQL语句，在调用检测影响函数，即，有这个函数，支持最原始的SQL查询--》
          * @param $sql
          * $sql 查询语句
          * 只能是字符串
          * 字符串示例:delete from t where id = 1
          * @return bool
          * 查询失败返回 false
          * 没有结果返回 true
          *
         */
		function exec($sql){
			$result=self::$mysqli->query($sql);
            $this->sql=$sql;
			$this->clearParam();
			if(!$result){
				$this->setError();
			}
			return $result;			
		}

        /**
         * 将data方法所存储的数组转成insert语句
         * @return bool|string
         * 如果data属性不是数组则返回  false
         * 如果data属性是数组则返回转换的结果
         * 所以说，按照一位数组插入单条数据，二维数组插入多条数据为准则
         *    
         *    一维
         * array(
         *	 'id'=>0,
         *	 'name'=>'test',
         * )
         *
         *	二维
         * array(
		 *	0=>array('id'=>'';'name'=>'aa'),
		 *	1=>array('id'=>'';'name'=>'aa'),
		 *	2=>'1111',//要被过滤掉
		 *	3=>array('id'=>'';'name'=>'aa'),
         *)
         */
        function createInsertData(){
			if(is_array($this->data)){//在data()中已经存入了数据
				$first_array=current($this->data);//把data[0]的值赋给它，判断它是不是数组				
				if(is_array($first_array)){//如果它为二维数组
					$insert_sql='('.implode(',',array_keys($first_array)).') values ';
					foreach($this->data as $row){
						if(is_array($row)){//过滤第二维的不是数组的元素，如上边例子
							echo  $insert_sql .="('".implode("','",array_values($row))."'),";
						}
					}
					return substr($insert_sql,0,-1);//去除最后的逗号
				}else{//当前数组是一维数组，直接剥键名，键值组成SQL语句
					$insert_sql='('.implode(',',array_keys($this->data)).') values ';
					$insert_sql.="('".implode("','",array_values($this->data))."')";
					return $insert_sql;
				}
			}else{//必须是数组，否则报错
				$this->setError('E01',$this->error['E01']);
				return false;
			}
		}


        /**
         * 执行更新操作
         * 将data方法所存储的数组转成update语句
         * @return bool|string
         * 如果data属性不是数组则返回  false
         * 如果data属性是数组则返回转换的结果
         */
        function createUpdateData(){
			if(is_array($this->data)){
				$update_sql="";
				foreach($this->data as $key=>$row){
					 $update_sql.="{$key}='{$row}',";			
				}
				return substr($update_sql,0,-1);
			}else{
				$this->setError('E01',$this->error['E01']);
				return false;
			}
		}

        /**
         * 设置错误编号
         * @param $errno
         * $errno 错误编号
         * 字符串示例： E01
         * @param string $error
         * $error 错误提示
         * 字符串示例: 没有数据
         * 如果设置参数则优先使用参数，如果未提供则使用系统错误信息
         */
		function setError($errno=0,$error=''){
			if(self::$mysqli->errno && $errno==0){//指系统的错误，放在前边优先级高
				$this->error_info['errno']=self::$mysqli->errno;//返回错误信息代码。
				$this->error_info['error']=self::$mysqli->error;//返回上一个 MySQL 操作产生的文本错误信息 
			}elseif($errno>0){//人工设置的错误
				$this->error_info['errno']=$errno;
				$this->error_info['error']=$error;
			}
		}

        /**
         * 获取上一次错误信息
         * @return mixed
         * 返回上一次错误信息
         * 返回内容为数组 包含 errno error
         * 返回示例 array('errno'=>'E01','error'=>"没有数据")
         */
        function getError(){
			return $this->error_info;
		}

		// 经过语句的调用，清空属性的值
		function clearParam(){
			$this->field="*";
			$this->where="";
			$this->group="";
			$this->order="";
			$this->limit="";
			$this->join="";
			$this->data="";
		}

		// 获取当前的SQL代码因为上边每一个操作函数都或把SQL存入$sql
		function getLastSql(){
		 	return $this->sql;
		}

// --------------------------------------------------------------------------------
// 上面为SQL的的辅助函数
// --------------------------------------------------------------------------------
		
        /**
         * 开启事务
         * @return bool
         */
        function startTrans(){
			$sql="start transaction";
			return $this->exec($sql);
		}


        /**
         * 提交事务
         * @return bool
         */
        function commit(){
			return self::$mysqli->commit();
		}

        /**
         * 回滚事务
         * @return bool
         */
        function rollback(){
			return self::$mysqli->rollback();
		}

// --------------------------------------------------------------------------------
// 上面为SQL的事务操作
// --------------------------------------------------------------------------------


	}
 ?>