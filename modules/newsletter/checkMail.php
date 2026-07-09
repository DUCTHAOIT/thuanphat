<?php
	global $db, $lable;
	$txtMail=getParam("mail");	
	$sql = "SELECT * FROM subscribers WHERE email = '$txtMail'";
	$rs = $db->Execute($sql);
//	echo "duong".$sql;
	//return;
	if($rs->fields("email"))
	{
		echo '<input type="hidden" name="checkMail" id="checkMail" value="1" />Email này đã được đăng ký!';
	}else{
		echo '<input type="hidden" name="checkMail" id="checkMail" value="0" />';
	}
?>