<?php
	function slidegopvon()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$idF=getparamFID(getParam(idF),false);	
		
		//$gopvon_id=getParam(_ID_PRODUCT);
		
		$gopvon_id=getParam(id);
		if(!$gopvon_id) return;	
		$arr=get_gopvon_id_slide($gopvon_id);	
		
		$arrColor=getgopvonListPhotoslide($arr["id"]);	
		
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('view360',$arr["promotion"]);		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_slide.tpl','gopvon_slide_');
	}
	function get_gopvon_id_slide($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_gopvon.*";
		$sql.=" FROM sys_gopvon";
		$sql.=" WHERE (sys_gopvon.alias='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	function getgopvonListPhotoslide($proID){
		global $db;		
		$sql="SELECT * FROM sys_gopvon_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
?>