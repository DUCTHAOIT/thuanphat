<?php
	switch($op){
		case "frm"			: frmtsbv();break;
		case "addtsbv"	: addtsbv();break;
		case "delete"		: deletetsbv();break;
		case "daban"		: daban();break;
		case "huy"		:	huy();break;
		case "deleteban"		: deleteban();break;
		case "list"			: tsbvList();break;
		case "locktsbv"	: locktsbv();break;
		case "photo"		: tsbvPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: tsbvFile(); break;
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
		$smarty->assign('tsbv_name',$lable->_("tsbv name"));
		$smarty->assign('tsbv_group',$lable->_("tsbv group"));
		$smarty->assign('arrTopictsbv',getTopictsbv());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","tsbvList", "tsbvList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbv.tpl','tsbv_'.$themeName);		
		include_once("footer.php");
	}
	//
	function ban(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign('tsbv_name',$lable->_("tsbv name"));
		$smarty->assign('tsbv_group',$lable->_("tsbv group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","tsbvListban", "tsbvListban");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvban.tpl','tsbvban_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmtsbv(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=gettsbvID($id);		
	
		$arr_user = getarruser();
		
		
		$smarty->assign('arrTopictsbv',getTopictsbv($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('tsbv_group',$lable->_("tsbv group"));
		$smarty->assign('tsbvs_sold_in',$lable->_("tsbvs sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('tsbv_name',$lable->_("tsbv name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('tsbv_Focus',$lable->_("tsbv Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvFrm.tpl','tsbvFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function tsbvList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gettsbvList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('tsbv_name',$lable->_("tsbv name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('tsbv_group',$lable->_("tsbv group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('tsbvs_in_the_list',$lable->_("tsbvs in the list"));				
		
		$smarty->assign('arr',gettsbvList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=tsbv',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvList.tpl','tsbvList_'.$themeName);		
	}
	//
	//
	function tsbvListban(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gettsbvListBan(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('tsbv_name',$lable->_("tsbv name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('tsbv_group',$lable->_("tsbv group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('tsbvs_in_the_list',$lable->_("tsbvs in the list"));				
		
		$smarty->assign('arr',gettsbvListBan(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=tsbv&op=ban',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvListban.tpl','tsbvListban_'.$themeName);		
	}
	//
	function tsbvPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(gettsbvID($id));
		$smarty->assign('arr',gettsbvID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_tsbvs",$lable->_("Management's tsbvs"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","tsbvListPhoto", "tsbvListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvPhoto.tpl','tsbvPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function tsbvListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gettsbvListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvListPhoto.tpl','tsbvListPhoto_'.$themeName);
	}
	//
	//
	function tsbvFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',gettsbvID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_tsbv_file",$lable->_("Management tsbv file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","tsbvListFile", "tsbvListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvFile.tpl','tsbvFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function tsbvListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gettsbvListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tsbvListFile.tpl','tsbvListFile_'.$themeName);
	}
?>