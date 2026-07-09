<?php
	switch($op){
		case "frm"			: frmtstt();break;
		case "addtstt"	: addtstt();break;
		case "delete"		: deletetstt();break;
		case "deleteban"		: deleteban();break;
		case "daban"		: daban();break;
		case "huy"		:	huy();break;
		case "list"			: tsttList();break;
		case "locktstt"	: locktstt();break;
		case "photo"		: tsttPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: tsttFile(); break;
		case "addFile"		: addFile();break;
		case "deleteFile"	: deleteFile();break;
		case "lockFile"		: lockFile();break;
		case "ban"			: ban();break;
					
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$arr_hang_san_xuat = manufacturers();
		$smarty->assign('tstt_name',$lable->_("tstt name"));
		$smarty->assign('tstt_group',$lable->_("tstt group"));
		$smarty->assign('arrTopictstt',getTopictstt());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","tsttList", "tsttList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tstt.tpl','tstt_'.$themeName);		
		include_once("footer.php");
	}
	//
	function ban(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign('tstt_name',$lable->_("tstt name"));
		$smarty->assign('tstt_group',$lable->_("tstt group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","tsttListban", "tsttListban");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttban.tpl','tsttban_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmtstt(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=gettsttID($id);		
	
		$arr_user = getarruser();
		
		
		$smarty->assign('arrTopictstt',getTopictstt($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('tstt_group',$lable->_("tstt group"));
		$smarty->assign('tstts_sold_in',$lable->_("tstts sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('tstt_name',$lable->_("tstt name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('tstt_Focus',$lable->_("tstt Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttFrm.tpl','tsttFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function tsttList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gettsttList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('tstt_name',$lable->_("tstt name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('tstt_group',$lable->_("tstt group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('tstts_in_the_list',$lable->_("tstts in the list"));				
		
		$smarty->assign('arr',gettsttList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=tstt',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttList.tpl','tsttList_'.$themeName);		
	}
	//
	//
	function tsttListban(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gettsttListBan(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('tstt_name',$lable->_("tstt name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('tstt_group',$lable->_("tstt group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('tstts_in_the_list',$lable->_("tstts in the list"));				
		
		$smarty->assign('arr',gettsttListBan(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=tstt&op=ban',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttListban.tpl','tsttListban_'.$themeName);		
	}
	//
	function tsttPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(gettsttID($id));
		$smarty->assign('arr',gettsttID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_tstts",$lable->_("Management's tstts"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","tsttListPhoto", "tsttListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttPhoto.tpl','tsttPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function tsttListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gettsttListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttListPhoto.tpl','tsttListPhoto_'.$themeName);
	}
	//
	//
	function tsttFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',gettsttID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_tstt_file",$lable->_("Management tstt file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","tsttListFile", "tsttListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttFile.tpl','tsttFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function tsttListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gettsttListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsttListFile.tpl','tsttListFile_'.$themeName);
	}
?>