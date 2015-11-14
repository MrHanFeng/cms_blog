<?php
 class ValidateNum{

	private $width;		//图片宽
	private $height;	//图片高
	private $str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	private $str_num=1;		//限制验证码长度
	private $font_size=18;		//验证吗字体大小
	private $diff_level=3;		//干扰的数量
	private $checknum='';		//存放随机数
	private $img;				//存放图片资源
	private static $test1 =10;

	// 主函数调用
	public function main(){
		// $this->set_config("str","123456");		
		$this->createValidateNum();				//生成随机数
		$this->addValidateNum();			//画入图片
		$this->addLine();					//干扰画线
		$this->addPixel();					//干扰画点
		$this->echoPic();					//输出图片
	}

	// 初始化函数
	public function __construct($width,$height,$num){
		$this->width =$width;
		$this->height =$height;
		$this->str_num =$num;
	}

	public function __set($config,$value){
		switch($config){
			case "width":
				$this->width =$value;
			break;
			case "height":
				$this->height =$value;
			break;
			case "str":
				if(strlen($value)>5){
					$this->str =$value;
				}else{
					return false;
				}
			break;
			case "str_num":
				$this->str_num =$value;
			break;
			case "font_size":
				$this->font_size =$value;
			break;
			case "diff_level":
				$this->diff_level =$value;
			break;
		}
	}

//魔术方法，当直接访问私有属性时，调用此方法，有参数
	function __get($a){
		return $this->$a;
	}



	// 生成随即代码
	 protected function createValidateNum(){
	 	// $checknum = $this->checknum;
		for($i = 0; $i <$this->str_num; $i++){
			 $this->checknum .= $this->str[rand(0,strlen($this->str)-1)];
		}
		return $this->checknum;
	}
	//获取验证码
	public function getValidateNum(){
		return strtolower($this->checknum);
	}

	// 绘图函数
	protected function addValidateNum(){

		$this->img = imagecreatetruecolor($this->width,$this->height);
		$bg_color = imagecolorallocate($this->img, rand(100,200),rand(50,150),rand(150,250));
		imagefill($this->img,1,1,$bg_color);					//填充背景色
		$temp_x = ($this->width-20) / $this->str_num ;		//设置每个字符的宽度
		$temp_y = $this->height*3/4;
		for($i = 0;$i < $this->str_num ;$i++){
			$code_color = imagecolorallocate($this->img, 0,0,0);
			imagettftext($this->img, $this->font_size, rand(-30,30), $temp_x * $i + 10, $temp_y, $code_color, "t1.ttf", $this->checknum[$i]);	
		}

	}

	// 加横线干扰
	protected function addLine(){
		$line_color = imagecolorallocate($this->img, rand(100,200),rand(50,150),rand(150,250));
		for($i=0;$i<$this->diff_level;$i++){
			imageline($this->img, 0, rand(0,$this->height), $this->width, rand(0,$this->height), $line_color);
		}
	}

	// 加点干扰
	protected function addPixel(){
		$pixel_color = imagecolorallocate($this->img, 255,255,255);
		for($i = 0;$i<$this->diff_level*10; $i++){
			imagesetpixel($this->img,rand(1,$this->width),rand(1,$this->height),$pixel_color);			// 干扰点	
		}

	}

	// 输出图片函数
	protected function echoPic(){
		header("content-type:image/jpeg");	
		imagejpeg($this->img);
		imagedestroy($this->img);
		
	}

	// 析构函数
	public function __destruct(){

	}


//魔术方法的练习


//当调用不存在的对象的方法时，要有两个参数
	public function __call($method,$arr){
		echo "调用了call函数,您访问的{$method}方法不存在".print_r($arr)."<br>";
	}

//当调用不存在的静态方法时，要有两个参数
	public static function __callstatic($method,$args){		
		echo "调用了callstatic静态方法<br>";				//切记要有返回值
	}

//当直接输出对象的时候
	public function __tostring(){
		return "调用了tostring方法，请不要直接调用对象<br>";			//直接return就会输出里边的值
	}

//当直接想调用函数一样调用对象的时候 ,参数可选
	public function __invoke($a){
		echo "调用了invoke函数，参数值为：".$a."<br>";
	}





 }

// 魔术方法的练习
 	// CheckNum :: test();//当调用不存在的静态方法时   			callstatic

 	// $p1 = new CheckNum(100,30);

 	// echo $p1->say(array(1));//当调用不存在的对象的方法时 	call
 	// echo $p1;		//当直接输出对象的时候					tostring
 	// echo $p1(11);	//当直接想调用函数一样调用对象的时候，  invoke


// 正常的验证码图片生成
 	//$p1 = new ValidateNum(80,30);
  	// $p1 -> width=200;
 	// $p1 ->main();
 	// $p1 ->getValidateNum();
// $p1->createValidateNum();
 	//echo $p1->checknum;			//调用魔术方法__get
 	// echo $p1 ->getValidateNum();//调用自定义方法__get
?>