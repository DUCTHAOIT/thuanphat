<?php	
	switch($op){
		case "detail"			: detailBasket();break;	
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable, $db;
		$username=getSession("username");
		$sql="SELECT * FROM user WHERE username='$username'";
		$rs = $db->Execute($sql);
		$fullname = $rs->fields("firstname")." ". $rs->fields("lastname");
				
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$numberRecord=count(getBasketList("all"));		
		$arr=getBasketList("limit",$pageID);
		
		$smarty->assign('Hello',$lable->_("Hello"));
		
		$smarty->assign("arr",$arr);
		$smarty->assign("fullname",$fullname);
		$smarty->assign("sPage",sPage("?m=basket", $numberRecord, 15, $pageID, $add_prevnext_text = TRUE));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basketUser.tpl','basketUser_');		
		include_once("footer.php");
	}	
	//
	function detailBasket(){
		include_once("header.php");
		global $smarty,$db;
		
		$username=getSession("username");
		$sql="SELECT * FROM user WHERE username='$username'";
		$rs = $db->Execute($sql);
		$fullname = $rs->fields("firstname")." ". $rs->fields("lastname");
		
		$id=getParam("id");
		$arr=getDetailBasket($id);
		
		$smarty->assign('Hello',$lable->_("Hello"));
				
		$smarty->assign("arr",$arr);
		$smarty->assign("fullname",$fullname);
		$smarty->assign("basketID",$id);
		$smarty->registerPlugin("function","format_number","format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basketUserDetail.tpl','basketUserDetail_');
		include_once("footer.php");
	}
?>