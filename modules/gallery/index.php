<?php
	switch ($op){
		case "list"	: 	photoList();break;
		default		:	mainShow(); break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable,$db;		
		
		$id = getParam("id");
		
		if(!$id){// danh sach pho to co parent=0
			$arr=getPhotoGroup();				
			$smarty->assign('arr', $arr);		
			$smarty->assign('Photo_library',$lable->_("Photo library"));		
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photo.tpl','photo_');
		}else{// danh sach photo theo group
			$arr=getPhotoID($id);
			$name=$arr["name"];	
			$des=$arr["des"];		
			$arr=getPhotoList($id);
			$smarty->assign('arr', $arr);		
			$smarty->assign('Photo_library',$name);
			$smarty->assign('des',$des);			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoList.tpl','photoList_');
		}		
		include_once("footer.php");		
	}	
?>