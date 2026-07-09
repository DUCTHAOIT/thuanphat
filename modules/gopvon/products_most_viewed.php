<?php
	function products_most_viewed()
	{
		global $db, $smarty, $lable, $arr_info_page;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.ctrl&1=1) AND (sys_product.access > 1)";
		$sql.=" ORDER BY access DESC";
		
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=5;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign("Products_most_viewed",$lable->_("Products most viewed"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_most_viewed.tpl','product_most_viewed.tpl_');
	}
?>