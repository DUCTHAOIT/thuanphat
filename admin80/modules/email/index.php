<?php
	switch($op){	
		case"frm"		: 	frmNewsletter();
							break;
		case"send"		: 	sendNewsletter();
							break;
		case"list"		: 	listNewsletter();
							break;
		case"delete"	: 	deleteNewsletter();
							break;
		default			: 	mainShow();
							break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty;
		$smarty->assign('Create',$lable->_("Create"));
		$smarty->assign('title',$lable->_("Title html"));
		$smarty->assign('Keyword',getParam("txtSearch"));
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","listNewsletter", "listNewsletter");			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsletter.tpl','newsletter_'.$themeName);		
		include_once("footer.php");
	}
	//
	function listNewsletter(){
		global $themeName, $smarty;
		$arr=arrList();		
		$smarty->assign('arr',$arr);		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsletterList.tpl','newsletterList_'.$themeName);
	}
	//
	function frmNewsletter(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");				
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");				
		$smarty->assign('id',$id);
		
		$smarty->assign('Html_mannagement',$lable->_("Html mannagement"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('title',$lable->_("Title html"));
		$smarty->assign('Language',$lable->_("Language"));
		
		$smarty->assign('arr',getNewsletterID($id));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsletterFrm.tpl','newsletterFrm_'.$themeName);		
		include_once("footer.php");
	}
	
?>