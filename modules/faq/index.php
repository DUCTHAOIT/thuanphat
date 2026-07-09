<?php
	switch($op){
		case "add"		:	insertFaq();break;
		case "detail"	:	detail();break;
		default			:	mainShow();	break;
					
	}
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable;	
		
		$fid == '69';
		//$arr=getFunctionNameID($fid);
		//$smarty->assign('topicName',$arr["name"]);
		$smarty->assign('img1',$arr["img1"]);
		
		$smarty->registerPlugin("function","faqList", "faqList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faq.tpl','faq_');
		include_once("footer.php");
	}	
	function faqList(){		
		global $smarty, $lable;	
		$arr=listFaq();
						
		$smarty->assign('arr',$arr);
		$smarty->assign('Updating',$Updating);
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Date',$lable->_("Date"));
		//$smarty->assign('',$lable->_(""));
						
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqList.tpl','faqList_');
	}
	//
	function detail(){
		include_once("header.php");
		global $smarty, $lable;	
		$id=getParam(_MARK);		
		$arr=getFaqID($id);
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Date',$lable->_("Date"));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqDetail.tpl','faqDetail_');
		include_once("footer.php");
	}
	
?>