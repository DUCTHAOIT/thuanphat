<?php
	switch($op){
		case "frm"			: frmWeblink();break;		
		case "update"			: updateWeblink();break;
		case "lock"			: lockWeblink();break;
		case "delelte"			: deleteWeblink();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign("Website_associate", $lable->_("Website associate"));
		
		$smarty->registerPlugin("function","frmWeblink","frmWeblink");
		$smarty->registerPlugin("function","listWeblink","listWeblink");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/weblink.tpl','weblink_');		
		include_once("footer.php");
	}
	//
	function frmWeblink(){		
		global $lang, $smarty, $lable;
		$id=getParamPost("id");
		if($id){
			$arr=getWeblinkID($id);
			$smarty->assign('arr',$arr);
		}
		
		$smarty->assign('lang',$lang);
		
		$smarty->assign('Name_weblink',$lable->_("Name weblink"));				
		$smarty->assign('Website',$lable->_("Website"));		
		$smarty->assign('No',$lable->_("No."));
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Update',$lable->_("Update"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/weblinkFrm.tpl','weblinkFrm_');		
	}
	//
	function listWeblink(){
		global $lang, $smarty, $lable;
		$arr=getWeblinkList();
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/weblinkList.tpl','weblinkList_');	
	}
?>