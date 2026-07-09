<?php
	switch($op){
		case "frm"			: frmDownload();break;
		case "update"		: updateDownload();break;
		case "lock"			: lock();break;
		case "delelte"		: delete();break;
		case "list"			: downloadList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));				
		$smarty->assign('Create_download',$lable->_("Create download"));
		$smarty->assign("arrTopicDownload",getTopicDownload());
		
		$smarty->registerPlugin("function","downloadList","downloadList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/download.tpl','download_');		
		include_once("footer.php");
	}
	//	
	function frmDownload(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	if($id) $arr=getDownloadID($id);
	 	
	 	$smarty->assign("arr", $arr);	 	
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		//echo $arr["trial"];
		
		$smarty->assign("file_name", substr($arr["file_name"], -4));
			
		$smarty->assign("arrTopicDownload",getTopicDownload());
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Summary",$lable->_("Summary"));
		$smarty->assign("Des",$lable->_("Description"));		
		$smarty->assign("Languages",$lable->_("Language"));
		$smarty->assign("No",$lable->_("No."));
		//$smarty->assign("",$lable->_(""));
		$smarty->assign("fix_size_logo",$lable->_("fix size logo"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/downloadFrm.tpl','downloadFrm_');		
		
		include_once("footer.php");
	}
	//
	function downloadList(){
		global $smarty, $lable;
		$arr=getDownloadList(getParam("id"));		
		$smarty->assign("arr", $arr);		
		
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/downloadList.tpl','downloadList_');
	}
?>