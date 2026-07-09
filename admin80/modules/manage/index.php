<?php
	switch($op){
		case "frm"			: frmManage();break;
		case "update"		: updateManage();break;		
		case "lock"			: lockManage();break;
		case "delete"		: deleteManage();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign("Create_manage",$lable->_("Create manage"));
		
		$smarty->registerPlugin("function","manageList","manageList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/manage.tpl','manage_');		
		include_once("footer.php");
	}
	//
	function frmManage(){
		include_once("header.php");
		global $lang, $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getManageID($id);	 	
		$smarty->assign('lang',$lang);
		$smarty->assign('arr',$arr);
						
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Position',$lable->_("Position"));
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Image',$lable->_("Image"));
		$smarty->assign('No',$lable->_("No."));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('fix_size_image',$lable->_("fix size image"));
		$smarty->assign('Manage_information',$lable->_("Manage information"));		
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/manageFrm.tpl','manageFrm_');		
		include_once("footer.php");
	}
	//
	function manageList(){
		global $smarty, $lable;
		$arr=getManageList();		
		$smarty->assign("arr", $arr);		
		
		$smarty->assign("Manage_information",$lable->_("Manage information"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/manageList.tpl','manageList_');
	}		
?>