<?php
	global $db, $lable;
	$txtMail=getParam("mail");	
	$sql = "SELECT * FROM user WHERE email = '$txtMail'";
	$rs = $db->Execute($sql);
	if($rs->fields("username"))
	{
		echo '<input type="hidden" name="checkMail" id="checkMail" value="1" />Email này đã được đăng ký!';
	}else{
		echo '<input type="hidden" name="checkMail" id="checkMail" value="0" />';
	}
?>