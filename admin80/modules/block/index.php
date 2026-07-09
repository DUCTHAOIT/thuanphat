<?php
	include_once("modules/block/config.php");
	switch ($op){
		case "blockListOnPage" 	: blockListOnPage();break;
		case "addBlockOnPage"	: addBlockOnPage(); break;
		case "getPath"			: getPath();break;
		case "frmBlock"			: frmBlock();break;
		case "addBlock"			: addBlock();break;
		case "blockList"		: blockList();break;
		case "delete"			: blockDelete();break;
		case "deleteBlockOnPage": deleteBlockOnPage(getParamPost("id"));break;
		case "orderBlock"		: orderBlock();break;
		case "lockBlockOnPage"	: callLock(); break;
		default 				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable;	
		$smarty->assign('Create',$lable->_("Create"));
		$smarty->assign('Block_list',$lable->_("Block list"));
			
		$smarty->registerPlugin("function","pageList", "pageList");		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/block.tpl','block_'.$themeName);
		include_once("footer.php");
	}
	//
	function frmBlock(){
		include_once("header.php");
		global $themeName, $smarty, $lable, $arrPosition;
		
		$id=getParamPost("id");
		$arr=getBlockID($id);
		
		$smarty->assign('arrPosition',$arrPosition);
		$smarty->assign('arr',$arr);
		$path = _DOMAIN_ROOT_PATH."/".$arr["path"];		
		$smarty->assign('content',getContentBlock($path,$arr["name"]));
		$smarty->assign('id',$id);
		
		$smarty->assign('Create',$lable->_("Create"));
		$smarty->assign('Position',$lable->_("Position"));
		$smarty->assign('Description',$lable->_("Block description"));
		$smarty->assign('Block_content',$lable->_("Block content"));
		$smarty->assign('Update',$lable->_("Update"));
		
		
		$smarty->registerPlugin("function","getLablePosition", "getLablePosition");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/blockFrm.tpl','blockFrm_'.$themeName);
		include_once("footer.php");
	}
	//
	function pageList(){		
		global $themeName, $smarty, $lable,$arrPosition;
		$arr=getPageList();
		if(!$arr) die($lable->_("Cannot find page"));

		$smarty->assign('arrPosition',$arrPosition);
		
		$smarty->assign('Page_name',$lable->_("Page name"));		
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Left',$lable->_("Left"));
		$smarty->assign('Center',$lable->_("Center"));
		$smarty->assign('Right',$lable->_("Right"));
		$smarty->assign('Position',$lable->_("Position"));
		
		$smarty->assign('arr',$arr);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/blockPageList.tpl','blockPageList_'.$themeName);
	}
	//
	function blockListOnPage(){
		global $themeName, $smarty, $lable;
		$pid=getParamPost("pid");
		$pos=getParamPost("pos");		
		
		if($pid and $pos)	$arr=getBlockOnPageList($pid,$pos);				
		$smarty->assign('arr',$arr);
		$smarty->assign('pid',$pid);
		$smarty->assign('pos',$pos);
		
		$smarty->assign('Position',$lable->_("Position"));
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('Path',$lable->_("Path"));
		$smarty->assign('Not_block',$lable->_("Not block"));
		$smarty->assign('Description_block',$lable->_("Block description"));
		
		$smarty->registerPlugin("function","blockFrmAddOnpage", "blockFrmAddOnpage");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/blockListOnPage.tpl','blockListOnPage_'.$themeName);
	}
	//
	function blockList(){
		global $themeName, $smarty, $lable;
		include_once("header.php");
		$arr=getBlockList();
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('countarr',count($arr));
		$smarty->assign('Block_list',$lable->_("Block list"));
		$smarty->assign('Block_description',$lable->_("Block description"));
		$smarty->assign('Create_date',$lable->_("Create date"));
		$smarty->assign('File_path',$lable->_("File path"));
		$smarty->assign('Position',$lable->_("Position"));		
		
		$smarty->registerPlugin("function","getLablePosition", "getLablePosition");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/blockList.tpl','blockList_'.$themeName);
		include_once("footer.php");
	}
	//
	function getLablePosition($lableID){
		global $lable, $arrPosition;		
		$lableID=$lableID["lableID"];
		echo $lable->_($arrPosition[$lableID]);
	}
	//
	function blockFrmAddOnpage(){
		global $themeName, $smarty, $lable;
		$pos=getParamPost("pos");
		$pid=getParamPost("pid");
		
		$arr=getBlockPosition($pos);
		
		$smarty->assign('arr',$arr);
		$smarty->assign('pid',$pid);
		$smarty->assign('pos',$pos);
		
		$smarty->assign('Position',$lable->_("Position"));
		$smarty->assign('Update',$lable->_("Update"));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/blockFrmAddBlockOnPage.tpl','blockFrmAddBlockOnPage_'.$themeName);
	}
	
?>