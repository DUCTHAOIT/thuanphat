<?php		
	$idpartner=getParam(id);		
	if($idpartner) $op="detail"	;	
	
	switch($op){
		case "detail"	:	include_once "header.php";
							partnerDetail();
							include_once "footer.php";
							break;
		case "search"	:	partnerList(); break;
		default			:	mainShow(); break;
					
	}
	function mainShow(){
		include_once "header.php";
		global $smarty,$lang;
		
		$idF=getparamFID(getParam(idF),false);		
		$topicName=getFunctionNameID($idF);
		$smarty->assign('des',getFunctionNameID($idF,"des"));
		$smarty->assign('name',getFunctionNameID($idF));
		$smarty->assign('lang',$lang);		
		$smarty->assign('topicName',$topicName);	
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->registerPlugin("function","partnerList", "partnerList");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partner.tpl','partner_');
		include_once "footer.php";		
	}
	//
	function partnerList(){
		global $smarty,$lable,$lang, $arr_info_page;			
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=20;
		
		$idF=getparamFID(getParam(idF),false);		
			
		$arr=partnerListID($idF);				
		$numberRecord=count($arr);
		
		$smarty->assign('arr',$arr);		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);
			
		$url="?m=partner&"._MARK."=".$fid;	
		
		$smarty->assign('Detail',$lable->_("Detail"));		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partnerList.tpl','partnerList_'.$fid);	
	
	}
	function partnerDetail(){
		global $smarty,$lable,$themeName;		
		
		//$idF=getParam("idF");
		$idF=getparamFID(getParam(idF),false);	
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$idpartner=getParam(id);		
		$arr=partnerID($idpartner);		
		$arrFaq=getpartnerListFaq($arr["id"]);
		$arrrelation=partnerListID($idF);
		
		$topicName=getFunctionNameID($idF);
		$smarty->assign('name',getFunctionNameID($idF));
		$smarty->assign('topicName',$topicName);
		$smarty->assign('Print',$lable->_("Print"));
		$smarty->assign('Contact',$lable->_("Contact"));
		
		$smarty->assign('email',getSession("email"));		
		$smarty->assign('arr',$arr);		
		$smarty->assign('arrFaq',$arrFaq);
		$smarty->assign('arrrelation',$arrrelation);
		$smarty->assign('idpartner',$idpartner);		
				
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partnerDetail.tpl','partnerDetail_'.$idpartner);
	}
	//	
?>