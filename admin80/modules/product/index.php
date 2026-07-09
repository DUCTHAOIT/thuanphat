<?php
	switch($op){
		case "frm"			: frmProduct();break;
		case "addProduct"	: addProduct();break;
		case "delete"		: deleteProduct();break;
		case "list"			: productList();break;
		case "lockProduct"	: lockProduct();break;
		case "photo"		: productPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: productFile(); break;
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
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Product_group',$lable->_("Product group"));
		$smarty->assign('arrTopicProduct',getTopicProduct());
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","productList", "productList");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product.tpl','product_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmProduct(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParamPost("id");
		$arr=getProductID($id);		
		$arr_hang_san_xuat = manufacturers();
		$arr_tinh_trang = tinh_trang();
		$arr_xuatsu = xuatsu();
		
		$arr_manufacturers = manufacturers();
		$arr_dongsp = dongsp();
		$arr_loai = loai();
		$arr_linhvuc = linhvuc();
		
		$arrTopicAdmin=getGroupAdmin($id);
		
		$smarty->assign('arrTopicProduct',getTopicProduct($id));
		$smarty->assign('arrTopicAdmin',$arrTopicAdmin);
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_hang_san_xuat',$arr_hang_san_xuat);
		$smarty->assign('arr_tinh_trang',$arr_tinh_trang);
		$smarty->assign('arr_xuatsu',$arr_xuatsu);
		
		$smarty->assign('arr_manufacturers',$arr_manufacturers);
		$smarty->assign('arr_dongsp',$arr_dongsp);
		$smarty->assign('arr_loai',$arr_loai);
		$smarty->assign('arr_linhvuc',$arr_linhvuc);
		
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('Product_group',$lable->_("Product group"));
		$smarty->assign('Products_sold_in',$lable->_("Products sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('Product_Focus',$lable->_("Product Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		
		$smarty->registerPlugin("function","viewFckeditor5", "viewFckeditor5");
		$smarty->registerPlugin("function","viewFckeditor6", "viewFckeditor6");
		$smarty->registerPlugin("function","viewFckeditor7", "viewFckeditor7");
		$smarty->registerPlugin("function","viewFckeditor8", "viewFckeditor8");
		
		$smarty->registerPlugin("function","viewFckeditor9", "viewFckeditor9");
		$smarty->registerPlugin("function","viewFckeditor10", "viewFckeditor10");
		$smarty->registerPlugin("function","viewFckeditor11", "viewFckeditor11");
		$smarty->registerPlugin("function","viewFckeditor12", "viewFckeditor12");
		
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productFrm.tpl','productFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function productList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=getProductList(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Product_group',$lable->_("Product group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('products_in_the_list',$lable->_("products in the list"));				
		
		$smarty->assign('arr',getProductList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=product&catID='.$fun.'&hang_san_xuat='.$hang_san_xuat,$numberRecord,20,$pageID));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productList.tpl','productList_'.$themeName);		
	}
	//
	//
	function productPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(getProductID($id));
		$smarty->assign('arr',getProductID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_products",$lable->_("Management's products"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","productListPhoto", "productListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productPhoto.tpl','productPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function productListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getProductListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productListPhoto.tpl','productListPhoto_'.$themeName);
	}
	//
	//
	function productFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',getProductID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_product_file",$lable->_("Management product file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","productListFile", "productListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productFile.tpl','productFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function productListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',getproductListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productListFile.tpl','productListFile_'.$themeName);
	}
?>