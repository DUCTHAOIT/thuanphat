<?php 
	function weblink(){
		global $db, $lang,$smarty,$lable;
		$sql="SELECT * FROM sys_weblink WHERE ctrl&1=1 ORDER BY no";
		$arr=$db->GetAssoc($sql);
		if(!$arr) return;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('Weblink',$lable->_("Weblink"));
			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/weblink.tpl','weblink_');

	}
?>