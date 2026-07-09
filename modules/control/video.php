<?php
	function video(){	
		global $smarty,$lable,$themeName,$db,$lang;
		$sql="SELECT sys_video.*,sys_function.htaccess FROM sys_video,sys_function";
		$sql.=" WHERE (sys_video.catID=sys_function.id) AND (sys_video.ctrl&1=1) AND (sys_video.lang='$lang')";
		$sql.=" ORDER BY no ASC LIMIT 0,3";
		$arr=$db->GetAssoc($sql);
					
		$clip=getParam("clip");
		$smarty->assign('theme',$themeName);
		$smarty->assign('arr',$arr);
		$smarty->assign('clip',$clip);
		$smarty->assign('Advertise',$lable->_("Advertise"));	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/video.tpl','video_');	
	}
?>