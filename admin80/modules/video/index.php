<?php
	switch($op){
		case "frm"			: frmvideo();break;		
		case "update"			: updatevideo();break;
		case "lockvideo"			: lockvideo();break;
		case "pDelete"			: videoDelete();break;
		
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$arrTopic=getGroup();
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
				
		$smarty->assign('Create_video',$lable->_("Create video"));
		$smarty->registerPlugin("function","videoList","videoList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/video.tpl','video_');		
		include_once("footer.php");
	}
	//
	function frmvideo(){
		include_once("header.php");
		global $smarty, $lable;
		$id=getParamPost("id");
	 	$arr=getvideoID($id);
	 	
	 	$arrGroup=getGroupVideo();
		//$arr_cat=getvideoCat();
	 	//$smarty->assign("arr_cat", $arr_cat);
	 	$smarty->assign("arr", $arr);
	 	
	 	$smarty->assign("partnerID", $partnerID);
		$smarty->assign("lang", $lang);
		$smarty->assign("id", $id);
		$smarty->assign('arrGroup', $arrGroup);
			
		$smarty->assign("video_infomation",$lable->_("video information"));
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/videoFrm.tpl','videoFrm_');		
		
		include_once("footer.php");
	}
	//
	function videoList(){
		global $smarty, $lable;
		$arr=getvideoList();		
		$smarty->assign("arr", $arr);		
			
		$smarty->assign("Name",$lable->_("Name"));
		$smarty->assign("Address",$lable->_("Address"));
		$smarty->assign("Tel",$lable->_("Tel"));
		$smarty->assign("Website",$lable->_("Website"));		
		$smarty->assign("No",$lable->_("No."));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/videoList.tpl','videoList_');
	}
?>