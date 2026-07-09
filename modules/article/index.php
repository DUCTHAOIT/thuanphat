<?php
	$idArticle=getParam(id);		
	if($idArticle) $op="detail"	;	
	switch($op){
		case "detail"	:	include_once "header.php";
							articleDetail();
							include_once "footer.php";
							break;
		case "search"	:	articleList(); break;
		case "insertFaqarticle"	:	insertFaqarticle(); break;
		default			:	mainShow(); break;
					
	}
	function mainShow(){
		include_once "header.php";
		global $smarty,$lang, $themeName;
		include_once("modules/control/photoHome.php");
				
		
		$idF=getparamFID(getParam(idF),false);	
		$topicName=getFunctionNameID($idF);
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('themeName',$themeName);	
		$smarty->assign('lang',$lang);		
		$smarty->assign('topicName',$topicName);
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->assign('name',getFunctionNameID($idF));	
		$smarty->registerPlugin("function","articleList", "articleList");	
		$smarty->registerPlugin("function","photoHome", "photoHome");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/article.tpl','article_');
		include_once "footer.php";		
	}
	//
	function articleList(){
		global $smarty,$lable,$lang, $arr_info_page, $themeName;			
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=6;
		
		$idF=getparamFID(getParam(idF),false);	
			
		$arr=articleListID($idF);				
		$numberRecord=count($arr);
		
		$smarty->assign('arr',$arr);		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);
		$smarty->assign('themeName',$themeName);		
		$url="?m=article&"._MARK."=".$fid;		
		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleList.tpl','articleList_'.$fid);	
	
	}
	function articleDetail(){
		global $smarty,$lable,$themeName;		
		
		//$idF=getParam("idF");
		$idF=getparamFID(getParam(idF),false);	
		
		//$idArticle=getParam(_ID_ARTICLE);		
		$idArticle=getParam(id);		
		$arr=articleID($idArticle);		
		$arrFaq=getArticleListFaq($arr["id"]);
		
		$arrrelation=articleListRe($idF);
		
		$smarty->assign('Print',$lable->_("Print"));
		$smarty->assign('Contact',$lable->_("Contact"));
		
		$smarty->assign('nameFun',getFunctionNameSub($idF));	
		$smarty->assign('email',getSession("email"));		
		$smarty->assign('arr',$arr);		
		$smarty->assign('arrFaq',$arrFaq);
		$smarty->assign('arrrelation',$arrrelation);
		$smarty->assign('idArticle',$idArticle);		
				
		$smarty->assign('name',getFunctionNameID($idF));
		$smarty->assign('themeName',$themeName);
		
		$smarty->assign('Price',$lable->_("Price"));	
		$smarty->assign('Access_number',$lable->_("Access number"));
		$smarty->assign('Product_name',$lable->_("Product name"));
		$smarty->assign('Maker',$lable->_("Maker"));
		$smarty->assign('Serial',$lable->_("Serial"));
		$smarty->assign('Year',$lable->_("Year"));
		$smarty->assign('State',$lable->_("State"));
		$smarty->assign('Relatednews',$lable->_("Related news"));
		$smarty->assign('ymsupport',getSession("ymsupport"));
		$smarty->assign('Comment',$lable->_("Comment"));
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Address',$lable->_("Address"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleDetail.tpl','articleDetail_'.$idArticle);
	}
	//	
	function insertFaqarticle(){
		
		global $db,$lang;	
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");	
		$email=getParamPost("email");	
		$address=getParamPost("address");
		$question=getParamPost("question");	
		$proid=getParamPost("proid");		
		$chatluong=getParamPost("chatluong");
		$hinhdang=getParamPost("hinhdang");	
		$gia=getParamPost("gia");		
		
		$record=array();
		$record["name"]=$name;
		$record["email"]=$email;
		$record["address"]=$address;
		$record["question"]=$question;
		$record["proid"]=$proid;		
		$record["chatluong"]=$chatluong;
		$record["hinhdang"]=$hinhdang;
		$record["gia"]=$gia;
		$record["lang"]=$lang;		
		
		$sql = "SELECT * FROM sys_commentarticle WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);
		
		
		//////	
		if(!$return){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"color:#016434; padding:40px; padding-top:80px\" align=\"center\">Có lỗi sảy ra!</td>
				  </tr>				 
				</table>";
		}else{
			if($lang=='vn'){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"padding:40px; padding-top:80px\" align=\"center\">Cám ơn nhận xét của quý khách. Nhận xét sẽ hiển thị sau khi được thông qua.</td>
				  </tr>				  
				</table>";
			}else{
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"padding:40px; padding-top:80px\" align=\"center\">We have received your comment! Thank you!</td>
				  </tr>				  
				</table>";
			}	
		}	
	}
?>