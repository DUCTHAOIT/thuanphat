<?php
	switch($op){
		case "frm"			: frmcommentproduct();break;		
		case "update"			: updatecommentproduct();break;
		case "lock"			: lockcommentproduct();break;
		case "delelte"			: deletecommentproduct();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign("Create",$lable->_("Create"));
		
		$smarty->registerPlugin("function","commentproductList","commentproductList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentproduct.tpl','commentproduct_');		
		include_once("footer.php");
	}
	//
	function frmcommentproduct(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=commentproductID($id);
	 	
	 	$smarty->assign("arr", $arr);
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("commentproduct_information",$lable->_("commentproduct information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Date",$lable->_("Date"));
		$smarty->assign("Email",$lable->_("Email"));
		$smarty->assign("Mobile",$lable->_("Mobile"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("Subject",$lable->_("Subject"));
		$smarty->assign("Question",$lable->_("Question"));
		$smarty->assign("Answer",$lable->_("Answer"));		
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentproductFrm.tpl','commentproductFrm_');		
		
		include_once("footer.php");
	}
	//
	function commentproductList(){
		global $smarty, $lable;
		$arr=getcommentproductList();				
		$smarty->assign("arr", $arr);		
		
		//$smarty->assign("",$lable->_(""));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentproductList.tpl','commentproductList_');
	}
?>