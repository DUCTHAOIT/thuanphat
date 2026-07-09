<?php	
	
	$idworldwide=getParam(id);		
	if($idworldwide) $op="detail"	;	
	
	switch($op){
		case "detail"	:	include_once "header.php";
							worldwideDetail();
							include_once "footer.php";
							break;
		case "search"	:	worldwideList(); break;
		default			:	mainShow(); break;
					
	}
	function mainShow(){
		include_once "header.php";
		global $smarty,$lang;
		
		$idF=getparamFID(getParam(idF),false);
		
		$topicName=getFunctionNameID($idF);
		$arrTopicWorldwide=getTopicWorldwide();
		$smarty->assign('name',getFunctionNameID($idF));
		$smarty->assign('idF',$idF);
		$smarty->assign('lang',$lang);		
		$smarty->assign('topicName',$topicName);
		$smarty->assign('url',$arr_info_page["url"]);	
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->registerPlugin("function","worldwideList", "worldwideList");
		
		$smarty->assign('arrTopicWorldwide',$arrTopicWorldwide);	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwide.tpl','worldwide_');
		include_once "footer.php";		
	}
	//
	function worldwideList(){
		global $smarty,$lable,$lang, $arr_info_page;			
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=1000;
		
		$idF=getparamFID(getParam(idF),false);		
		
		$arr=worldwideListID($idF);				
		$numberRecord=count($arr);
		
		$smarty->assign('arr',$arr);		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);
			
		$url= $arr_info_page["url"];	
	
		$smarty->assign('Detail',$lable->_("Detail"));		
		$smarty->assign('url',$url);
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwideList.tpl','worldwideList_'.$fid);	
	
	}
	function worldwideDetail(){
		global $smarty,$lable,$themeName;		
		
		//$idF=getParam("idF");
		$idF=getparamFID(getParam(idF),false);	
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$idworldwide=getParam(id);
		$arr=worldwideID($idworldwide);		
		//$arrFaq=getworldwideListFaq($arr["id"]);

		$smarty->assign('name',getFunctionNameID($idF));
		$smarty->assign('Print',$lable->_("Print"));
		$smarty->assign('Contact',$lable->_("Contact"));
		
		$smarty->assign('email',getSession("email"));		
		$smarty->assign('arr',$arr);		

		$smarty->assign('idworldwide',$idworldwide);		
				
		$smarty->assign('Price',$lable->_("Price"));	
		$smarty->assign('Access_number',$lable->_("Access number"));
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Maker',$lable->_("Maker"));
		$smarty->assign('Serial',$lable->_("Serial"));
		$smarty->assign('Year',$lable->_("Year"));
		$smarty->assign('State',$lable->_("State"));
		$smarty->assign('Related_Projects',$lable->_("Related Projects"));
		$smarty->assign('ymsupport',getSession("ymsupport"));
		$smarty->assign('Comment',$lable->_("Comment"));
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Address',$lable->_("Address"));

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/worldwideDetail.tpl','worldwideDetail_'.$idworldwide);
	}
	//	
?>