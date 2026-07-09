<?php
	switch($op){
		case "frm"			: frmAdvertise();break;		
		case "update"			: updateAdvertise();break;
		case "lockAdvertise"			: lockAdvertise();break;
		case "pDelete"			: advertiseDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_advertise',$lable->_("Create advertise"));
		$smarty->registerPlugin("function","advertiseList","advertiseList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertise.tpl','advertise_');		
		include_once("footer.php");
	}
	//
	function frmAdvertise(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getAdvertiseID($id);
	 	
	 	//$arr_cat=getAdvertiseCat();
	 	//$smarty->assign("arr_cat", $arr_cat);
	 	$smarty->assign("arr", $arr);
	 	
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("advertise_infomation",$lable->_("advertise information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));
		$smarty->assign("Description",$lable->_("Description"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseFrm.tpl','advertiseFrm_');		
		
		include_once("footer.php");
	}
	//
	function advertiseList(){
		global $smarty, $lable;
		$arr=getAdvertiseList();		
		$smarty->assign("arr", $arr);		
			
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseList.tpl','advertiseList_');
	}
?>