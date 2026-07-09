<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: manufacturers_ytList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		
		if($id)
		{
			$sql="SELECT * FROM hang_san_xuat_yt WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_manufacturers",$lable->_("Management manufacturers"));
		$smarty->assign("Manufacturers_name",$lable->_("Manufacturers name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		//$smarty->assign("",$lable->_(""));		
		
		$smarty->registerPlugin("function","manufacturers_ytList", "manufacturers_ytList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hang_san_xuat_yt.tpl','hang_san_xuat_yt'.$themeName);
		include_once("footer.php");
	}
	//
	function manufacturers_ytList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM hang_san_xuat_yt  WHERE name LIKE '$search%' ORDER BY sort DESC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=manufacturers_yt',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hang_san_xuat_yt_List.tpl','hang_san_xuat_yt_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		loadClass("convertString");
		$converString=new convertString();
		
		$name=trim(getParamPost("name"));
		
		$alias= strtolower($converString->remoteDiacritic($name));
		
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
		$ret_page="?m=product&f=manufacturers_yt";
		
		if($id)
		{
			$sql="UPDATE `hang_san_xuat_yt` SET `name`='$name', logo='$logo', sort='$sort', link='$link', alias='$alias' WHERE (`id`='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM `hang_san_xuat_yt` WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("Manufacturers already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO `hang_san_xuat_yt` (`id`,`name`,`logo`,`sort`,`link`,`alias`) VALUES (NULL,'$name','$logo','$sort','$link','$alias')";
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
		$sql="DELETE FROM hang_san_xuat_yt WHERE `id`='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=manufacturers_yt";
		
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