<?php
	switch($op){		
		case"frm"		:	frmAddpartner();break;	
		case"update"	:	updatepartner();break;								
		case"list"		: 	listpartner();break;
		case"delete"	: 	deletepartner();break;
		case "lock"	: lockpartner();break;
		default			: 	mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicpartner=getGrouppartner();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listpartner", "listpartner");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicpartner',$arrTopicpartner);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('partner_create',$lable->_("partner create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partner.tpl','partner_'.$themeName);		
		include_once("footer.php");
	}
	//	
	function listpartner(){		
		global $themeName, $smarty, $lable;
		$arr=arrList();		
		$smarty->assign('partner_name',$lable->_("partner name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',$arr);			

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partnerList.tpl','partnerList_'.$themeName);		
	}
	//
	function frmAddpartner(){
		include_once("header.php");
		global $themeName, $smarty;
		$id=getParamPost("id");
		$arrTopicpartner=getGrouppartner($id);
		$arrTopicProduct=getGroupProduct($id);	
		$arr=getpartnerID($id);
		
		$smarty->assign('arrTopicpartner',$arrTopicpartner);
		$smarty->assign('date_create',date("Y-m-d"));
		$smarty->assign('id',$id);
		$smarty->assign('content1',$content1);
		
		$smarty->assign('arr',getpartnerID($id));		
		
		$smarty->assign('partner_name',$lable->_("partner name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Images',$lable->_("Images(w:120px - h: 90px)"));
		$smarty->assign('Images_title',$lable->_("Images title"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Language',$lable->_("Language"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditor5", "viewFckeditor5");
			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partnerFrm.tpl','partnerFrm_'.$themeName);
				
		include_once("footer.php");
	}
	//
	
?>