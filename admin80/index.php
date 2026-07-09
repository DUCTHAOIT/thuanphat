<?php
	error_reporting(0);
	@include_once("include/common.php");	
	//include_once("include/common.php");
	checkAdministrator();	
	$moduleName=(getParam("m"))? getParam("m"): "home";
	$op = getParam("op");
	$file = (getParam("f"))? getParam("f"): "index";
	
	checkPermit($moduleName);
	
	loadClass("language");
	$lable = new language($moduleName);
	$lang=getLang();
	$file = "modules/" . $moduleName . "/" . $file . ".php";
	if (file_exists("modules/".$moduleName."/action.php")){
		//@include_once("modules/".$moduleName."/action.php");
		include_once("modules/".$moduleName."/action.php");
	}
	if (file_exists($file)){
		//@include_once($file);
		include_once($file);
	}
	else{		
		Err("No access file or not permit!");
	}
	//
	function checkAdministrator(){
		$uid=getSession("uid");			
		if(!$uid) header("Location: login.php");		
	}
	die();
?>