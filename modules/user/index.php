<?php	
	switch($op){
		case "register"	:	createRegister(); break;
		case "forget"	:	forgetPassword(); break;
		case "randPasword": randPasword(); break;
		case "login"	: 	userLogin(); break;
		case "logout"	: 	userLogout(); break;
		case "iMember"	:	infoMember();break;
		case "changeInfo": 	changeInfo(); break;
		default			:	mainShow(); break;
					
	}
	function mainShow(){
		$username=getSession("username");
		$urlre=_DOMAIN_ROOT_URL."/user_dashboard/";
		if($username){ header('Location: '.$urlre.'');}
        include_once "header.php";
		global $smarty,$lang,$lable;
		
		$gioithieu=getParam("aff");
        $tennguoigiothieu=getUsersID($gioithieu,"name");

		$smarty->registerPlugin("function","chinhsach", "chinhsach");
		$smarty->assign('lang',$lang);
		$smarty->assign('gioithieu',$gioithieu);
        $smarty->assign('tennguoigiothieu',$tennguoigiothieu);
		
		$smarty->assign('ret_page',getParam("ret_page"));
		
		$smarty->assign('Register_info',$lable->_("Register info"));
		$smarty->assign('User_name',$lable->_("User name"));
		$smarty->assign('Email',$lable->_("Email"));
		$smarty->assign('Choose_password',$lable->_("Choose a password"));
		$smarty->assign('enter_password',$lable->_("Re-enter password"));
		$smarty->assign('Register',$lable->_("Register"));
		
		$smarty->assign('Info_user',$lable->_("Info user"));
		$smarty->assign('First_name',$lable->_("First name"));
		$smarty->assign('Last_name',$lable->_("Last name"));
		$smarty->assign('Street_address',$lable->_("Street address"));
		$smarty->assign('Company_name',$lable->_("Company name"));
		$smarty->assign('Telephone',$lable->_("Telephone"));
		$smarty->assign('Fax',$lable->_("Fax"));
		$smarty->assign('Post_code',$lable->_("Post code"));
		$smarty->assign('City',$lable->_("City"));
		$smarty->assign('Province',$lable->_("Province"));
		$smarty->assign('Date_of_birth',$lable->_("Date of birth"));
		$smarty->assign('Info_access',$lable->_("Info access"));
		$smarty->assign('Country',$lable->_("Country"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userRegister.tpl','userRegister_');
		include_once "footer.php";		
	}	
	//
	function forgetPassword(){
		include_once "header.php";
		global $smarty,$lang,$lable;
		
		$smarty->assign('Register_email',$lable->_("Register email"));
		$smarty->assign('Username',$lable->_("User name"));
		$smarty->assign("Forget_password",$lable->_("Forget password"));
		$smarty->assign('Register',$lable->_("Register"));
		$smarty->assign('Zuschike',$lable->_("Zuschike"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userForgetPassword.tpl','userForgetPassword_');
		include_once "footer.php";	
	}
	function userLogout(){
		global $lable;
		setSession("username","");
		setSession("ret_page","");		
		setcookie( "affiliate_id", "", time()- 60, "/","", 0);
		header("Location: ?");		
		//include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		//$ret_page="?";
		//$a=new msgBox($lable->_("Exit system"),"OKOnly", "Message", array($ret_page), 1);			
		//$a->showMsg();
	}
	//
	//
	function infoMember(){
		include_once "header.php";
		global $smarty,$lang,$lable;
		$username=getSession("username");
		if(!$username) return;
		include_once("modules/user/usermenu.php");
		$smarty->registerPlugin("function","usermenu2","usermenu2");	
			
		$arr=getMemberID($username);
		$smarty->assign('arr',$arr);
		$smarty->assign('Member_information',$lable->_("Member information"));
		$smarty->assign('User_name',$lable->_("User name"));
		$smarty->assign('Email',$lable->_("Email"));
		$smarty->assign('Choose_password',$lable->_("Choose a password"));
		$smarty->assign('enter_password',$lable->_("Re-enter password"));
		$smarty->assign('Register',$lable->_("Register"));
		
		$smarty->assign('Info_user',$lable->_("Info user"));
		$smarty->assign('First_name',$lable->_("First name"));
		$smarty->assign('Last_name',$lable->_("Last name"));
		$smarty->assign('Street_address',$lable->_("Street address"));
		$smarty->assign('Company_name',$lable->_("Company name"));
		$smarty->assign('Telephone',$lable->_("Telephone"));
		$smarty->assign('Fax',$lable->_("Fax"));
		$smarty->assign('Post_code',$lable->_("Post code"));
		$smarty->assign('City',$lable->_("City"));
		$smarty->assign('Province',$lable->_("Province"));
		$smarty->assign('Date_of_birth',$lable->_("Date of birth"));
		$smarty->assign('Info_access',$lable->_("Info access"));
		$smarty->assign('Country',$lable->_("Country"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userInfoMember.tpl','userInfoMember_');
		include_once "footer.php";
	}
	//
	//
	function chinhsach(){
		global $smarty,$db,$themeName,$lable,$lang;		
		
		if($lang=='vn'){
			$id=7;
		}else{
			$id=7;
		}
		$sql="SELECT * FROM sys_htmlpage WHERE (ctrl&1=1) AND (id=$id)";		
		$rs=$db->Execute($sql);
		
		if($lang=='vn'){
			//$about=strstrim($rs->fields("content"),100);
			$about=$rs->fields("content");
		}else{
			$about=strstrim($rs->fields("content"),100);
		}
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('About_us',$lable->_("About us"));		
		$smarty->assign('about',$about);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/chinhsach.tpl','chinhsach_'.$themeName);
	}
	//
	//
?>