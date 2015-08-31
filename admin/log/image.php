<?php
	session_start();
	$path = dirname(dirname(__DIR__));//获取gen路径
	include($path.'/common/ValidateNum.class.php');
	$validatenum = new ValidateNum(95,28,1);
	$validatenum->main();
	// echo $checkNum->getValidateNum();
	$_SESSION['validate'] = $validatenum->getValidateNum();//写入session

?>