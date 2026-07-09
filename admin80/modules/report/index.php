<?php
	switch($op){
		case "frm"			: frmPartner();break;		
		case "update"			: updatePartner();break;
		case "lockPartner"			: lockPartner();break;
		case "pDelelte"			: partnerDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_partner',$lable->_("Create partner"));
		$smarty->registerPlugin("function","partnerList","partnerList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/report.tpl','report_');		
		include_once("footer.php");
	}	
?>