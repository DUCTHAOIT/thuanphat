<?php
	switch($op){
		case "add"			: add();break;
		case "del"			: delete();break;
		case "search"		: slideList();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $db,$smarty,$lable;
		$id=getParam("id");
		
		if($id)
		{
			$sql="SELECT * FROM slide WHERE id='$id'";			
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
			$smarty->assign("id",$id);
		}
		
		$smarty->assign("arr",$arr);
		
		$smarty->assign("Management_slide",$lable->_("Management slide"));
		$smarty->assign("slide_name",$lable->_("slide name"));
		$smarty->assign("Company_logo",$lable->_("Company logo"));
		$smarty->assign("Update",$lable->_("Update"));
		//$smarty->assign("",$lable->_(""));		
		
		$smarty->registerPlugin("function","slideList", "slideList");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/slide.tpl','slide'.$themeName);
		include_once("footer.php");
	}
	//
	function slideList(){
		global $smarty,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		$search=getParam("search");
		$sql="SELECT *  FROM slide  WHERE name LIKE '$search%' ORDER BY sort ASC";				
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);		
		
		$smarty->assign('arr',$arr);
		
		$smarty->assign('limit',$limit);
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage('?m=product&f=slide',$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/slide_List.tpl','slide_List_'.$themeName);
	}
	//
	function add()
	{
		global $db,$lable;
		$name=trim(getParamPost("name"));
		$logo=getParamPost("logo");
		$des=getParamPost("des");
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
		$ret_page="?m=product&f=slide";
		
		if($id)
		{
			$sql="UPDATE `slide` SET `name`='$name', `des`='$des', logo='$logo', sort='$sort', link='$link' WHERE (`id`='$id')";			
			$resurn=$db->Execute($sql);
		}
		else 
		{
			$sql="SELECT * FROM `slide` WHERE (name='$name')";
			$rs=$db->Execute($sql);
			if($rs->fields("name"))
			{
				$a=new msgBox($lable->_("slide already in the data"),"OKOnly", "Message", array($ret_page), 1);			
				$a->showMsg();
			}
			else 
			{
				$sql="INSERT INTO `slide` (`id`,`name`,`des`,`logo`,`sort`,`link`) VALUES (NULL,'$name','$des','$logo','$sort','$link')";
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
		$sql="DELETE FROM slide WHERE `id`='$id'";
		$resurn=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=product&f=slide";
		
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