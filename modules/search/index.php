<?php 
	switch ($op){				
		default	: 		include_once("header.php");
						mainShow();
						include_once("footer.php");
						break;
		
	}
	//
	function mainShow(){
		global $themeName, $smarty, $lable;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=24;
		
		$arr=getProductSearch();
		
		$numberRecord=count($arr);
		
		$ret_page=$_SERVER['QUERY_STRING'];
		
		$smarty->assign('url_sort_by',_DOMAIN_ROOT_URL."/?".$ret_page);
	
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		$smarty->assign('tieude',$lable->_("Results"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Detail"));
		
		$smarty->assign('Compare',$lable->_("Compare"));		
		$smarty->assign('Sort_by',$lable->_("Sort by"));
		
		$smarty->assign('Price_low_to_high',$lable->_("Price low to high"));
		$smarty->assign('Price_high_to_low',$lable->_("Price high to low"));
		$smarty->assign('New_products',$lable->_("New products"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		//$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list.tpl','product_list_');
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productSearch.tpl','productSearch_'.$themeName);		
	}
	//
?>