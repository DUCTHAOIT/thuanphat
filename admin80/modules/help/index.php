<?php
	switch($op){
		case "frm"			: frmHelp();break;		
		case "update"			: updateHelp();break;
		case "lockHelp"			: lockHelp();break;
		case "pDelelte"			: helpDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_help',$lable->_("Create help"));
		$smarty->registerPlugin("function","helpList","helpList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/help.tpl','help_');		
		include_once("footer.php");
	}
	//
	function frmHelp(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getHelpID($id);
	 	
	 	$smarty->assign("file_name", substr($arr["file_name"], -4));
	 	$smarty->assign("flash_file", substr($arr["flash_file"], -4));
	 	
	 	$smarty->assign("arr", $arr);
	 	$smarty->assign("helpID", $helpID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);		
		
		$smarty->assign("help_infomation",$lable->_("help information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));
		$smarty->assign("Description",$lable->_("Description"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/helpFrm.tpl','helpFrm_');		
		
		include_once("footer.php");
	}
	//
	function helpList(){
		global $smarty, $lable;
		$arr=getHelpList();		
		$smarty->assign("arr", $arr);		
		
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/helpList.tpl','helpList_');
	}
?>