<?php
	switch($op){
		case "frm"			: frmhdmuachung();break;
		case "addhdmuachung"	: addhdmuachung();break;
		case "delete"		: deletehdmuachung();break;
		case "daban"		: daban();break;
		case "huy"		:	huy();break;
		case "deleteban"		: deleteban();break;
		case "list"			: hdmuachungList();break;
		case "lockhdmuachung"	: lockhdmuachung();break;
		case "hoancochdmuachung"	: hoancochdmuachung();break;
		case "photo"		: hdmuachungPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: hdmuachungFile(); break;
		case "addFile"		: addFile();break;
		case "deleteFile"	: deleteFile();break;
		case "lockFile"		: lockFile();break;
		
		case "loaiSale"			: loaiSale();break;
		case "deletelistFile"			: deletelistFile();break;
					
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$userid=getParam("userid");
		$proid=getParam("proid");
		$loaihd=getParam("loaihd");
		$aff=getParam("aff");
		$smarty->assign('userid',$userid);	
		$smarty->assign('proid',$proid);	
		$smarty->assign('loaihd',$loaihd);	
		$smarty->assign('aff',$aff);	
		
		$arr_user = getarruser();
		$smarty->assign('arrproduct',getarrproduct($id));
		$smarty->assign('arr_user',$arr_user);	
		
		$smarty->assign('hdmuachung_name',$lable->_("hdmuachung name"));
		$smarty->assign('hdmuachung_group',$lable->_("hdmuachung group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","hdmuachungList", "hdmuachungList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachung.tpl','hdmuachung_'.$themeName);		
		include_once("footer.php");
	}
	//
	function loaiSale(){
		global $db,$lang,$lable;		
		$id=getParam("id");	
		$sale=getParam("sale");
		$sql="UPDATE sys_userorder SET sale=$sale WHERE  id='$id'";		
		$db->Execute($sql);
		
	}
	//
	function frmhdmuachung(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParam("id");
		$arr=gethdmuachungID($id);		
	
		$arr_user = getarruser();
		
		$smarty->assign('arrLop',getLop());
		
		$smarty->assign('arrTopichdmuachung',getTopichdmuachung($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('hdmuachung_group',$lable->_("hdmuachung group"));
		$smarty->assign('hdmuachungs_sold_in',$lable->_("hdmuachungs sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('hdmuachung_name',$lable->_("hdmuachung name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('hdmuachung_Focus',$lable->_("hdmuachung Focus"));
				
		$smarty->assign('Insert_file',$lable->_("Insert file"));		
		$smarty->assign("Photo_big_size",$lable->_("Photo big size"));
		$smarty->assign("Photo_small_size",$lable->_("Photo small size"));
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","viewFckeditor1", "viewFckeditor1");
		$smarty->registerPlugin("function","viewFckeditor2", "viewFckeditor2");
		$smarty->registerPlugin("function","viewFckeditor3", "viewFckeditor3");
		$smarty->registerPlugin("function","viewFckeditor4", "viewFckeditor4");
		$smarty->registerPlugin("function","viewFckeditors", "viewFckeditors");
		
		$smarty->assign('technicalList',technicalList($id));
		$smarty->assign('frmEdit',frmEdit());
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungFrm.tpl','hdmuachungFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function hdmuachungList(){
		global $themeName, $smarty, $lable;
		$userid=getParam("userid");
		$proid=getParam("proid");
		$aff=getParam("aff");
		if($proid){$limit=200;}else{$limit=20;}
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gethdmuachungList(true,0,$limit);
		$numberRecord=count($all);			
		
		$smarty->assign('hdmuachung_name',$lable->_("hdmuachung name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('hdmuachung_group',$lable->_("hdmuachung group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('hdmuachungs_in_the_list',$lable->_("hdmuachungs in the list"));				
		
		$smarty->assign('arrsale',getSale());
		$smarty->assign('arr',gethdmuachungList(false,$pageID,$limit));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=hdmuachung',$numberRecord,$limit,$pageID));
		$smarty->assign('aff',$aff);
		$smarty->registerPlugin("function","nameLop", "nameLop");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungList.tpl','hdmuachungList_'.$themeName);		
	}
	//
	//
	function hdmuachungListban(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gethdmuachungListBan(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('hdmuachung_name',$lable->_("hdmuachung name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('hdmuachung_group',$lable->_("hdmuachung group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('hdmuachungs_in_the_list',$lable->_("hdmuachungs in the list"));				
		
		$smarty->assign('arr',gethdmuachungListBan(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=hdmuachung&op=ban',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungListban.tpl','hdmuachungListban_'.$themeName);		
	}
	//
	function hdmuachungPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(gethdmuachungID($id));
		$smarty->assign('arr',gethdmuachungID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_hdmuachungs",$lable->_("Management's hdmuachungs"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","hdmuachungListPhoto", "hdmuachungListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungPhoto.tpl','hdmuachungPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function hdmuachungListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gethdmuachungListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungListPhoto.tpl','hdmuachungListPhoto_'.$themeName);
	}
	//
	//
	function hdmuachungFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',gethdmuachungID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_hdmuachung_file",$lable->_("Management hdmuachung file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","hdmuachungListFile", "hdmuachungListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungFile.tpl','hdmuachungFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function hdmuachungListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gethdmuachungListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungListFile.tpl','hdmuachungListFile_'.$themeName);
	}
	/// file
	function frmEdit(){
		global $themeName, $smarty, $lable,$db;	
		$id_technical=getParam("id_technical");
		$id_function=getParam("id_function");
		if($id_technical){
			$sql="SELECT * FROM sys_product_search WHERE (id =  '$id_technical') OR (parent =  '$id_technical') ORDER BY parent ASC";
			$arr=$db->GetAll($sql);
		}else{
			for($i=0; $i<=1;$i++){				
				$arr[$i]=$i;
			}
		}		
		$smarty->assign('arrfile',$arr);
		$smarty->assign('id_function',$id_function);
		$smarty->assign('id_technical',$id_technical);
		$output= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/function_search_criteria_form.tpl");
		return $output;
	}
	
	function technicalList($fid){
		if(!$fid) return;
		global $db,$smarty,$moduleName;
		$sql="SELECT * FROM sys_product_search WHERE catID='$fid' ORDER BY order_number";		
		$arr=$db->GetAssoc($sql);	
		
		$smarty->assign('arrListfile',$arr);
		$smarty->assign('moduleName',$moduleName);		
		$output= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/function_search_criteria_panel.tpl");		
		
		return $output;		
	}
	//
	function deletelistFile(){
		global $db;
		$id_technical=getParam("id_technical");		
		$id_function=getParam("id_function");		
		$sql="DELETE FROM sys_product_search WHERE (id='$id_technical')";
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=hdmuachung&op=frm&id=".$id_function;
		$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();
	}
	
	//
	function nameLop($id){
		global $themeName, $smarty, $lable, $db;
		$id=$id["id"];
	
		$sql="SELECT * FROM sys_inveslist WHERE id=$id";	
		$rs=$db->Execute($sql);
		$name=$rs->fields("name");
		return $name;	
	}
	//
	function danhsachhdmuachungListFile($fid){
		global $themeName, $smarty, $lable, $db;
		$fid=$fid["fid"];
	
		$sql="SELECT * FROM sys_product_search WHERE catID=$fid  ORDER BY order_number";		
		$arrdanhsachListfile=$db->GetAssoc($sql);
		$numberRecord=count($arrdanhsachListfile);
		if($numberRecord<1) return;;
		$smarty->assign('arrdanhsachListfile',$arrdanhsachListfile);	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachung_danhsach_file.tpl','hdmuachung_danhsach_file_'.$themeName);
		return;	
	}
?>