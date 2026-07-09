<?php
function dautungay(){ 
	global $smarty, $lable,$db;
	$username=getSession("username");
	
	$arrTSI=getTSI();
	$smarty->assign('arrTSI',$arrTSI);
	$arrTSITangGiam=getTSITangGiam();
	$smarty->assign('arrTSITangGiam',$arrTSITangGiam);
	
	$arrTSI2=getTSI2();
	$smarty->assign('arrTSI2',$arrTSI2);
	$arrTSITangGiam2=getTSITangGiam2();
	$smarty->assign('arrTSITangGiam2',$arrTSITangGiam2);
	
	include_once("modules/home/hieuqua.php");
	$smarty->registerPlugin("function","hieuqua","hieuqua");
	
	include_once("modules/home/hieuquabv.php");
	$smarty->registerPlugin("function","hieuquabv","hieuquabv");
	
	$smarty->assign('username',$username);
	$smarty->registerPlugin("function","format_number", "format_number");
	$smarty->registerPlugin("function","format_number2", "format_number2");
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/dautungay.tpl','dautungay_');
	
	}
//
	//
	function getTSI(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getTSITangGiam(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	//
	function getTSI2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date  FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getTSITangGiam2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=1  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//	
?>