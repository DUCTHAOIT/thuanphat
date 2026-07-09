<?php
	/**
	 * Dem so san pham co trong gio hang
	 *
	 */	
	global $lable,$smarty,$db;	
	$count_basket=count($_SESSION["basket"]);
	if($count_basket){
	///
		$arr=$_SESSION["basket"];		
		foreach ($arr as $key=>$value){
			if($key>0) $product.="'$key',";			
		}
		$product=substr($product, 0, strlen($product)-1);
		if(!$product){
			//echo $lable->_("Cannot find product in basket");
			return;
		}
		
		$sql="SELECT sys_product.id, sys_product.name, sys_product.price, sys_product.catID, sys_product.img, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product, sys_function";
		$sql.=" WHERE sys_product.id IN($product) AND (sys_product.catID=sys_function.id)";
		
		$rs=$db->Execute($sql);
		
		if(!$rs->RecordCount()){
			//echo box("Error!!",$lable->_("Cannot find basket!"));	
			return;
		}
		
		while(!$rs->EOF){
			$key=$rs->fields("id");
			$arr_order[$key]["price"] = $arr[$key]["quantity"] * $rs->fields("price");
			$total=$total+$arr_order[$key]["price"];				
			$rs->MoveNext();
		}
	///
	}else{
		$str=$lable->_("0");
	}
	$str=$count_basket;
	$smarty->assign('str',$str);
	$smarty->assign('total',$total);
	$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/basket_count.tpl");
	echo $output;
?>