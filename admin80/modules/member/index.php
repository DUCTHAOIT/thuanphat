<?php
	switch ($op){
		case "frmCreate": frmCreate(); break;
		case "mCreate"	: memberCreate(); break;
		case "lockMember": lockMember(); break;
		case "mDelelte": memberDelete(); break;
		default: mainShow(); break;
	}
	//
	 function mainShow(){
	 	global $smarty,$lable; 
	 	include_once("header.php");	 	
	 	$smarty->assign('Member_create',$lable->_("Member create"));
	 	$smarty->registerPlugin("function","memberList","memberList");
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/member.tpl','member');	
	 	include_once("footer.php");
	 }
	 //
	 function memberList(){
	 	global $smarty, $themeName, $lable; 
	 	$arr=getMemberList();	 	
	 	$smarty->assign('arr',$arr);
	 	
	 	$smarty->assign('Email',$lable->_("Email"));
	 	$smarty->assign('Last_name',$lable->_("Last name"));
	 	$smarty->assign('Mobile',$lable->_("Mobile"));
	 	$smarty->assign('Address',$lable->_("Address"));
	 	$smarty->assign('Number_access',$lable->_("Number access"));
	 	$smarty->assign('Status',$lable->_("Status"));
	 	$smarty->assign('Cannot_member',$lable->_("Cannot member"));
	 	$smarty->assign('No',$lable->_("No."));	 		 	
	 	
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/memberList.tpl','memberList_'.$themeName);
	 }
	 //
	 function frmCreate(){
	 	global $db, $smarty, $themeName, $lable; 
	 	include_once("header.php");
	 	$memberID=getParamPost("id");
	 	if($memberID) $arr=getMemberID($memberID);
	 	
	 	$smarty->assign('arr',$arr);
	 	$smarty->assign('memberID',$memberID);
	 	//$smarty->assign('permit',getPermit());	 	
	 	
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
	 	$smarty->assign('List_of_rights',$lable->_("List of rights"));
	 	$smarty->assign('Change_password',$lable->_("Change password"));
	 	
	 	$smarty->registerPlugin("function","getPermit","getPermit");
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/memberCreate.tpl','memberCreate_'.$themeName);	
	 	include_once("footer.php");
	 }
	 
?>