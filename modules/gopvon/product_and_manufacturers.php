<?php
	//
	//hien thi san pham cung hang dang xem
	//
	global $smarty;	
	$product_id=getParam("product_id");
		
	$arr=get_product_and_manufacturers($product_id);
	
	if(!$arr) return;
	
	$smarty->assign('arr',$arr);
	
	$smarty->assign('Products_and_manufacturers',$lable->_("Products and manufacturers"));
	$smarty->assign('Price',$lable->_("Price"));
	$smarty->assign('Products_sold_in',$lable->_("Products sold in"));
	$smarty->assign('Promotion',$lable->_("Promotion"));
	$smarty->assign('Delivery',$lable->_("Delivery"));
	
	$smarty->registerPlugin("function","box_block_title", "box_block_title");
	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_and_manufacturers.tpl','product_and_manufacturers_');
?>