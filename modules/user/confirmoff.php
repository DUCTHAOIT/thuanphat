<?php
include_once("include/common.php");

require_once(_DOMAIN_ROOT_PATH . "/modules/newsletter/db.php");
include(_DOMAIN_ROOT_PATH . "/modules/newsletter/functions.php");
include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	global $db;
	if($_GET['ID']!='' && numeric($_GET['ID'])==TRUE && strlen($_GET['key'])==32 && alpha_numeric($_GET['key'])==TRUE)
	{
		$query = mysql_query("SELECT ID, rand_key, status FROM subscribers WHERE ID = '".mysql_real_escape_string($_GET['ID'])."'");

		if(mysql_num_rows($query)==1)
		{
			$row = mysql_fetch_assoc($query);
			if($row['status']==0)
			{
				$delete = mysql_query("DELETE FROM subscribers WHERE ID='".mysql_real_escape_string($row['ID'])."'") or die(mysql_error());
				echo 'Xac nhan khong nhan mail thanh cong!';
			}
			elseif($row['rand_key']!=$_GET['key'])
			{
				echo 'Viec xac nhan khong thanh cong. Ban vui long thuc hien viec dang ky lai !';
			}
			else
			{
				//$update = mysql_query("UPDATE subscribers SET status=0 WHERE ID='".mysql_real_escape_string($row['ID'])."'") or die(mysql_error());				
				$delete = mysql_query("DELETE FROM subscribers WHERE ID='".mysql_real_escape_string($row['ID'])."'") or die(mysql_error());
				//$sql="DELETE FROM subscribers WHERE id='".mysql_real_escape_string($row['ID'])."'";
				//$db->Execute($sql);
				//echo $sql;
				//return;
				echo 'Chao mung ban den voi khuyenmai365ngay.com!<br>Xac nhan khong nhan mail thanh cong!';				
			}
		}
		else {
			echo 'Khong tim thay Email dang ky !';
		}

	}
	else {
		echo 'Du lieu khong hop le !';
	}	
	$ret_page="/";
	$a=new msgBox("Pleate wait...","OKOnly", "Message", array($ret_page), 1);
	$a->showMsg();
?>