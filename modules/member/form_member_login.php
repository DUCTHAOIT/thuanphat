<?php
function form_member_login(){
	global $smarty,$themeName,$lable;
	$lable->language("member");
	
	$smarty->assign("Sign_up",$lable->_("Sign up"));
	$smarty->assign("Sign_in",$lable->_("Sign in"));	
	$smarty->assign("Forgot_password",$lable->_("Forgot password"));	
	$smarty->assign("Login",$lable->_("Login"));
	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/member_login.tpl','member_login_');
}
?>