<?php
	switch($op){
		case "frm"			: frmFaq();break;		
		case "update"			: updateFaq();break;
		case "lock"			: lockFaq();break;
		case "delelte"			: deleteFaq();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign("Create",$lable->_("Create"));
		
		$smarty->registerPlugin("function","faqList","faqList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faq.tpl','faq_');		
		include_once("footer.php");
	}
	//
	function frmFaq(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=faqID($id);
	 	
	 	$smarty->assign("arr", $arr);
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("Faq_information",$lable->_("Faq information"));
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
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqFrm.tpl','faqFrm_');		
		
		include_once("footer.php");
	}
	//
	function faqList(){
		global $smarty, $lable;
		$arr=getFaqList();				
		$smarty->assign("arr", $arr);		
		
		//$smarty->assign("",$lable->_(""));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqList.tpl','faqList_');
	}
?>