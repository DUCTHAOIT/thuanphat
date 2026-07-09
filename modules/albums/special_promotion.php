<?php
	function special_promotion()
	{
		global $db, $smarty, $lable, $arr_info_page;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.hang_san_xuat =  hang_san_xuat.id) AND (sys_product.ctrl&1=1) AND (sys_product.special_promotion=1)";
		$sql.=" ORDER BY today DESC";
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=8;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign("Special_promotion",$lable->_("Special promotion"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_special_promotion.tpl','product_special_promotion_');
	}
?>