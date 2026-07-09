<?php 
	function projectfocus(){
		global $db, $lang,$smarty,$lable;
		$sql="SELECT sys_partner.id,sys_partner.name,sys_partner.alias,sys_partner.img,sys_partner_cat.catID,sys_function.htaccess FROM sys_partner_cat,sys_partner,sys_function WHERE (sys_partner_cat.artID= sys_partner.id) AND (sys_partner_cat.catID=sys_function.id) AND (sys_partner.lang='$lang') AND (sys_partner.ctrl&1=1) AND (sys_partner.special_promotion=1) ORDER BY sys_partner.date_create DESC LIMIT 0,1";	
		$arr=$db->GetAssoc($sql);
		if(!$arr) return;
		$smarty->assign('arr',$arr);
		$smarty->assign('Project_Implementation',$lable->_("Project Implementation"));			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/projectfocus.tpl','projectfocus_');

	}
?>