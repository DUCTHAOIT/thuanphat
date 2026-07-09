<?php
	switch ($op){		
		case "update": Update(); break;
		case "delete": callDeleteFunction(); break;
		default:mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lang;	
		$id=getParam("id");
		$smarty->assign('id',$id);
		$smarty->assign('infoFunc',getFunctionID($id));
		
		$smarty->assign('themeName',$themeName);
		$smarty->assign('lang',$lang);				
		$smarty->assign('Function_name',$lable->_("Function name"));
		$smarty->assign('Function_url',$lable->_("Function url"));
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Article',$lable->_("Article"));
		$smarty->assign('Project',$lable->_("Project"));
		$smarty->assign('Contact',$lable->_("Contact"));
		$smarty->assign('Faq',$lable->_("Faq"));
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('HTML',$lable->_("HTML"));
		$smarty->assign('Url_input',$lable->_("Url input"));
		$smarty->assign('Order',$lable->_("Order"));
		$smarty->assign('Action',$lable->_("Action"));
		$smarty->assign('Security',$lable->_("Security"));
		$smarty->assign('Language',$lable->_("Language"));
		$smarty->assign('Show_position',$lable->_("Show position"));
		$smarty->assign('Photo_big_size',$lable->_("Photo big size"));
		$smarty->assign('Partner',$lable->_("Partner"));
		//$smarty->assign('',$lable->_(""));
		//$smarty->assign('',$lable->_(""));
		
		$arrPosition=getPosition();
		$smarty->assign('arrPosition',$arrPosition);
		
		$arr=getFunctionList();		
		$smarty->assign('arr',$arr);
		$smarty->assign('functionList',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/functionList.tpl"));
		
		$smarty->assign('Update',$lable->_("Update"));		
		
		$smarty->registerPlugin("function","getCboPosition", "getCboPosition");
		$smarty->registerPlugin("function","getCboFunction", "getCboFunction");	
		
		$smarty->registerPlugin("function","viewFckeditor", "viewFckeditor");	
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/fucntionMain.tpl','fucntionMain_'.$themeName);	
		include_once("footer.php");
	}	
	//
	function callDeleteFunction(){
		$id=getParam("id");
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=function";
		if(deleteFunction($id)){			
			$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$a=new msgBox(_NO_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();
	}
?>