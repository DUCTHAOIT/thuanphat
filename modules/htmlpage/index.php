<?php
	switch ($op){		
		case "tongquantstt": 	tongquantstt(); break;
		case "tongquantsbv": 	tongquantsbv(); break;
		default: mainShow(); break;
	}
	//
	function mainShow(){
		global $themeName, $smarty, $lable, $idF;	
		include_once("header.php");
		$id_htmlpage=getParam("id_htmlpage");		
		
		$idF=getparamFID(getParam("idF"),false);			
		
		$arr=getHtmlpageID($id_htmlpage);
		$smarty->assign('img2',getFunctionNameID($idF,"img2"));
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->assign('des',getFunctionNameID($idF,"des"));
		$smarty->assign('email',getSession("email"));		
		$smarty->assign('arr',$arr);		
		$smarty->assign('updating',$lable->_("Updating"));
		$smarty->assign('Print',$lable->_("Print"));
		$smarty->assign('MailToFriend',$lable->_("Mail To Friend"));
		$smarty->registerPlugin("function","menuRelation","menuRelation");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/htmlpage.tpl','htmlpage_'.$themeName);	
		
		include_once("footer.php");
	}
	function menuRelation(){
		global $db,$smarty;		
		
		$fid=getparamFID(getParam("idF"));
		$id=getparamFID(getParam("idF"),false);	
				
		$arrimg1=getFunctionNameID($fid,"img1");			
		$arrimg2=getFunctionNameID($fid,"img2");			
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_function";		
		$obj->limit="all";
		$obj->where="(ctrl&1=1) AND (id<>$id)";
		$obj->orderBy="sort";
		$sql=$obj->sqlSelect();
		
		include_once("modules/control/menuLevelLeft.class.php");
		$obj=new menuLevelLeft();
		$obj->fid=$fid;
		$obj->sql=$sql;
		$arr=$obj->orderMenu();				
		
		if(!$arr) return;
		$smarty->assign('arrimg1',$arrimg1);
		$smarty->assign('arrimg2',$arrimg2);
		$smarty->assign('arr',$arr);
		$smarty->assign('fid',$fid);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menuRelation.tpl','menuLeftOfMenuTop_'.$fid);	
	}
	function tongquantstt()
	{
		include_once("header.php");
			global $smarty,$db;
			$idF=getparamFID(getParam("idF"),false);
			$smarty->assign('name',getFunctionNameID($idF,"name"));
			$smarty->assign('nameFun',getFunctionNameSub($idF));
			
			$arrTSI=getTSI();
			$smarty->assign('arrTSI',$arrTSI);
			$arrTSITangGiam=getTSITangGiam();
			$smarty->assign('arrTSITangGiam',$arrTSITangGiam);
		
			include_once("modules/home/hieuqua.php");
			$smarty->registerPlugin("function","hieuqua","hieuqua");
			
			$smarty->assign('navtstt',htmlcontent(130));
			$smarty->assign('danhmucdttstt',htmlcontent(129));
			
			include_once("modules/home/producthome.php");
			$smarty->registerPlugin("function","producthome","producthome");
			
			$smarty->registerPlugin("function","diendanmo","diendanmo");
			
			$smarty->assign('tongquan',htmlcontent(108));
			$smarty->assign('gioithieu',htmlcontent(125));
			$smarty->assign('thanhtuu',htmlcontent(126));
			
			$smarty->assign('dieukhoan',htmlcontent(116));
			$smarty->assign('chienluoc',htmlcontent(109));
			$smarty->assign('phuongphap',htmlcontent(110));
			$smarty->assign('danhmuc',htmlcontent(111));
			$smarty->assign('ruiro',htmlcontent(112));
			$smarty->assign('uudiem',htmlcontent(113));
			$smarty->assign('ndtsohuu',htmlcontent(114));
			$smarty->assign('faq',htmlcontent(152));
			
			$smarty->assign('cachtinhdvdt',htmlcontent(148));
			$smarty->assign('hoantravongop',htmlcontent(150));
			$smarty->assign('phanchialoinhuan',htmlcontent(140));
			$smarty->assign('hoahonggioithieu',htmlcontent(141));
			$smarty->assign('bieuphi',htmlcontent(142));
			$smarty->assign('ruirodieukhoan',htmlcontent(143));
			
			$smarty->registerPlugin("function","format_number", "format_number");
			$smarty->registerPlugin("function","format_number2", "format_number2");
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tongquantstt.tpl','tongquantstt_');
			
		include_once("footer.php");
	}
	function tongquantsbv()
	{
		include_once("header.php");
			global $smarty,$db;
			$idF=getparamFID(getParam("idF"),false);
			$smarty->assign('name',getFunctionNameID($idF,"name"));
			$smarty->assign('nameFun',getFunctionNameSub($idF));
			
			$arrTSI2=getTSI2();
			$smarty->assign('arrTSI2',$arrTSI2);
			$arrTSITangGiam2=getTSITangGiam2();
			$smarty->assign('arrTSITangGiam2',$arrTSITangGiam2);
			
			include_once("modules/home/hieuqua.php");
			$smarty->registerPlugin("function","hieuqua","hieuqua");
		
			include_once("modules/home/hieuquabv.php");
			$smarty->registerPlugin("function","hieuquabv","hieuquabv");
			
			include_once("modules/home/producthome.php");
			$smarty->registerPlugin("function","producthome","producthome");
			
			$smarty->registerPlugin("function","diendanmo","diendanmo");
			
			$smarty->assign('danhmucdttsbv',htmlcontent(131));
			$smarty->assign('navtsbv',htmlcontent(132));
			
			$smarty->assign('tongquan',htmlcontent(124));
			
			$smarty->assign('gioithieu',htmlcontent(127));
			$smarty->assign('thanhtuu',htmlcontent(128));
			$smarty->assign('dieukhoan',htmlcontent(117));
			$smarty->assign('chienluoc',htmlcontent(118));
			$smarty->assign('phuongphap',htmlcontent(119));
			$smarty->assign('danhmuc',htmlcontent(120));
			$smarty->assign('ruiro',htmlcontent(121));
			$smarty->assign('uudiem',htmlcontent(122));
			$smarty->assign('ndtsohuu',htmlcontent(123));	
			$smarty->assign('faq',htmlcontent(153));
			$smarty->assign('cachtinhdvdt',htmlcontent(149));
			$smarty->assign('hoantravongop',htmlcontent(151));
			
			$smarty->assign('phanchialoinhuan',htmlcontent(144));
			$smarty->assign('hoahonggioithieu',htmlcontent(145));
			$smarty->assign('bieuphi',htmlcontent(146));
			$smarty->assign('ruirodieukhoan',htmlcontent(147));
					
			$smarty->registerPlugin("function","format_number", "format_number");
			$smarty->registerPlugin("function","format_number2", "format_number2");
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tongquantsbv.tpl','tongquantsbv_');
			
		include_once("footer.php");
	}
	//
	//
	function getTSI(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getTSITangGiam(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	//
	function getTSI2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date  FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getTSITangGiam2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=1  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//	
	//
	function diendanmo(){
		global $smarty,$db,$themeName,$lable,$lang;	
		$sql="SELECT sys_worldwide.*, sys_function.htaccess FROM sys_worldwide,sys_function WHERE (sys_worldwide.catID =  sys_function.id) AND (sys_function.ctrl&1=1) AND (sys_worldwide.lang='$lang') AND (sys_worldwide.ctrl&1=1) ORDER BY sys_worldwide.no DESC LIMIT 0,3";						
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);		
		
		$smarty->registerPlugin("function","strstrim", "strstrim");
		$smarty->registerPlugin("function","strstrimtempworldwide", "strstrimtempworldwide");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/diendanmo.tpl','diendanmo_'.$themeName);
	}
	//
?>