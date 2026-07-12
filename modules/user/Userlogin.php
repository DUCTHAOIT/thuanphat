<?php	
		include_once "header.php";
		global $smarty,$lable, $themeName,$db,$lang,$moduleName;
		$ret_page = $_SERVER['HTTP_REFERER'];
		if(getSession("username")){	
			header("Location: ../");
			exit;
		}else{
			$smarty->assign('Login', $lable->_("Login"));
			$smarty->assign('ret_page',$ret_page);
			//$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/bakestLogin.tpl','bakestLogin_');
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userFrmLogin.tpl','userFrmLogin_');
		}
		
		include_once "footer.php";	
?>