<?php
	error_reporting(0);
	@include_once("include/common.php");
	//checkAdministrator();
		
	$urlLang=getParam("lang");

	if($urlLang) setLang($urlLang);
	
	//if(!getParam("m")){		
	
	//	include_once("modules/intro/index.php");
	//	return;
	//}
	
	$moduleName=(getParam("m"))? getParam("m"): "home";
	//$moduleName=getParam("m");
	$op = getParam("op");
	$file = (getParam("f"))? getParam("f"): "index";
	
	loadClass("language");
	$lable = new language($moduleName);
	$lang=getLang();

	$file = "modules/" . $moduleName . "/" . $file . ".php";
	if (file_exists("modules/".$moduleName."/action.php")){

		@include_once("modules/".$moduleName."/action.php");
		//include_once("modules/".$moduleName."/action.php");
	}
	if (file_exists($file)){
		@include_once($file);
		//include_once($file);
	}
	else{		
		Err("Construction!");
	}
?>