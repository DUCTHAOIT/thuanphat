<?php
	switch($op){
		case "detail"	:	include_once "header.php";
							documentDetail();
							include_once "footer.php";
							break;
		case "search"	:	downloadList();break;
		default			:	mainShow();break;
					
	}
	function mainShow(){
		include_once "header.php";
		global $smarty,$lang;

		$fid=getparamFID(getParam("idF"),false);		
			
		$smarty->assign('nameFun',getFunctionNameSub($fid));		
		$smarty->assign('lang',$lang);
		$smarty->assign('fid',getParam(_MARK));
			
		$smarty->registerPlugin("function","downloadList", "downloadList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/download.tpl','download_');
		include_once "footer.php";
	}
	//	
	function downloadList(){		
		global $smarty;
		//$fid=getParam("idF");
		$fid=getparamFID(getParam("idF"),false);
		
		$arr=getDownloadList($fid);
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/downloadList.tpl','downloadList_'.$fid);
	}	
?>