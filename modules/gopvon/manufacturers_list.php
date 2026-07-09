<?php
	function manufacturers_list()
	{
		global $db,$smarty;
		$sql="SELECT * FROM hang_san_xuat WHERE logo !=  '' ORDER BY name ASC";
		$arr=$db->GetAssoc($sql);
		
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/block_manufacturers_list.tpl','block_manufacturers_list_');
	}
?>