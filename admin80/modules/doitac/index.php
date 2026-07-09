<?php
	switch ($op){
		case "frmCreate": frmCreate(); break;
		case "mCreate"	: doitacCreate(); break;
		case "lockdoitac"	: lockdoitac(); break;
		case "mDelelte"	: doitacDelete(); break;
		default: mainShow(); break;
	}
	//
	 function mainShow(){
	 	global $smarty,$lable; 
	 	include_once("header.php");	 	
	 	$smarty->assign('doitac_create',$lable->_("doitac create"));
	 	$smarty->registerPlugin("function","doitacList","doitacList");
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/doitac.tpl','doitac');	
	 	include_once("footer.php");
	 }
	 //
	 function doitacList(){
	 	global $smarty, $themeName, $lable; 
	 	$arr=getdoitacList();	 	
	 	$smarty->assign('arr',$arr);
	 	
	 	
	 	$smarty->assign('Date',$lable->_("Date"));	 	
	 	$smarty->assign('Number_access',$lable->_("Number access"));
	 	$smarty->assign('Status',$lable->_("Status"));
	 	$smarty->assign('Cannot_doitac',$lable->_("Cannot doitac"));
	 	$smarty->assign('No',$lable->_("No."));	 		 	
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/doitacList.tpl','doitacList_'.$themeName);
	 }
	 //
	 function frmCreate(){
	 	global $db, $smarty, $themeName, $lable; 
	 	include_once("header.php");
	
		$email=getParam("id");		
		
		if($email) $arr=getdoitacID($email);	
		
	 	$smarty->assign('arr',$arr);	 	
		$smarty->assign('doitacID',$doitacID);
	 	//$smarty->assign('permit',getPermit());
		
		$arrdoitacHD=getdoitacHD($email);
		$smarty->assign('arrdoitacHD',$arrdoitacHD);
		
		$arrdoitacHDTatToan=getdoitacSohuu($email);
		$smarty->assign('arrdoitacHDTatToan',$arrdoitacHDTatToan);	 	
		
		include_once("modules/doitac/hdbandoitac.php");
		$smarty->registerPlugin("function","hdbandoitac","hdbandoitac");
	 	
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
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/doitacCreate.tpl','doitacCreate_'.$themeName);	
	 	include_once("footer.php");
	 }
	 
?>