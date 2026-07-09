<?php
	switch($op){
		case "frm"			: frmpost();break;
		case "addpost"	: addpost();break;
		case "delete"		: deletepost();break;
		case "list"			: postList();break;
		case "lockpost"	: lockpost();break;
		case "photo"		: postPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: postFile(); break;
		case "addFile"		: addFile();break;
		case "deleteFile"	: deleteFile();break;
		case "lockFile"		: lockFile();break;
		case "product_user"	: 	product_user();break;
		case "bookmarked"	: 	bookmarked();break;
					
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$arr_hang_san_xuat = manufacturers();
		$smarty->assign('post_name',$lable->_("post name"));
		$smarty->assign('post_group',$lable->_("post group"));
		$smarty->assign('arrTopicpost',getTopicpost());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->register_function("postList", "postList");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/post.tpl','post_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmpost(){
		include_once("header.php");
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");	
		global $themeName, $smarty, $lable;
		setSession("ret_page","http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);		
		if(!$username){
			$ret_page="../user_login/";
			$a=new msgBox("Bạn cần phải đăng nhập để thực hiện chức năng này","OKOnly", "Message", array($ret_page), 2); 
			$a->showMsg();
		}else{
			$id=getParamPost("id");
			$arr=getpostID($id);		
			//$arr_hang_san_xuat = manufacturers();
			//$arr_tinh_trang = tinh_trang();
			//$arr_xuatsu = xuatsu();
			
			//$arr_manufacturers = manufacturers();
			//$arr_dongsp = dongsp();
			//$arr_loai = loai();
			//$arr_linhvuc = linhvuc();
			
			//$smarty->assign('arrTopicpost',getTopicpost($id));
			$smarty->assign('arr',$arr);
			//$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
			//$smarty->assign('arr_tinh_trang',$arr_tinh_trang);
			//$smarty->assign('arr_xuatsu',$arr_xuatsu);
			
			//$smarty->assign('arr_manufacturers',$arr_manufacturers);
			//$smarty->assign('arr_dongsp',$arr_dongsp);
			//$smarty->assign('arr_loai',$arr_loai);
			//$smarty->assign('arr_linhvuc',$arr_linhvuc);
			
			
			$smarty->assign('id',$id);		
			//$smarty->assign('date_create',date("Y-m-d"));		
			
			$smarty->assign('post_group',$lable->_("post group"));
			$smarty->assign('posts_sold_in',$lable->_("posts sold in"));
			$smarty->assign('Delivery',$lable->_("Delivery"));
			$smarty->assign('Promotion',$lable->_("Promotion"));
			$smarty->assign('Technical',$lable->_("Technical"));
			$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
			
			$smarty->assign('post_name',$lable->_("post name"));
			$smarty->assign('Price_new',$lable->_("Price new"));
			$smarty->assign('Price_old',$lable->_("Price old"));
			$smarty->assign('Summary',$lable->_("Summary"));
			$smarty->assign('Detail',$lable->_("Detail"));
			$smarty->assign('Date_create',$lable->_("Date create"));
			$smarty->assign('Languages',$lable->_("Languages"));
			$smarty->assign('Update',$lable->_("Update"));
			$smarty->assign('Photo',$lable->_("Photo"));
			$smarty->assign('Special_promotion',$lable->_("Special promotion"));
			$smarty->assign('post_Focus',$lable->_("post Focus"));
					
			$smarty->assign('Insert_file',$lable->_("Insert file"));		
			$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
			$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
			
			$smarty->register_function("viewFckeditor", "viewFckeditor");
			//$smarty->register_function("viewFckeditor1", "viewFckeditor1");
			//$smarty->register_function("viewFckeditor2", "viewFckeditor2");
			//$smarty->register_function("viewFckeditor3", "viewFckeditor3");
			//$smarty->register_function("viewFckeditor4", "viewFckeditor4");
			//$smarty->register_function("viewFckeditors", "viewFckeditors");
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postFrm.tpl','postFrm_'.$themeName);
		}	
		include_once("footer.php");
	}
	//
	function postList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getpostList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('post_name',$lable->_("post name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('post_group',$lable->_("post group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('posts_in_the_list',$lable->_("posts in the list"));				
		
		$smarty->assign('arr',getpostList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=post&catID='.$fun.'&hang_san_xuat='.$hang_san_xuat,$numberRecord,20,$pageID));
		
		$smarty->register_function("format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postList.tpl','postList_'.$themeName);		
	}
	//
	function postPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(getpostID($id));
		$smarty->assign('arr',getpostID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_posts",$lable->_("Management's posts"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->register_function("postListPhoto", "postListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postPhoto.tpl','postPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function postListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getpostListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postListPhoto.tpl','postListPhoto_'.$themeName);
	}
	//
	//
	function postFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',getpostID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_post_file",$lable->_("Management post file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->register_function("viewFckeditor", "viewFckeditor");
		$smarty->register_function("postListFile", "postListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postFile.tpl','postFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function postListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getpostListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/postListFile.tpl','postListFile_'.$themeName);
	}
	function product_user()
	{		
		include_once("header.php");
		global $smarty, $lable,$arr_info_page,$db;
		
		$smarty->assign('quality_certificate',$lable->_("quality certificate"));		
		$smarty->register_function("product_list_user", "product_list_user");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productMainUser.tpl','productMainUser_');
			
		include_once("footer.php");
	}
	//
	function product_list_user()
	{
		
		global $smarty,$lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$sort_by=getParam("sort_by");
		$limit=getParam("limit");
		if(!$limit) $limit=5;
		
		$MemberID=getParam("id");
		
		if(!$MemberID){
			$username=getSession("username");
			$MemberID=getMemberNameID($username,"id");
			
		}
		$arr=get_product_list_user($MemberID);
		$numberRecord=count($arr);
		
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/user_list/");
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Details"));
		
		$smarty->register_function("strstrimtempsearch", "strstrimtempsearch");
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/user_list/",$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list_user.tpl','product_list_user_');
		
	}
	function bookmarked()
	{		
		include_once("header.php");
		global $smarty, $lable,$arr_info_page,$db;
		
		$smarty->assign('quality_certificate',$lable->_("quality certificate"));		
		$smarty->register_function("product_bookmarked_list", "product_bookmarked_list");	
			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productMainUserbookmarked.tpl','productMainUserbookmarked_');
			
		include_once("footer.php");
	}
	function product_bookmarked_list()
	{
		
		global $smarty,$lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$sort_by=getParam("sort_by");
		$limit=getParam("limit");
		if(!$limit) $limit=5;
		
		$username=getSession("username");
		$MemberID=getMemberNameID($username,"id");
		
		$arr=get_product_list_user_bookmarked($username);
		
		$numberRecord=count($arr);
		
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/bookmarked/");
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Details"));
		$smarty->register_function("strstrimtempsearch", "strstrimtempsearch");
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/bookmarked/",$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list_user_bookmarked.tpl','product_list_user_bookmarked_');
		
	}
?>