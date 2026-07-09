<?php
switch($op){
		case "changepassword": 	changepassword(); break;
		default			:	mainShow(); break;
					
	}
function mainShow(){		
	include_once "header.php";
		global $smarty,$lable, $themeName,$db,$lang,$moduleName;
		if(!getSession("username")) return;
		global $smarty,$lang,$lable;
		$smarty->assign("Forget_password",$lable->_("Forget password"));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userChangePassword.tpl','userChangePassword_');
	include_once "footer.php";	
}
//
function changepassword(){
	include_once("header.php");
	global $db, $lable;
	$username=getSession("username");
	if(!$username) return;
	$txtPasswordOld=getParamPost("txtPasswordOld");
	$txtPassword=getParamPost("txtPassword");
	
	$sql="SELECT * FROM user WHERE (email='$username') AND password=md5('$txtPasswordOld') AND (ctrl&1=1)";
	$rs=$db->Execute($sql);	
	if($rs->fields("email")){		
		$sql="UPDATE user SET password='".md5($txtPassword)."' WHERE (email='$username') AND (password='".md5($txtPasswordOld)."')";	
		$return=$db->Execute($sql);	
		//setSession("username","");
		setSession("ret_page","");
		header("Location: ?");		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?";
		$a=new msgBox("Mật khẩu đã được thay đổi thành công","OKOnly", "Message", array($ret_page), 3);			
		$a->showMsg();
					
	}else{
		setSession("ret_page","");
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="../change_password/";
		$a=new msgBox("Mật khẩu cũ không đúng!","OKOnly", "Message", array($ret_page), 5);
		$a->showMsg();
	}		
	include_once("footer.php");
}
	
?>