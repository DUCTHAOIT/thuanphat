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
		$limit=6;
				
		$arr=articleListSearch();
		$numberRecord=count($arr);		
	//	print_r($arr);		
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
			
		$smarty->assign('Results',$lable->_("Results"));		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Detail"));
				
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$_SERVER['QUERY_STRING'],$numberRecord,$limit,$pageID));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleList.tpl','articleList_'.$themeName);		
	}
	//
?>