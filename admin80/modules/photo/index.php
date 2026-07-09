<?php
	switch ($op){
		case "frmcreate" 		: frmCreate(); break;
		case "update" 			: update(); break;
		case "lock"				: lock();break;
		case "delete"			: delete();break;
		case "mainlistofgroup"	: photoMainListOfGroup();break;
		default					: mainShow(); break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $smarty, $lable;
		
		//$arrTopic=getGroup();	
		
		//$smarty->assign('arrTopic',$arrTopic);
		$smarty->assign('Create', $lable->_("Create"));
		$smarty->assign('Photo_library',$lable->_("Photo library"));
		$smarty->registerPlugin("function","photoListGroup","photoListGroup");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photo.tpl','photo_');
		include_once("footer.php");
	}
	//
	function frmCreate(){
		include_once("header.php");
		global $smarty, $lable;			
		
		$id=getParamPost("id");
		$parent=getParam("parent");		
		$arrGroup=getGroupPhoto();
			
		if($id){
			$arr=getPhotoID($id);
			$smarty->assign('arr', $arr);
			$smarty->assign('id', $id);			
		}
		$smarty->assign('parent', $parent);
		$smarty->assign('arrGroup', $arrGroup);	
		$smarty->assign('arrTopic', $arrTopic);				
		$smarty->assign('Create', $lable->_("Create"));
		$smarty->assign('Description', $lable->_("Description"));
		$smarty->assign('Focus', $lable->_("Focus"));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoFrm.tpl','photoFrm_');
		include_once("footer.php");
	}
	function photoListGroup(){
		global $smarty, $lable;
		$arr=getGroupPhotoParent();//group photo				
		
		$smarty->assign('arr', $arr);		

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoListGroup.tpl','photoListGroup_');
	}
	//
	function photoMainListOfGroup(){
		include_once("header.php");
		global $smarty, $lable;	
		$arr=getPhotoID(getParam("id"));
		$smarty->assign('name', $arr["name"]);
		$smarty->assign('parent', getParam("id"));
		$smarty->assign('Create', $lable->_("Create"));
		$smarty->assign('Photo_library',$lable->_("Photo library"));
		
		$smarty->registerPlugin("function","photoListOfGroup","photoListOfGroup");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoMainListOfGroup.tpl','photoMainListOfGroup_');
		include_once("footer.php");
	}
	//
	function photoListOfGroup(){
		global $smarty, $lable;
		$id=getParam("id");		
		$arr=getPhotoList($id);//list photo of group		
		$smarty->assign('arr', $arr);
		$smarty->assign('parent', $id);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoListOfGroup.tpl','photoListOfGroup_');
	}
?>