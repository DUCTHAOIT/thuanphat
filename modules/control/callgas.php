<?php
	function callGas(){	
	global $smarty,$lable,$themeName,$db,$lang;
		
	$smarty->assign('theme',$themeName);
	$smarty->assign('Advertise',$lable->_("Advertise"));
	$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/callGas.tpl','callGas_');	
	}
?>
