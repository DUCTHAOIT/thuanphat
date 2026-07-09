<?php
	$moduleName="member";
	include_once("modules/member/action.php");
	switch ($op){
		case "mModify": mModify(); break;		
		default: mainShow(); break;
	}
	//
	 function mainShow(){
	 	global $db, $smarty, $moduleName, $lable; 	 	
	 	include_once("header.php");
	 	$lable->language($moduleName);
	 	
	 	$memberID=getParam("id");
	 	if($memberID) $arr=getMemberID($memberID);
	 	
	 	$smarty->assign('arr',$arr);
	 	$smarty->assign('memberID',$memberID);	 	
	 	
	 	$smarty->assign('Email',$lable->_("Email"));
	 	$smarty->assign('Password',$lable->_("Password"));
	 	$smarty->assign('Re_password',$lable->_("Re-enter password"));
	 	$smarty->assign('First_name',$lable->_("First name"));
	 	$smarty->assign('Last_name',$lable->_("Last name"));
	 	$smarty->assign('Address',$lable->_("Address"));
	 	$smarty->assign('Mobile',$lable->_("Mobile"));
	 	$smarty->assign('Birthday',$lable->_("Birthday"));
	 	$smarty->assign('Update',$lable->_("Update"));
	 	$smarty->assign('Member_create',$lable->_("Member create"));
	 	//$smarty->assign('',$lable->_(""));	 	
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/controlMyAccount.tpl','controlMyAccount_'.$memberID);	
	 	include_once("footer.php");
	 }
	 //
	 function mModify(){
	 	global $db;
	 	$memberID=getParamPost("id");
	 	
	 	$email=getParamPost("txt_email");
	 	$password=getParamPost("txt_password");
	 	$fistname=getParamPost("txt_fistname");
	 	$lastname=getParamPost("txt_lastname");
	 	$address=getParamPost("txt_address");
	 	$mobile=getParamPost("txt_mobile");
	 	 	

	 	$record=array();
	 	$record["email"]=$email;
	 	if($password) $record["password"]=md5($password);
	 	$record["fistname"]=$fistname;
	 	$record["lastname"]=$lastname;
	 	$record["address"]=$address;
	 	$record["mobile"]=$mobile;	 	 	
	 		 		
 		$sql = "SELECT * FROM sys_member WHERE id=$memberID";
		$rs = $db->Execute($sql);						
		$sql = $db->GetUpdateSQL($rs, $record);
		$return=$db->Execute($sql);	
	 	
	 	
	 	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	 	if($return){			
	 		$ret_page="?";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
	 	}else{
	 		$ret_page="?m=control&f=my_account&id=$memberID";
	 		$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
	 	}
	 	$a->showMsg();
	 }
?>