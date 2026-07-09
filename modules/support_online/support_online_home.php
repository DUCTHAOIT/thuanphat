<?php
		
		global $smarty,$lable,$themeName,$lang;
		//$email=getSession("email");		
		//$tel=getSession("tel");		
		$sql="SELECt * FROM support_online WHERE ctrl&1=1 AND lang='$lang' ORDER BY `no` ASC";	
		$arr=$db->GetAssoc($sql);
		foreach ($arr as $key=>$value){			
				$arr[$key]["nick"]=$value["nick"];
				$arr[$key]["tel"]=$value["tel"];
				$arr[$key]["yahoo"]=$value["yahoo"];
				$arr[$key]["skype"]=$value["skype"];	
				//$arr[$key]["online"]=getSkypeStatus($value["skype"]);						
		}
		
		$smarty->assign('themeName',$themeName);
		$smarty->assign('SupportOnline',$lable->_("SupportOnline"));
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/support_online_view_home.tpl','support_online_view_home_');	
	
		function getSkypeStatus($username) { 
			$data = file_get_contents('http://mystatus.skype.com/' . urlencode($username) . '.xml'); 			 
			return strpos($data, '<presence xml:lang="en">Offline</presence>') ? 'Offline' : 'Online'; 
			
		} 
?>