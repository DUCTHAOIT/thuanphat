<?php
	function slideproduct()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$idF=getparamFID(getParam(idF),false);	
		
		//$product_id=getParam(_ID_PRODUCT);
		
		$product_id=getParam(id);
		if(!$product_id) return;	
		$arr=get_product_id_slide($product_id);
		$arrColor=getProductListPhotoslide($arr["id"]);	
		
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('view360',$arr["promotion"]);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_slide.tpl','product_slide_');
	}
	function get_product_id_slide($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.alias='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	function getProductListPhotoslide($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
?>