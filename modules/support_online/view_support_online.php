<?php
	function view_support_online()
	{
		global $smarty, $lable,$lang,$db,$themeName;
		
		$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$support=$rs->fields('value');
		
		$smarty->assign('themeName',$themeName);
		$smarty->assign('support',$support);
		$smarty->assign('lang',$lang);		
		$smarty->assign('SupportOnline',$lable->_("Support Online"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/support_online_view_form.tpl','support_online_view_form_');			
	}
?>