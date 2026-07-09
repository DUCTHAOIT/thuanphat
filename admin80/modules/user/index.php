<?php
	switch ($op){
		case "frmCreate": frmCreate(); break;
		case "list"			: userList();break;
		case "changepass"	: changepass(); break;
		case "mCreate"	: userCreate(); break;
		case "lockUser"	: lockUser(); break;
		case "lockHLV"		: lockHLV();break;		
		case "loaiUser"	: loaiUser(); break;
		case "nhanvienUser"	: nhanvienUser(); break;
		case "mDelelte"	: userDelete(); break;
		default: mainShow(); break;
	}
	//
	 function mainShow(){
	 	include_once("header.php");	
		global $smarty,$lable;  	
	 	$smarty->assign('User_create',$lable->_("User create"));
	 	$smarty->registerPlugin("function","userList","userList");
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user.tpl','user');	
	 	include_once("footer.php");
	 }
	 //
	 function userList(){
	 	global $smarty, $themeName, $lable;
         $pageID=getParam("pageID");
         if(!$pageID) $pageID=0;
         $limit=20;

         $all=getUserList(true,0,0);
         $numberRecord=count($all);

         //$arr=getUserList();
	 	$smarty->assign('arr',$arr);

	 	$keyword=trim(getParam("keyword"));

	 	$smarty->assign('Date',$lable->_("Date"));	 	
	 	$smarty->assign('Number_access',$lable->_("Number access"));
	 	$smarty->assign('Status',$lable->_("Status"));
	 	$smarty->assign('Cannot_user',$lable->_("Cannot user"));
	 	$smarty->assign('No',$lable->_("No."));
         $smarty->assign('arr',getUserList(false,$pageID,20));

         $smarty->assign('countArr',$numberRecord);
         $smarty->assign('sPage',sPage('?m=user&keyword='.$keyword,$numberRecord,20,$pageID));
	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userList.tpl','userList_'.$themeName);
	 }
	 //
	 function frmCreate(){
	 	include_once("header.php");	
		global $smarty, $themeName, $lable; 
		$id=getParam("id");		
	
		if($id){ $arr=getUserID($id);	}
		
	 	$smarty->assign('arr',$arr);	 	
		$smarty->assign('userID',$userID);

	 	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/userCreate.tpl','userCreate_'.$themeName);	
	 	include_once("footer.php");
	 }
	 //
	 //
	function user_project()
	{		
		global $smarty, $themeName, $lable; 
		$id=getParam("id");
		$arrUserorder=getUserorder($id);
		$smarty->assign('arrUserorder',$arrUserorder);
		$numberUserorder=count($arrUserorder);
		
		$smarty->assign('numberUserorder',$numberUserorder);
		$smarty->registerPlugin("function","nameHlv", "nameHlv");
		$smarty->registerPlugin("function","diemdanh", "diemdanh");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_project.tpl','user_project_');
	}	
	//
	function khach_hang_gioi_thieu()
	{		
		global $smarty, $themeName, $lable; 
		$id=getParam("id");
		$arrUserGioithieu=getUserGioithieu($id);
		$smarty->assign('arrUserGioithieu',$arrUserGioithieu);
		$numberUserGioithieu=count($arrUserGioithieu);
		
		$smarty->assign('numberUserGioithieu',$numberUserGioithieu);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_khach_hang_gioi_thieu.tpl','user_khach_hang_gioi_thieu_');
	}	
	//
	function hdmuachungList(){
		global $themeName, $smarty, $lable;
		$id=getParam("id");
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		
		$catID=getParam("catID");			
		if(!$catID) $catID=getParamPost("catID");
		$fun=$catID;
		
		
		$all=gethdmuachungList($id);
		$numberRecord=count($all);			
		
		$smarty->assign('hdmuachung_name',$lable->_("hdmuachung name"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Photo',$lable->_("Photo"));
		$smarty->assign('hdmuachung_group',$lable->_("hdmuachung group"));		
		$smarty->assign('Date_create',$lable->_("Date create"));		
		$smarty->assign('Status',$lable->_("Status"));
		$smarty->assign('hdmuachungs_in_the_list',$lable->_("hdmuachungs in the list"));				
		
		$smarty->assign('arr',gethdmuachungList(false,$pageID,20));
		$smarty->assign('countArr',$numberRecord);
		$smarty->assign('sPage',sPage('?m=hdmuachung',$numberRecord,20,$pageID));
		
//		$smarty->registerPlugin("function","format_number", "format_number");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/hdmuachungList.tpl','hdmuachungList_'.$themeName);		
	}
	//
?>