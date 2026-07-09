<?php
	include(_DOMAIN_ROOT_PATH."/smarty-master/libs/Smarty.class.php");
	$smarty = new Smarty;

	$smarty->template_dir = _DOMAIN_ROOT_PATH."/theme/" . $themeName;
	$smarty->compile_dir = _DOMAIN_ROOT_PATH."/theme/" . $themeName. "/cache/templates_c";
	$smarty->cache_dir = _DOMAIN_ROOT_PATH."/theme/".$themeName."/cache/smarty";	
	
	$smarty->caching = false;
//	 $smarty->clear_all_cache();
    $smarty->cache_lifetime = 120;
//	$smarty->compile_check = true;
	//$smarty->debugging = true;		
//	$smarty->load_filter('output','trimwhitespace');
	//$smarty->registerPlugin("function",'translate',"do_translate");
	//$smarty->registerPlugin("function","getCboLanguage", "getCboLanguage");
//	$smarty->registerPlugin("function","format_number", "format_number");
?>