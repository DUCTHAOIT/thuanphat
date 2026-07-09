<?php
	switch($op){		
		case"frm"		:	frmAddhieuqua();break;	
		case"update"	:	updatehieuqua();break;								
		case"list"		: 	listhieuqua();break;
		case"delete"	: 	deletehieuqua();break;
		case "lock"	: lockhieuqua();break;
		default			: 	mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopichieuqua=getGrouphieuqua();		
		$arrTopicProduct=getGroupProduct();		
		
		$smarty->registerPlugin("function","listhieuqua", "listhieuqua");				
		$smarty->assign('arr',$arr);
		$smarty->assign('arrTopichieuqua',$arrTopichieuqua);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		
		$smarty->assign('keyword',getParamPost("txtSearch"));
				
		$smarty->assign('Display',$lable->_("Display 20 latest news in database"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('Keyword',$lable->_("Keyword"));
		$smarty->assign('hieuqua_create',$lable->_("hieuqua create"));
		
							
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hieuqua2.tpl','hieuqua_'.$themeName);		
		include_once("footer.php");
	}
	//	
	function listhieuqua(){		
		global $themeName, $smarty, $lable;
		$arr=arrList();		
		$smarty->assign('hieuqua_name',$lable->_("hieuqua name"));
		$smarty->assign('Source',$lable->_("Source"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Group_name',$lable->_("Group name"));
		$smarty->assign('arr',$arr);			

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hieuquaList2.tpl','hieuquaList_'.$themeName);		
	}
	//
	function frmAddhieuqua(){
		include_once("header.php");
		global $themeName, $smarty;
		$id=getParamPost("id");
		$arrTopichieuqua=getGrouphieuqua($id);
		$arrTopicProduct=getGroupProduct($id);	
		$arr=gethieuquaID($id);
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
		
		$smarty->assign('arrTopichieuqua',$arrTopichieuqua);
		$smarty->assign('arrTopicProduct',$arrTopicProduct);
		$smarty->assign('date_create',date("Y-m-d"));
		$smarty->assign('id',$id);
		$smarty->assign('content1',$content1);
		
		$smarty->assign('arr',gethieuquaID($id));		
		
		$smarty->assign('hieuqua_name',$lable->_("hieuqua name"));
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
		
		//$smarty->registerPlugin("function","setCboGrouphieuqua", "setCboGrouphieuqua");	
			
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");			
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hieuquaFrm2.tpl','hieuquaFrm_'.$themeName);
				
		include_once("footer.php");
	}
	//
	
?>