<?php 
	switch ($op){				
		default	: 		include_once("header.php");
						mainShow();
						include_once("footer.php");
						break;
		
	}
	//
	function mainShow(){
		global $smarty,$lable,$lang, $arr_info_page;			
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=5;	
		if($lang=='vn'){
			$info_page="trang-chu/tin-tuc/";
		}else{
			$info_page="trang-chu/news/";
		}				
		$arr=articleListSearch();
		$numberRecord=count($arr);
		
		
		$smarty->assign('NotFound',$lable->_("Not Found"));
		$smarty->assign('Results',$lable->_("Results"));
		$smarty->assign('arr',$arr);		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);
		$smarty->assign('numberRecord',$numberRecord);
		
			
		$url="?m=article&"._MARK."=".$fid;		
		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$info_page,$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleSearch.tpl','articleSearch_'.$fid);		
	}
	//
?>