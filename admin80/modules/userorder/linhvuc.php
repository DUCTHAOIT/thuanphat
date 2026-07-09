<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: linhvucList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		if($id)
		{
			$sql="SELECT * FROM linhvuc WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_linhvuc",$lable->_("Management linhvuc"));
		$smarty->assign("linhvuc_name",$lable->_("linhvuc name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		//$smarty->assign("",$lable->_(""));		

        $smarty->registerPlugin("function","linhvucList", "linhvucList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/linhvuc.tpl','linhvuc'.$themeName);
		include_once("footer.php");
	}
	//
	function linhvucList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM linhvuc  WHERE name LIKE '$search%' ORDER BY id DESC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=linhvuc',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/linhvuc_List.tpl','linhvuc_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$name=trim(getParamPost("name"));
		
		$id=getParamPost("id");
		$sort=getParamPost("sort");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=linhvuc";
		
		if($id)
		{
			$sql="UPDATE `linhvuc` SET `name`='$name',`sort`='$sort' WHERE (`id`='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM `linhvuc` WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("linhvuc already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO `linhvuc` (`id`,`name`,`sort`) VALUES (NULL,'$name','$sort')";
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
		$sql="DELETE FROM linhvuc WHERE `id`='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=linhvuc";
		
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