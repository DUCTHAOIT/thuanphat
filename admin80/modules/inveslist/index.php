<?php
	switch($op){		
		case"frm"		:	frmAddinveslist();break;	
		case"update"	:	updateinveslist();break;								
		case"list"		: 	listinveslist();break;
		case"listUser"	: 	listinveslistUser();break;
		case"delete"	: 	deleteinveslist();break;
		case"duyet"		: 	duyetinveslist();break;
		case"mainShowUser"		: 	mainShowUser();break;
		case "deleteList"		: deleteList();break;
		case "lock"		: lockinveslist();break;
		default			: 	mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicinveslist=getGroupinveslist();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listinveslist", "listinveslist");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicinveslist',$arrTopicinveslist);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('inveslist_create',$lable->_("inveslist create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/inveslist.tpl','inveslist_'.$themeName);		
		include_once("footer.php");
	}
	//
	//
	function mainShowUser(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicinveslist=getGroupinveslist();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listinveslistUser", "listinveslistUser");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicinveslist',$arrTopicinveslist);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('inveslist_create',$lable->_("inveslist create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/inveslistUser.tpl','inveslistUser_'.$themeName);		
		include_once("footer.php");
	}
	//	
	function listinveslist(){		
		global $themeName, $smarty, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=20;
		
		$all=arrList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);		
		$smarty->assign('inveslist_name',$lable->_("inveslist name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',arrList(false,$pageID,20));	
			
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=inveslist&catID='.$catID,$numberRecord,20,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/inveslistList.tpl','inveslistList_'.$themeName);		
	}
	//
	//	
	function listinveslistUser(){		
		global $themeName, $smarty, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=20;
		
		$all=arrListUser(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);		
		$smarty->assign('inveslist_name',$lable->_("inveslist name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',arrListUser(false,$pageID,20));	
			
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=inveslist&op=mainShowUser&catID='.$catID,$numberRecord,20,$pageID));	

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/inveslistListUser.tpl','inveslistListUser_'.$themeName);		
	}
	//
	//
	function frmAddinveslist(){
		include_once("header.php");
		global $themeName, $smarty;
	
		$id=getParamPost("id");
		$arrTopicinveslist=getGroupinveslist($id);
		$arrTopicProduct=getGroupProduct($id);	
		$arrHocvien=getHocvien($id);	
		
		$smarty->assign('arrTopicinveslist',$arrTopicinveslist);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		$smarty->assign('arrHocvien',$arrHocvien);
		$smarty->assign('date_create',date("Y-m-d"));
		$smarty->assign('id',$id);
		$smarty->assign('arr',getinveslistID($id));		
		
		$smarty->assign('inveslist_name',$lable->_("inveslist name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Images',$lable->_("Images(w:120px - h: 90px)"));
		$smarty->assign('Images_title',$lable->_("Images title"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Language',$lable->_("Language"));
		//$smarty->assign('',$lable->_(""));
		//$smarty->assign('',$lable->_(""));		
		
		
			
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");			
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/inveslistFrm.tpl','inveslistFrm_'.$themeName);
				
		include_once("footer.php");
	}
	//
	
?>