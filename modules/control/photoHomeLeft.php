<?php 
	function photoHomeLeft(){
		global $db,$smarty,$lang,$lable;
		$sql="SELECT sys_photo.*, sys_function.htaccess as url";
		$sql.=" FROM sys_photo, sys_photo_cat, sys_function";
		$sql.=" WHERE (sys_photo.ctrl&1=1) AND (sys_photo.focus=1)  AND (sys_photo.parent='0') AND (sys_function.id=sys_photo_cat.catID) AND (sys_photo.id=sys_photo_cat.artID)";
		$sql.=" ORDER BY `no` ASC LIMIT 0,2";		
		$arr=$db->getAssoc($sql);		
		if(!$arr){ return;}		
		$smarty->assign('arr', $arr);	
		$smarty->assign('Gallery',$lable->_("Gallery"));	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoHome.tpl','photoHome_');
		
	}
	//
?>