<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: dongspList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		if($id)
		{
			$sql="SELECT * FROM dongsp WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_dongsp",$lable->_("Management dongsp"));
		$smarty->assign("dongsp_name",$lable->_("dongsp name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		//$smarty->assign("",$lable->_(""));		
		
		$smarty->registerPlugin("function","dongspList", "dongspList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/dongsp.tpl','dongsp'.$themeName);
		include_once("footer.php");
	}
	//
	function dongspList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM dongsp  WHERE name LIKE '$search%' ORDER BY id DESC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=dongsp',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/dongsp_List.tpl','dongsp_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$name=trim(getParamPost("name"));
		
		$id=getParamPost("id");
		$sort=getParamPost("sort");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=dongsp";
		
		if($id)
		{
			$sql="UPDATE dongsp SET name='$name',sort='$sort' WHERE (id='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM dongsp WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("dongsp already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO dongsp (id,name,sort) VALUES (NULL,'$name','$sort')";
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
		$sql="DELETE FROM dongsp WHERE id='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=dongsp";
		
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