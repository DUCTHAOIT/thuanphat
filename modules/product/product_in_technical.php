<?php
	//
	// hien thi san pham cung thong so ky thuat
	//
	global $smarty;	
	$product_id=getParam("product_id");
	
	// Thong tin san pham dang xem
	$info_product=get_product_id($product_id);
	
	$arr=explode(":", $info_product["search_criteria"]);
		
	if(count($arr)>1){		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Products_sold_in',$lable->_("Products sold in"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->registerPlugin("function","box_block_title", "box_block_title");
		foreach($arr as $key=>$value)
		{	
			if(((int)$value > 0))
			{
				
				$arr=get_product_in_technical($product_id,$value);
				if($arr)
				{
					$smarty->assign('title',$lable->_("Product"). " ". $arr[0]["name_hsx"]);
					
					$smarty->assign('arr',$arr);				
					$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_in_technical.tpl','product_in_technical_');				
				}
			}
		}		
	}	
?>