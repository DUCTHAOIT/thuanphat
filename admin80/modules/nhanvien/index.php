<?php
	switch ($op){
		case "frmCreate": frmCreate(); break;
		case "mCreate"	: nhanvienCreate(); break;
		case "locknhanvien"	: locknhanvien(); break;
		case "mDelelte"	: nhanvienDelete(); break;
		default: mainShow(); break;
	}
	//
	 function mainShow(){
	 	global $smarty,$lable; 
	 	include_once("header.php");	 	
	 	$smarty->assign('nhanvien_create',$lable->_("nhanvien create"));
	 	$smarty->registerPlugin("function","nhanvienList","nhanvienList");
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/nhanvien.tpl','nhanvien');	
	 	include_once("footer.php");
	 }
	 //
	 function nhanvienList(){
	 	global $smarty, $themeName, $lable; 
	 	$arr=getnhanvienList();	 	
	 	$smarty->assign('arr',$arr);
	 	
	 	
	 	$smarty->assign('Date',$lable->_("Date"));	 	
	 	$smarty->assign('Number_access',$lable->_("Number access"));
	 	$smarty->assign('Status',$lable->_("Status"));
	 	$smarty->assign('Cannot_nhanvien',$lable->_("Cannot nhanvien"));
	 	$smarty->assign('No',$lable->_("No."));	 		 	
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/nhanvienList.tpl','nhanvienList_'.$themeName);
	 }
	 //
	 function frmCreate(){
	 	global $db, $smarty, $themeName, $lable; 
	 	include_once("header.php");
	
		$email=getParam("id");		
		
		if($email) $arr=getnhanvienID($email);	
		
	 	$smarty->assign('arr',$arr);	 	
		$smarty->assign('nhanvienID',$nhanvienID);
	 	//$smarty->assign('permit',getPermit());
		
		$arrnhanvienHD=getnhanvienHD($email);
		$smarty->assign('arrnhanvienHD',$arrnhanvienHD);
		
		$arrnhanvienHDTatToan=getnhanvienSohuu($email);
		$smarty->assign('arrnhanvienHDTatToan',$arrnhanvienHDTatToan);	 	
		
		include_once("modules/nhanvien/hdbannhanvien.php");
		$smarty->registerPlugin("function","hdbannhanvien","hdbannhanvien");
	 	
		$arrTSI=getTSI();
		$smarty->assign('arrTSI',$arrTSI);
		$arrTSITangGiam=getTSITangGiam();
		$smarty->assign('arrTSITangGiam',$arrTSITangGiam);
		
		$arrTSI2=getTSI2();
		$smarty->assign('arrTSI2',$arrTSI2);
		
		$id=getParam("id");
		
		$month=getParam("month");
		
		if(!$month){ $month=date("m");}
		$year=getParam("year");
		if(!$year){ $year=date("Y");}
		
		$smarty->assign('id',$id);	
		$smarty->assign('month',$month);
		$smarty->assign('year',$year);
		
		$url_sort_by=$_SERVER["REQUEST_URI"];
		$smarty->assign('url_sort_by',$url_sort_by);
		
	 	//$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->registerPlugin("function","format_number2", "format_number2");
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/nhanvienCreate.tpl','nhanvienCreate_'.$themeName);	
	 	include_once("footer.php");
	 }
	 
?>