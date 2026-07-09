<?php
	switch($op){
		case "frm"			: frmSupport();break;		
		case "update"			: updateSupport();break;
		case "lockSupport"			: lockSupport();break;
		case "pDelete"			: supportDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_support',$lable->_("Create support"));
		$smarty->registerPlugin("function","supportList","supportList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/support.tpl','support_');		
		include_once("footer.php");
	}
	//
	function frmSupport(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getSupportID($id);
	 	
	 	//$arr_cat=getSupportCat();
	 	//$smarty->assign("arr_cat", $arr_cat);
	 	$smarty->assign("arr", $arr);
	 	
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("support_infomation",$lable->_("support information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));
		$smarty->assign("Description",$lable->_("Description"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/supportFrm.tpl','supportFrm_');		
		
		include_once("footer.php");
	}
	//
	function supportList(){
		global $smarty, $lable;
		$arr=getSupportList();		
		$smarty->assign("arr", $arr);		
			
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/supportList.tpl','supportList_');
	}
?>