<?php
	switch($op){
		case "frm"			: frmworldwide();break;		
		case"list"		: 	worldwideList();break;
		case "update"			: updateworldwide();break;
		case "lockworldwide"			: lockworldwide();break;
		case "pDelete"			: worldwideDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopicArticle=getGroupArticle();	
		
		$smarty->assign('arrTopicArticle',$arrTopicArticle);
		
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_worldwide',$lable->_("Create worldwide"));
		$smarty->registerPlugin("function","worldwideList","worldwideList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwide.tpl','worldwide_');		
		include_once("footer.php");
	}
	//
	function frmworldwide(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getworldwideID($id);
	 	
	 	//$arr_cat=getworldwideCat();
	 	//$smarty->assign("arr_cat", $arr_cat);
	 	$smarty->assign("arr", $arr);
	 	
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("worldwide_infomation",$lable->_("worldwide information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));
		$smarty->assign("Description",$lable->_("Description"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");		
		
		$smarty->assign('arrTopicProduct',getTopicProduct($id));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwideFrm.tpl','worldwideFrm_');		
		
		include_once("footer.php");
	}
	//
	function worldwideList(){
		global $smarty, $lable;
		$arr=getworldwideList();	
		$smarty->assign("arr", $arr);		
			
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwideList.tpl','worldwideList_');
	}
?>