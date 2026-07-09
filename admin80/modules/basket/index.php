<?php	
	switch($op){
		case "detail"			: detailBasket();break;	
		case "lockBasket"		: lockBasket();break;
		case "pDelete"			: BasketDelete();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$numberRecord=count(getBasketList("all"));		
		$arr=getBasketList("limit",$pageID);
		
		$smarty->assign("arr",$arr);
		$smarty->assign("sPage",sPage("?m=basket", $numberRecord, 15, $pageID, $add_prevnext_text = TRUE));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket.tpl','basket_');		
		include_once("footer.php");
	}	
	//
	function detailBasket(){
		include_once("header.php");
		global $smarty, $db;
		$id=getParam("id");
		$user=getParam("user");
		
		$arr=getDetailBasket($id);
		
		$sqlUser="SELECT * FROM user WHERE email = '".$user."'";
		$rs = $db->Execute($sqlUser);	
		//echo $sqlUser;
		$arrUser=$rs->fields;	
		
		$smarty->assign('Shipping_Address',$lable->_("Shipping Address"));
		$smarty->assign('Fullname',$lable->_("Fullname"));
		$smarty->assign('Telephone',$lable->_("Telephone"));
		$smarty->assign('Company_Name',$lable->_("Company Name"));
		$smarty->assign('Street_Address',$lable->_("Street Address"));
		$smarty->assign('Postcode',$lable->_("Postcode"));
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('City_Province_Country',$lable->_("City - Province - Country"));
		
		$smarty->assign("arrUser",$arrUser);
		$smarty->assign("arr",$arr);
		$smarty->assign("basketID",$id);
		$smarty->registerPlugin("function","format_number","format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basketDetail.tpl','basketDetail_');
		include_once("footer.php");
	}
	//	 
	function lockBasket(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_order SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_order WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function BasketDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_order WHERE id=$id";		
		$db->Execute($sql);
		header("Location: ?m=basket");
	}		
?>