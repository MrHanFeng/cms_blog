<?php
	session_start();
	include('ValidateNum.class.php');
	$validatenum = new ValidateNum(95,28,4);
	$validatenum->main();
	// echo $checkNum->getValidateNum();
	$_SESSION['validate'] = $validatenum->getValidateNum();//写入session

?>