<?php 	
	//
	function getProductSearch(){
		global $db, $lang;
		
		$txtSearch=getParam("keyword");
		$sort_by=getParam("sort_by");
		$price= getParam("price");
		
		$sql="SELECT sys_product.*, TO_DAYS(sys_product.date_create) as today, sys_function.htaccess as url";
		$sql.=" FROM sys_product , sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.ctrl&1=1)";
		if($txtSearch){
			$sql.=" AND ((sys_product.name LIKE '%".$txtSearch."%') OR (sys_product.summary LIKE '%".$txtSearch."%'))";
		}	
		
		$sql.=" ORDER BY";
		if($sort_by=="thapcao") $sql.=" price ASC";
		elseif($sort_by=="caothap") $sql.=" price DESC";
				
		else $sql.=" today DESC";
		$arr=$db->GetAll($sql);	
		return $arr;						
	}
	//
?>