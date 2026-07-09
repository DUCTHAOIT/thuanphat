<?php
	switch ($op){		
		case "update": Update(); break;
		default:mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lang;	
		$smarty->assign('themeName',$themeName);
		$smarty->assign('lang',$lang);
		$smarty->assign('arr',getConfig());		
		
		$smarty->assign('Support',$lable->_("Support"));
		$smarty->assign('Contact',$lable->_("Contact"));
		$smarty->assign('Site_name',$lable->_("Site name"));
		$smarty->assign('Web_title',$lable->_("Web title"));
		$smarty->assign('Email',$lable->_("Email"));
		$smarty->assign('Yahoo_online',$lable->_("Yahoo online"));
		$smarty->assign('Meta_key',$lable->_("Meta key"));
		$smarty->assign('Address',$lable->_("Address"));
		$smarty->assign('Description_website',$lable->_("Description website"));		
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Theme',$lable->_("Theme"));
		
		//		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/config.tpl','config_'.$themeName);	
		include_once("footer.php");
	}	
	
?>