<?php
	global $db,$lang,$lable;
	$id=getParam("id");		
	$date=getParam("date");
	$date = str_replace('/', '-', $date);
	$new_date =  date('Y-m-d', strtotime($date));
	$sogiohoc=getParam("sogiohoc");
	$comments=getParam("comments");
	$userid=getParam("userid");
	if(!$id) return;
	$sql="INSERT INTO sys_nhanxet ( iduserorder, date_create, sogiohoc, comments, hlv ) VALUES ( '$id', '$new_date', '$sogiohoc', '$comments', '$userid' )";
	$return=$db->Execute($sql);
	if($return){
		$sql="UPDATE sys_userorder SET sogiodahoc=sogiodahoc+$sogiohoc WHERE  id='$id'";	
		$db->Execute($sql);	
		
		
	}
	
	
	$sql="SELECT sys_nhanxet.*, DATE_FORMAT(sys_nhanxet.date_create, '".format_date()."') as date_create FROM sys_nhanxet WHERE sys_nhanxet.iduserorder=$id ORDER BY date_create ASC";
	$arr=$db->GetAssoc($sql);
	$smarty->assign('arr',$arr);	
	$smarty->assign('name',$name);	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_diemdanh.tpl','user_diemdanh_'.$themeName);
	return;
?>
