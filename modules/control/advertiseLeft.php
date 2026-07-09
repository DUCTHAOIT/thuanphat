<?php
	function advertiseLeft(){	
	global $smarty,$lable,$themeName,$db,$lang;
	$sql="SELECT * FROM sys_advertise";
	$sql.=" WHERE (ctrl&1=1) AND (position='3') AND (lang='$lang')";
	$sql.=" ORDER BY no ASC LIMIT 0,10";
	$arr=$db->GetAssoc($sql);
	$smarty->assign('theme',$themeName);
	$smarty->assign('arr',$arr);
	$smarty->assign('Advertise',$lable->_("Advertise"));	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeft.tpl','advertiseLeft_');	
	}
?>

