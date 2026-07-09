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
		//$smarty->assign("",$lable->_(""));		
		
		$smarty->registerPlugin("function","xuatsuList", "xuatsuList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/xuat_su.tpl','xuat_su'.$themeName);
		include_once("footer.php");
	}
	//
	function xuatsuList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM xuat_su  WHERE name LIKE '$search%' ORDER BY sort ASC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=xuatsu',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/xuat_su_List.tpl','xuat_su_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$name=trim(getParamPost("name"));
		$logo=getParamPost("logo");
		$id=getParamPost("id");
		$sort=getParam("sort");
		$link=getParam("link");
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$logo;		
			if(file_exists($sourcefile)){			
				$from=$sourcefile;
				if($logo)	$logo=rand(1,100).$logo;
				$to=_DOMAIN_ROOT_PATH."/images/logo/".$logo;
				moveFile($from,$to);			
			}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=xuatsu";
		
		if($id)
		{
			$sql="UPDATE `xuat_su` SET `name`='$name', logo='$logo', sort='$sort', link='$link' WHERE (`id`='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM `xuat_su` WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("xuatsu already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO `xuat_su` (`id`,`name`,`logo`,`sort`,`link`) VALUES (NULL,'$name','$logo','$sort','$link')";
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
		$sql="DELETE FROM xuat_su WHERE `id`='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=xuatsu";
		
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