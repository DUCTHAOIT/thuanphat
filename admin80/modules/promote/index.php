<?php
	switch($op){
		case "frm"			: frmPromote();break;		
		case "update"			: updatePromote();break;
		case "lock"			: lockPromote();break;
		case "pDelete"			: promoteDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign("Create",$lable->_("Create"));
		$smarty->registerPlugin("function","promoteList","promoteList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/promote.tpl','promote_');		
		include_once("footer.php");
	}
	//
	function frmPromote(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getPromoteID($id);	 	
	 	$smarty->assign("arr", $arr);	 	
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("promote_infomation",$lable->_("promote information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Url",$lable->_("Url"));		
		$smarty->assign("Description",$lable->_("Description"));	
		$smarty->assign("Photo",$lable->_("Photo"));	
		$smarty->assign("fix_size_logo",$lable->_("fix size photo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/promoteFrm.tpl','promoteFrm_');		
		
		include_once("footer.php");
	}
	//
	function promoteList(){
		global $smarty, $lable;
		$arr=getPromoteList();		
		$smarty->assign("arr", $arr);		
		
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/promoteList.tpl','promoteList_');
	}
?>