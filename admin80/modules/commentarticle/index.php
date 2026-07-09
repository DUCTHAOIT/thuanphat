<?php
	switch($op){
		case "frm"			: frmcommentarticle();break;		
		case "update"			: updatecommentarticle();break;
		case "lock"			: lockcommentarticle();break;
		case "delelte"			: deletecommentarticle();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign("Create",$lable->_("Create"));
		
		$smarty->registerPlugin("function","commentarticleList","commentarticleList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentarticle.tpl','commentarticle_');		
		include_once("footer.php");
	}
	//
	function frmcommentarticle(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=commentarticleID($id);
	 	
	 	$smarty->assign("arr", $arr);
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("commentarticle_information",$lable->_("commentarticle information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Date",$lable->_("Date"));
		$smarty->assign("Email",$lable->_("Email"));
		$smarty->assign("Mobile",$lable->_("Mobile"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("Subject",$lable->_("Subject"));
		$smarty->assign("Question",$lable->_("Question"));
		$smarty->assign("Answer",$lable->_("Answer"));		
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentarticleFrm.tpl','commentarticleFrm_');		
		
		include_once("footer.php");
	}
	//
	function commentarticleList(){
		global $smarty, $lable;
		$arr=getcommentarticleList();				
		$smarty->assign("arr", $arr);			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/commentarticleList.tpl','commentarticleList_');
	}
?>