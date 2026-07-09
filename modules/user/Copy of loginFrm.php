<?php
	function loginFrm(){	
		global $smarty,$lable, $themeName,$db,$lang,$moduleName;
		$lable->language("user");
			
		if(!getSession("username")){			
			
			$smarty->assign('Login',$lable->_("Login"));
			$smarty->assign('theme',$themeName);
			$smarty->assign('lang',$lang);
			$smarty->assign('Forget_password',$lable->_("Forget password"));		
			$smarty->assign('Choose_password',$lable->_("Choose a password"));
			$smarty->assign('Username',$lable->_("User name"));		
			
			$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userLogin.tpl','userLogin_');
		}else{				
			
			$smarty->assign('arr',$arr);
			$smarty->assign('lang',$lang);
			$smarty->assign('Hello',$lable->_("Hello"));
			$smarty->assign('username',getSession("username"));
			$smarty->assign('Member_information',$lable->_("Member information"));
			$smarty->assign('Product_list', $lable->_("Product list"));
			$smarty->assign('Logout', $lable->_("Logout"));		
			
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userFunction.tpl','userFunction_');
		}
		$lable = new language($moduleName);
	}	
?>