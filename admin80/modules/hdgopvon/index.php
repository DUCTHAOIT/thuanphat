<?php
	switch($op){
		case "frm"			: frmhdgopvon();break;
		case "addhdgopvon"	: addhdgopvon();break;
		case "delete"		: deletehdgopvon();break;
		case "daban"		: daban();break;
		case "huy"		:	huy();break;
		case "deleteban"		: deleteban();break;
		case "list"			: hdgopvonList();break;
		case "lockhdgopvon"	: lockhdgopvon();break;
		case "hoancochdgopvon"	: hoancochdgopvon();break;
		case "photo"		: hdgopvonPhoto();break;
		case "addPhoto"		: addPhoto();break;
		case "deletePhoto"	: deletePhoto();break;
		
		case "file"			: hdgopvonFile(); break;
		case "addFile"		: addFile();break;
		case "deleteFile"	: deleteFile();break;
		case "deletelistFile"	: deletelistFile();break;
		case "lockFile"		: lockFile();break;
		case "ban"			: ban();break;
					
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$userid=getParam("userid");
		$proid=getParam("proid");
		$loaihd=getParam("loaihd");
		$smarty->assign('userid',$userid);	
		$smarty->assign('proid',$proid);	
		$smarty->assign('loaihd',$loaihd);	
		
		$arr_user = getarruser();
		$smarty->assign('arrgopvon',getarrgopvon($id));
		$smarty->assign('arr_user',$arr_user);	
		
		$smarty->assign('hdgopvon_name',$lable->_("hdgopvon name"));
		$smarty->assign('hdgopvon_group',$lable->_("hdgopvon group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","hdgopvonList", "hdgopvonList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvon.tpl','hdgopvon_'.$themeName);		
		include_once("footer.php");
	}
	//
	function ban(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		
		$smarty->assign('hdgopvon_name',$lable->_("hdgopvon name"));
		$smarty->assign('hdgopvon_group',$lable->_("hdgopvon group"));
		
		$smarty->assign('Create',$lable->_("Create"));	
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));				
		$smarty->registerPlugin("function","hdgopvonListban", "hdgopvonListban");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonban.tpl','hdgopvonban_'.$themeName);		
		include_once("footer.php");
	}
	//
	function frmhdgopvon(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$id=getParam("id");
		$arr=gethdgopvonID($id);		
	
		$arr_user = getarruser();
		
		
		$smarty->assign('arrTopichdgopvon',getTopichdgopvon($id));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_user',$arr_user);
		
		$smarty->assign('id',$id);		
		$smarty->assign('date_create',date("Y-m-d"));		
		
		$smarty->assign('hdgopvon_group',$lable->_("hdgopvon group"));
		$smarty->assign('hdgopvons_sold_in',$lable->_("hdgopvons sold in"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->assign('hdgopvon_name',$lable->_("hdgopvon name"));
		$smarty->assign('Price_new',$lable->_("Price new"));
		$smarty->assign('Price_old',$lable->_("Price old"));
		$smarty->assign('Summary',$lable->_("Summary"));
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('Date_create',$lable->_("Date create"));
		$smarty->assign('Languages',$lable->_("Languages"));
		$smarty->assign('Update',$lable->_("Update"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('Special_promotion',$lable->_("Special promotion"));
		$smarty->assign('hdgopvon_Focus',$lable->_("hdgopvon Focus"));
				
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonFrm.tpl','hdgopvonFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function hdgopvonList(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gethdgopvonList(true,0,0);
		$numberRecord=count($all);			
		
		$smarty->assign('hdgopvon_name',$lable->_("hdgopvon name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('hdgopvon_group',$lable->_("hdgopvon group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('hdgopvons_in_the_list',$lable->_("hdgopvons in the list"));				
		
		$smarty->assign('arr',gethdgopvonList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=hdgopvon',$numberRecord,20,$pageID));
		$smarty->registerPlugin("function","danhsachhdmuachungListFile", "danhsachhdmuachungListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonList.tpl','hdgopvonList_'.$themeName);		
	}
	//
	//
	function hdgopvonListban(){
		global $themeName, $smarty, $lable;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $catID=getParamPost("hang_san_xuat");
						
		$all=gethdgopvonListBan(true,0,0);
		$numberRecord=count($all);		
		
		$smarty->assign('hdgopvon_name',$lable->_("hdgopvon name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('hdgopvon_group',$lable->_("hdgopvon group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('hdgopvons_in_the_list',$lable->_("hdgopvons in the list"));				
		
		$smarty->assign('arr',gethdgopvonListBan(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=hdgopvon&op=ban',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonListban.tpl','hdgopvonListban_'.$themeName);		
	}
	//
	function hdgopvonPhoto(){
		include_once("header.php");		
		global $themeName, $smarty, $lable;		
		$id=getParam("id");
		
		$idPhoto=getParam("idPhoto");		
		
		//print_r(gethdgopvonID($id));
		$smarty->assign('arr',gethdgopvonID($id));
		$smarty->assign('arrPhoto',$arrPhoto=getPhotoID($idPhoto));
		$smarty->assign('id',$id);
		$smarty->assign("Photo_size",$lable->_("Photo size must be adjusted as provided below"));
		$smarty->assign("Management_hdgopvons",$lable->_("Management's hdgopvons"));
		$smarty->assign("Update",$lable->_("Update"));
		
		$smarty->registerPlugin("function","hdgopvonListPhoto", "hdgopvonListPhoto");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonPhoto.tpl','hdgopvonPhoto_'.$themeName);		
		include_once("footer.php");
	}
	//
	function hdgopvonListPhoto(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gethdgopvonListPhoto($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonListPhoto.tpl','hdgopvonListPhoto_'.$themeName);
	}
	//
	//
	function hdgopvonFile(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;		
		$id=getParam("id");
		$idFile=getParam("idFile");	
				
		$smarty->assign('arr',gethdgopvonID($id));
		$smarty->assign('arrFile',$arrFile=getFileID($idFile));
		$smarty->assign('id',$id);
		$smarty->assign('idFile',$idFile);
		
		
		$smarty->assign("Management_hdgopvon_file",$lable->_("Management hdgopvon file"));
		$smarty->assign("Insert_file",$lable->_("Insert file"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign("Title",$lable->_("Title"));
		$smarty->assign("Content",$lable->_("Content"));
		
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");
		$smarty->registerPlugin("function","hdgopvonListFile", "hdgopvonListFile");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonFile.tpl','hdgopvonFile_'.$themeName);		
		include_once("footer.php");
	}
	//	
	//
	function hdgopvonListFile(){
		global $themeName, $smarty, $lable;	
		$id=getParam("id");
				
		$smarty->assign('arr',gethdgopvonListFile($id));
		$smarty->assign('groupID',$id);
		$smarty->assign("Delete",$lable->_("Delete"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdgopvonListFile.tpl','hdgopvonListFile_'.$themeName);
	}
	/// upload file
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
		$ret_page="?m=hdgopvon&op=frm&id=".$id_function;
		$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();
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