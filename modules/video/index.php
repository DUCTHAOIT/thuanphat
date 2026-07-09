<?php
	switch ($op){
		case "list"	: 	photoList();break;
		default		:	mainShow(); break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable,$db, $arr_info_page;		
		$id = getParam("id");		
		
		if(!$id){// danh sach pho to co parent=0
			$arr=getPhotoGroup();				
			$smarty->assign('arr', $arr);		
			$smarty->assign('Photo_library',$lable->_("Photo library"));		
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/videomain.tpl','videomain_');
		}else{// danh sach photo theo group
			$arr=getPhotoID($id);
			$name=$arr["name"];	
			$des=$arr["des"];		
			$arrre=getPhotoGroup($idF);
			$smarty->assign('id', $id);
			$smarty->assign('name', $name);
			$smarty->assign('des', $des);
			$smarty->assign('arr', $arr);
			$smarty->assign('arrre', $arrre);		
			$smarty->assign('Photo_library',$name);
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/videoList.tpl','videoList_');
		}		
		include_once("footer.php");		
	}	
?>