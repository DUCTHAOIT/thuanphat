<?php	
	switch($op){
		case "frm"			: frmService();break;		
		case "update"			: updateService();break;
		case "lockService"			: lockService();break;
		case "pDelelte"			: serviceDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_service',$lable->_("Create Service"));
		$smarty->registerPlugin("function","serviceList","serviceList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/service.tpl','service_');		
		include_once("footer.php");
	}
	//
	function frmService(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getServiceID($id);
	 	
	 	$smarty->assign("arr", $arr);
	 	$smarty->assign("serviceID", $serviceID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		
		$smarty->assign("Service_infomation",$lable->_("Service information"));
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));
		$smarty->assign("Description",$lable->_("Description"));
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/serviceFrm.tpl','serviceFrm_');		
		
		include_once("footer.php");
	}
	//
	function serviceList(){
		global $smarty, $lable;
		$arr=getServiceList();		
		$smarty->assign("arr", $arr);		
		
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/serviceList.tpl','serviceList_');
	}
?>