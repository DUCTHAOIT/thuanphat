<?php
	switch($op){
		case "frm"			: frmuserorder();break;
		case "adduserorder"	: adduserorder();break;
		case "delete"		: deleteuserorder();break;
		case "list"			: userorderList();break;
		case "lockuserorder"	: lockuserorder();break;
		case "photo"		: userorderPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: userorderFile(); break;
		case "addFile"		: addFile();break;
		case "deleteFile"	: deleteFile();break;
		case "lockFile"		: lockFile();break;
					
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$arr_hang_san_xuat = manufacturers();
		$smarty->assign('userorder_name',$lable->_("userorder name"));
		$smarty->assign('userorder_group',$lable->_("userorder group"));
		$smarty->assign('arrTopicuserorder',getTopicuserorder());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","userorderList", "userorderList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorder.tpl','userorder_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmuserorder(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=getuserorderID($id);		
	
		$arr_user = getarruser();
		
		
		$smarty->assign('arrTopicuserorder',getTopicuserorder($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('userorder_group',$lable->_("userorder group"));
		$smarty->assign('userorders_sold_in',$lable->_("userorders sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('userorder_name',$lable->_("userorder name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('userorder_Focus',$lable->_("userorder Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderFrm.tpl','userorderFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function userorderList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getuserorderList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('userorder_name',$lable->_("userorder name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('userorder_group',$lable->_("userorder group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('userorders_in_the_list',$lable->_("userorders in the list"));				
		
		$smarty->assign('arr',getuserorderList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=userorder&catID='.$fun.'&hang_san_xuat='.$hang_san_xuat,$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderList.tpl','userorderList_'.$themeName);		
	}
	//
	function userorderPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(getuserorderID($id));
		$smarty->assign('arr',getuserorderID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_userorders",$lable->_("Management's userorders"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","userorderListPhoto", "userorderListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderPhoto.tpl','userorderPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function userorderListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getuserorderListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderListPhoto.tpl','userorderListPhoto_'.$themeName);
	}
	//
	//
	function userorderFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',getuserorderID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_userorder_file",$lable->_("Management userorder file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","userorderListFile", "userorderListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderFile.tpl','userorderFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function userorderListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getuserorderListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userorderListFile.tpl','userorderListFile_'.$themeName);
	}
?>