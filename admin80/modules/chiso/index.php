<?php
	switch($op){		
		case"frm"		:	frmAddchiso();break;	
		case"update"	:	updatechiso();break;								
		case"list"		: 	listchiso();break;
		case"delete"	: 	deletechiso();break;
		case "lock"	: lockchiso();break;
		default			: 	mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicchiso=getGroupchiso();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listchiso", "listchiso");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopicchiso',$arrTopicchiso);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('chiso_create',$lable->_("chiso create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/chiso.tpl','chiso_'.$themeName);		
		include_once("footer.php");
	}
	//	
	function listchiso(){		
		global $themeName, $smarty, $lable;
		$arr=arrList();		
		$smarty->assign('chiso_name',$lable->_("chiso name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',$arr);			

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/chisoList.tpl','chisoList_'.$themeName);		
	}
	//
	function frmAddchiso(){
		include_once("header.php");
		global $themeName, $smarty;
		$id=getParamPost("id");
		$arrTopicchiso=getGroupchiso($id);
		$arrTopicProduct=getGroupProduct($id);	
		$arr=getchisoID($id);
		$content1="<table width=\"100%\" border=\"1\" cellspacing=\"2\" cellpadding=\"0\"  style=\"border:1px solid #666666\">
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
		
		$smarty->assign('arrTopicchiso',$arrTopicchiso);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		$smarty->assign('date_create',date("Y-m-d"));
		$smarty->assign('id',$id);
		$smarty->assign('content1',$content1);
		
		$smarty->assign('arr',getchisoID($id));		
		
		$smarty->assign('chiso_name',$lable->_("chiso name"));
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
		
		//$smarty->registerPlugin("function","setCboGroupchiso", "setCboGroupchiso");	
			
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");			
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/chisoFrm.tpl','chisoFrm_'.$themeName);
				
		include_once("footer.php");
	}
	//
	
?>