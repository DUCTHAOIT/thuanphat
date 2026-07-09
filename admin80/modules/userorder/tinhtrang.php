<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: tinhtrangList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		if($id)
		{
			$sql="SELECT * FROM tinh_trang WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_tinhtrang",$lable->_("Management tinhtrang"));
		$smarty->assign("tinhtrang_name",$lable->_("tinhtrang name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		//$smarty->assign("",$lable->_(""));		
		
		$smarty->registerPlugin("function","tinhtrangList", "tinhtrangList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tinh_trang.tpl','tinh_trang'.$themeName);
		include_once("footer.php");
	}
	//
	function tinhtrangList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM tinh_trang  WHERE name LIKE '$search%' ORDER BY id DESC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=tinhtrang',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tinh_trang_List.tpl','tinh_trang_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$name=trim(getParamPost("name"));
		
		$id=getParamPost("id");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=tinhtrang";
		
		if($id)
		{
			$sql="UPDATE `tinh_trang` SET `name`='$name' WHERE (`id`='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM `tinh_trang` WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("tinhtrang already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO `tinh_trang` (`id`,`name`) VALUES (NULL,'$name')";
				$resurn=$db->Execute($sql);				
			}			
		}		
		
		if(!$resurn)
		{			
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		else		
		{			
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
	}
	//
	function delete(){
		global $db;
		$id=getParam("id");
		if(!$id) return;
		$sql="DELETE FROM tinh_trang WHERE `id`='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=tinhtrang";
		
		if(!$resurn)
		{			
			$a=new msgBox("Request not be made","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		else		
		{			
			$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
	}
?>