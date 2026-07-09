<?php
	function advertiseLeftMenu(){	
	global $smarty,$lable,$themeName,$db,$lang;
	$sql="SELECT * FROM sys_advertise";
	$sql.=" WHERE (ctrl&1=1) AND (position='0') AND (lang='$lang')";
	$sql.=" ORDER BY no ASC LIMIT 0,10";
	$arradvertiseLeftMenu=$db->GetAssoc($sql);
	$smarty->assign('theme',$themeName);
	$smarty->assign('arradvertiseLeftMenu',$arradvertiseLeftMenu);
	$smarty->assign('Advertise',$lable->_("Advertise"));	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeftMenu.tpl','advertiseLeftMenu_');	
	}
?>

