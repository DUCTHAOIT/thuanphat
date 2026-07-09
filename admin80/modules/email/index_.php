<?php
	switch($op){	
		case"frm"		: 	frmHtmlpage();
							break;
		case"update"	: 	updateHtmlpage();
							break;
		case"list"		: 	listHtmlpage();
							break;
		case"delete"	: 	deleteHtmlpage();
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
		$smarty->registerPlugin("function","listHtmlpage", "listHtmlpage");			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/htmlpage.tpl','htmlpage_'.$themeName);		
		include_once("footer.php");
	}
	//
	function listHtmlpage(){
		global $themeName, $smarty;
		$arr=arrList();		
		$smarty->assign('arr',$arr);		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/htmlpageList.tpl','htmlpageList_'.$themeName);
	}
	//
	function frmHtmlpage(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");				
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");			
		
		$smarty->assign('id',$id);
		
		$smarty->assign('Html_mannagement',$lable->_("Html mannagement"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('title',$lable->_("Title html"));
		$smarty->assign('Language',$lable->_("Language"));
		
		$smarty->assign('arr',getHtmlpageID($id));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/htmlpageFrm.tpl','htmlpageFrm_'.$themeName);		
		include_once("footer.php");
	}
	
?>