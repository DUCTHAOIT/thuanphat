<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: xuatsuList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		
		if($id)
		{
			$sql="SELECT * FROM xuat_su WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_xuatsu",$lable->_("Management xuatsu"));
		$smarty->assign("xuatsu_name",$lable->_("xuatsu name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		$smarty->assign('date_create',date("Y-m-d"));	
		
		$smarty->registerPlugin("function","xuatsuList", "xuatsuList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/xuat_su.tpl','xuat_su'.$themeName);
		include_once("footer.php");
	}
	//
	function xuatsuList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=100;
		$sql="SELECT * FROM xuat_su WHERE type=0 ORDER BY id DESC";
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=user&f=xuatsu',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/xuat_su_List.tpl','xuat_su_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$id=getParamPost("id");
		$taisan=trim(getParamPost("taisan"));
		$khoiluong=trim(getParamPost("khoiluong"));
		$giadvdt=trim(getParamPost("giadvdt"));
		$date=getParamPost("date");
		
		$sort=getParamPost("sort");
		if($sort) $sort = 1;
		else $sort = 0;
		
		if($id)
		{
			$sql="UPDATE xuat_su SET taisan='$taisan', khoiluong='$khoiluong', giadvdt='$giadvdt', date='$date', sort='$sort' WHERE (id='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="INSERT INTO xuat_su (taisan,khoiluong,giadvdt,date,sort) VALUES ('$taisan','$khoiluong','$giadvdt','$date','$sort')";
			$resurn=$db->Execute($sql);			
		}		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=user&f=xuatsu";
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
		$sql="DELETE FROM xuat_su WHERE id='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=user&f=xuatsu";
		
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