<?php
	function menuLeftSanpham(){
		global $db,$smarty, $lang, $lable, $themeName;		
		include "theme/default/templates/menu_left_sanpham.php";
		return;			
		//$fid=getparamFID(getParam(_MARK));		
		loadClass("constructSql");
		$obj=new constructSql();		
		$uid=getSession("uid");
		
		$obj->where="(ctrl&5=5) AND (module='product')";
		$obj->tableName="sys_function";		
		//$obj->where="(ctrl&5=5)";
		$obj->orderBy="sort";
		$obj->limit="all";
		$sql=$obj->sqlSelect();
		//echo $sql;
		
		include_once("modules/control/menuLeft.class.php");
		$obj=new menuLeft();
		$obj->sql=$sql;
		$arr=$obj->orderMenu();	
		
		
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menuLeft.tpl','menuLeft_');	
	}
?>