<?php
	$username=getSession("username");
	if(!$username) return;
	$id=getParam("id");
	$iduserorder=getParam("iduserorder");
	$sogiohoc=getParam("sogiohoc");
	
	$userid=getMemberNameID($username,"id");
	$sql="DELETE FROM sys_nhanxet WHERE (id=$id) AND (hlv=$userid)";
	$result=$db->Execute($sql);
	if($result){
		$sql="UPDATE sys_userorder SET sogiodahoc=sogiodahoc-$sogiohoc WHERE  id='$iduserorder'";	
		$db->Execute($sql);	
	}
	
	
	$sql="SELECT sys_nhanxet.*, DATE_FORMAT(sys_nhanxet.date_create, '".format_date()."') as date_create FROM sys_nhanxet WHERE sys_nhanxet.iduserorder=$iduserorder ORDER BY date_create ASC";
	$arr=$db->GetAssoc($sql);
	$smarty->assign('arr',$arr);	
	$smarty->assign('name',$name);	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_diemdanh.tpl','user_diemdanh_'.$themeName);
	return;
?>
