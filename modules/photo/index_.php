<?php
	switch ($op){
		case "list"	: 	photoList();break;
		default		:	mainShow(); break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable,$db, $arr_info_page;		
		
		$idF=getparamFID(getParam("idF"),false);		
		$id = getParam("id");		
		$smarty->assign('url',getFunctionNameID($idF,"htaccess"));		
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		
		if(!$id){// danh sach pho to co parent=0
			$arr=getPhotoGroup($idF);				
			$smarty->assign('arr', $arr);		
			$smarty->assign('Photo_library',$lable->_("Photo library"));		
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photo.tpl','photo_');
		}else{// danh sach photo theo group
			$arr=getPhotoID($id);
			$name=$arr["name"];	
			$des=$arr["des"];		
			$arr=getPhotoGroup($idF);
			$arrphoto=getPhotoList($id);
			
			$smarty->assign('id', $id);
			$smarty->assign('name', $name);	
			$smarty->assign('des', $des);	
			
			$smarty->assign('arr', $arr);	
			$smarty->assign('arrphoto', $arrphoto);		
			$smarty->assign('Photo_library',$name);
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoList.tpl','photoList_');
		}		
		include_once("footer.php");		
	}	
?>