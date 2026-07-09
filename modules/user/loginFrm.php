<?php	
	function loginFrm(){	
		global $smarty,$lable, $themeName,$db,$lang,$moduleName;
		
		$MemberID=getParam("id");
		if($MemberID){
			$sql="SELECT * FROM user WHERE id='".$MemberID."'";	
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign('arr',$arr);
			$smarty->assign('lang',$lang);								
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userFunctionLeftPost.tpl','userFunctionLeftPost_');
		}else{
			$username=getSession("username");
			global $db, $lable;
			
			$sql="SELECT * FROM user WHERE username='".getSession("username")."'";		
			$rs = $db->Execute($sql);	
			
			$smarty->assign('name',$rs->fields("firstname")." ". $rs->fields("lastname"));	
				
			$smarty->assign('arr',$arr);
			$smarty->assign('lang',$lang);
			$smarty->assign('Hello',$lable->_("Hello"));
			$smarty->assign('username',getSession("username"));
			$smarty->assign('Member_information',$lable->_("Member information"));
			$smarty->assign('Product_list', $lable->_("Product list"));
			$smarty->assign('Logout', $lable->_("Logout"));								
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userFunctionLeft.tpl','userFunctionLeft_');
		}
	}	
?>