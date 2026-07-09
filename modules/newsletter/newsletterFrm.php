<?php 
	function newsletter(){
		global $smarty;		
		$lable = new language("faq");
		$smarty->assign('comments',$lable->_("Comments"));
		$smarty->assign('introduction',$lable->_("Thank you for your interest Forcia. If you have comments or requests you can enter in the box below and send to us. we will respond to you as soon as possible:
"));
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Question',$lable->_("Question"));
		$smarty->assign("Send_question", $lable->_("Send question"));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsletterFrm.tpl','newsletterFrm_');		
	}
?>