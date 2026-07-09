<?php
	switch($op){
		case "frm"			: frmalbums();break;
		case "addalbums"	: addalbums();break;
		case "delete"		: deletealbums();break;
		case "list"			: albumsList();break;
		case "lockalbums"	: lockalbums();break;
		case "photo"		: albumsPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$arr_hang_san_xuat = manufacturers();
		$smarty->assign('albums_name',$lable->_("Album name"));
		$smarty->assign('albums_group',$lable->_("Album group"));
		$smarty->assign('arrTopicalbums',getTopicalbums());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","albumsList", "albumsList");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums.tpl','albums_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmalbums(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=getalbumsID($id);		
		$arr_hang_san_xuat = manufacturers();
		$arr_khach_hang = khach_hang();
		$arr_tinh_trang = tinh_trang();
		
		$smarty->assign('arrTopicalbums',getTopicalbums($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_khach_hang',$arr_khach_hang);
		$smarty->assign('arr_tinh_trang',$arr_tinh_trang);
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('albums_name',$lable->_("Album name"));
		$smarty->assign('albums_group',$lable->_("Album group"));
		$smarty->assign('albumss_sold_in',$lable->_("albumss sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albumsFrm.tpl','albumsFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function albumsList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getalbumsList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('albums_name',$lable->_("albums name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('albums_group',$lable->_("albums group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('albumss_in_the_list',$lable->_("albumss in the list"));				
		
		$smarty->assign('arr',getalbumsList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=albums&catID='.$catID.'&hang_san_xuat='.$hang_san_xuat,$numberRecord,20,$pageID));
		
		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albumsList.tpl','albumsList_'.$themeName);		
	}
	//
	function albumsPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(getalbumsID($id));
		$smarty->assign('arr',getalbumsID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_albumss",$lable->_("Management's albumss"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","albumsListPhoto", "albumsListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albumsPhoto.tpl','albumsPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function albumsListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getalbumsListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albumsListPhoto.tpl','albumsListPhoto_'.$themeName);
	}
	
?>