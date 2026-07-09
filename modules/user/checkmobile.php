<?php
	global $db, $lable;
	$mobile=getParam("mobile");	
	$sql = "SELECT * FROM user WHERE mobile = '$mobile'";
	$rs = $db->Execute($sql);
	if($rs->fields("username"))
	{
		echo '<input type="hidden" name="checkmobile" id="checkmobile" value="1" />Số điện thoại này đã được đăng ký!';
	}else{
		echo '<input type="hidden" name="checkmobile" id="checkmobile" value="0" />';
	}
?>