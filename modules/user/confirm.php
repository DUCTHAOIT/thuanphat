<?php
global $db;
include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");

	if($_GET['id']!='')
	{
		
		$sql="SELECT * FROM user WHERE id = '".$_GET['id']."'";
		$rs=$db->Execute($sql);
		
		if($rs->RecordCount())
		{
		
			if($rs->fields("ctrl")==1)
			{
				echo 'Xac nhan dang ky nhan mail thanh cong!';
			}
			elseif($rs->fields("rand_key")!=$_GET['key'])
			{
				echo 'Viec xac nhan khong thanh cong. Ban vui long thuc hien viec dang ky lai !';
			}
			else
			{
				
				$sql="UPDATE user SET ctrl=1 WHERE id='".$rs->fields("id")."'";						
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
	

	function numeric($str)
	{
		return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
	}

	function alpha_numeric($str)
	{
		return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}
?>