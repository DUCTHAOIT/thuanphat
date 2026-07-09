<?php
	
	//$hostname = "localhost";
	//$database = "logo_forcia"; //nhap vao ten cua database (lien he nguoi quan tri hosting)
	//$username = "logo_admin"; //username cho database
	//$password = "123456";     //nhap vao mat khau database
	include_once("include/common.php");
	//require_once(_DOMAIN_ROOT_PATH . "/admin80/include/configDatabase.php");
	
	$nletter = mysql_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($DATABASE_NAME);
?>