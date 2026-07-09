<?php	
	function frmFaq(){
		global $smarty;		
		$lable = new language("faq");
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Question',$lable->_("Question"));
		$smarty->assign("Send_question", $lable->_("Send question"));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqFrm.tpl','faqFrm_');				
	}	
?>