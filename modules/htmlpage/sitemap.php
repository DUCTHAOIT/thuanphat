<?php	
	
		include_once("header.php");
		global $db,$smarty, $lang, $lable;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$uid=getSession("uid");
		
		$obj->where="(ctrl&1=1)";
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
		
		
		$smarty->assign('Sitemap',$lable->_("Sitemap"));
		$smarty->assign('arr',$arr);		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/sitemap.tpl','sitemap_');
		include_once("footer.php");
	
?>