<?php
	switch ($op){
		case "list"	: 	photoList();break;
		default		:	mainShow(); break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable,$db, $arr_info_page;		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		
		$idF=getparamFID(getParam("idF"),false);		
		$id = getParam("id");		
		$smarty->assign('url',getFunctionNameID($idF,"htaccess"));		
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		
		
		if(!$id){// danh sach pho to co parent=0
			$limit=4;
			$arr=getPhotoGroup($idF);				
			$smarty->assign('arr', $arr);		
			$smarty->assign('Photo_library',$lable->_("Photo library"));		
			
			$numberRecord=count($arr);
			$smarty->assign('limit',$limit);
			$smarty->assign('pageID',$pageID);
			$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photo.tpl','photo_');
		}else{// danh sach photo theo group
			$limit=40;
			$arr=getPhotoID($id);
			$name=$arr["name"];	
			$des=$arr["des"];		
		//	$arr=getPhotoGroup($idF);
			$arr=getPhotoList($id);
			
			$smarty->assign('id', $id);
			$smarty->assign('name', $name);	
			$smarty->assign('des', $des);	
			
			$smarty->assign('arr', $arr);					
			$smarty->assign('Photo_library',$name);
			
			$numberRecord=count($arr);
			$smarty->assign('limit',$limit);
			$smarty->assign('pageID',$pageID);
			$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"]."&id=".$id,$numberRecord,$limit,$pageID));
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoList.tpl','photoList_');
		}		
		include_once("footer.php");		
	}	
?>