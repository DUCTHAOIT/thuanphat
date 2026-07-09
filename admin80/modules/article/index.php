<?php
	switch($op){		
		case"frm"		:	frmAddArticle();break;	
		case"update"	:	updateArticle();break;								
		case"list"		: 	listArticle();break;
		case"listUser"	: 	listArticleUser();break;
		case"delete"	: 	deleteArticle();break;
		case"duyet"		: 	duyetArticle();break;
		case"mainShowUser"		: 	mainShowUser();break;
		case "deleteList"		: deleteList();break;
		case "lock"		: lockArticle();break;
		default			: 	mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicArticle=getGroupArticle();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listArticle", "listArticle");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicArticle',$arrTopicArticle);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('Article_create',$lable->_("Article create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/article.tpl','article_'.$themeName);		
		include_once("footer.php");
	}
	//
	//
	function mainShowUser(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicArticle=getGroupArticle();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listArticleUser", "listArticleUser");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicArticle',$arrTopicArticle);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('Article_create',$lable->_("Article create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleUser.tpl','articleUser_'.$themeName);		
		include_once("footer.php");
	}
	//	
	function listArticle(){		
		global $themeName, $smarty, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=20;
		
		$all=arrList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);		
		$smarty->assign('Article_name',$lable->_("Article name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',arrList(false,$pageID,20));	
			
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=article&catID='.$catID,$numberRecord,20,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleList.tpl','articleList_'.$themeName);		
	}
	//
	//	
	function listArticleUser(){		
		global $themeName, $smarty, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=20;
		
		$all=arrListUser(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);		
		$smarty->assign('Article_name',$lable->_("Article name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',arrListUser(false,$pageID,20));	
			
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=article&op=mainShowUser&catID='.$catID,$numberRecord,20,$pageID));	

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleListUser.tpl','articleListUser_'.$themeName);		
	}
	//
	//
	function frmAddArticle(){
		include_once("header.php");
		global $themeName, $smarty;
	
		$id=getParamPost("id");
		$arrTopicArticle=getGroupArticle($id);
		$arrTopicProduct=getGroupProduct($id);	
		
		$smarty->assign('arrTopicArticle',$arrTopicArticle);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		$smarty->assign('date_create',date("d/m/Y"));
		$smarty->assign('id',$id);
		$smarty->assign('arr',getArticleID($id));		
		
		$smarty->assign('Article_name',$lable->_("Article name"));
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
		
		//$smarty->registerPlugin("function","setCboGroupArticle", "setCboGroupArticle");	
			
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");			
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleFrm.tpl','articleFrm_'.$themeName);
				
		include_once("footer.php");
	}
	//
	
?>