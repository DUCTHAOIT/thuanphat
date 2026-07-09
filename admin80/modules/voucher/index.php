<?php
	switch($op){
		case "frm"			: frmvoucher();break;
		case "addvoucher"	: addvoucher();break;
		case "delete"		: deletevoucher();break;
		case "daban"		: daban();break;
		case "huy"		:	huy();break;
		case "deleteban"		: deleteban();break;
		case "list"			: voucherList();break;
		case "lockvoucher"	: lockvoucher();break;
		case "photo"		: voucherPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: voucherFile(); break;
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
		$smarty->assign('voucher_name',$lable->_("voucher name"));
		$smarty->assign('voucher_group',$lable->_("voucher group"));
		$smarty->assign('arrTopicvoucher',getTopicvoucher());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","voucherList", "voucherList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucher.tpl','voucher_'.$themeName);		
		include_once("footer.php");
	}
	//
	function ban(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign('voucher_name',$lable->_("voucher name"));
		$smarty->assign('voucher_group',$lable->_("voucher group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","voucherListban", "voucherListban");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherban.tpl','voucherban_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmvoucher(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=getvoucherID($id);		
	
		$arr_user = getarruser();
		
		
		$smarty->assign('arrTopicvoucher',getTopicvoucher($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('voucher_group',$lable->_("voucher group"));
		$smarty->assign('vouchers_sold_in',$lable->_("vouchers sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('voucher_name',$lable->_("voucher name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('voucher_Focus',$lable->_("voucher Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherFrm.tpl','voucherFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function voucherList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getvoucherList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('voucher_name',$lable->_("voucher name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('voucher_group',$lable->_("voucher group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('vouchers_in_the_list',$lable->_("vouchers in the list"));				
		
		$smarty->assign('arr',getvoucherList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=voucher',$numberRecord,20,$pageID));
		
		$smarty->registerPlugin("function","nameUser", "nameUser");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherList.tpl','voucherList_'.$themeName);		
	}
	//
	//
	function voucherListban(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getvoucherListBan(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('voucher_name',$lable->_("voucher name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('voucher_group',$lable->_("voucher group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('vouchers_in_the_list',$lable->_("vouchers in the list"));				
		
		$smarty->assign('arr',getvoucherListBan(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=voucher&op=ban',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherListban.tpl','voucherListban_'.$themeName);		
	}
	//
	function voucherPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(getvoucherID($id));
		$smarty->assign('arr',getvoucherID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_vouchers",$lable->_("Management's vouchers"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","voucherListPhoto", "voucherListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherPhoto.tpl','voucherPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function voucherListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getvoucherListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherListPhoto.tpl','voucherListPhoto_'.$themeName);
	}
	//
	//
	function voucherFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',getvoucherID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_voucher_file",$lable->_("Management voucher file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","voucherListFile", "voucherListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherFile.tpl','voucherFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function voucherListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getvoucherListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/voucherListFile.tpl','voucherListFile_'.$themeName);
	}
	
	//
	function nameUser($id){
		global $themeName, $smarty, $lable, $db;
		$id=$id["id"];
	
		$sql="SELECT * FROM user WHERE id=$id";	
		$rs=$db->Execute($sql);
		$name=$rs->fields("name");
		echo '<a href="'._DOMAIN_ROOT_URL.'/admin80/?m=user&op=frmCreate&id='.$rs->fields("email").'" >'.$name.'</a>';
		return;	
	}
	//
?>