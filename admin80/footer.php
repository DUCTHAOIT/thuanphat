<?php
	global $lang;
	if(!$smarty->is_cached(_DOMAIN_ROOT_TEMPLATE.'/footer.tpl','footer_'.$themeName)){	
		$smarty->assign('lang', $lang);		
	}
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/footer.tpl','footer_'.$themeName);	
?>