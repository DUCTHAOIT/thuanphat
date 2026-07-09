<?php
include_once "header.php";
include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	global $db;
	
	if($_GET['ID']!='' && strlen($_GET['key'])==32)
	{
		//$query = mysql_query("SELECT ID, rand_key, status FROM subscribers WHERE ID = '".mysql_real_escape_string($_GET['ID'])."'");
		$sql="SELECT * FROM subscribers WHERE ID='".$_GET['ID']."'";
		
		$rs=$db->Execute($sql);
		
		if($rs->RecordCount())
		{
		
			if($rs->fields("status")==1)
			{
				echo 'Xac nhan dang ky nhan mail thanh cong!';
			}
			elseif($rs->fields("rand_key")!=$_GET['key'])
			{
				echo 'Viec xac nhan khong thanh cong. Ban vui long thuc hien viec dang ky lai !';
			}
			else
			{
				$sql="UPDATE subscribers SET status=1 WHERE ID='".$rs->fields("ID")."'";		
				$db->Execute($sql);
				echo 'Xac nhan dang ky nhan mail thanh cong!';				
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
include_once "footer.php";
?>