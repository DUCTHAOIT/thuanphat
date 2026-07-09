<?php	
	function topMenu(){		
		getTopMenu();		
	}
	//
	function topMenucap2(){
	global $themeName, $lang, $db;
		$lang=getLang();
		$sql="SELECT * FROM sys_function";
		$sql.=" WHERE ctrl&8=8 AND ctrl&1=1 AND (lang='$lang')";		
		$sql.=" ORDER BY sort ASC";
		$rs = $db->Execute($sql);
		if (!$rs->RecordCount()) return;
		//echo $sql;
		include(_DOMAIN_ROOT_PATH."/theme/default/templates/menu_top3.php");
	}
	//
	function topMenucap2mobile(){
	global $themeName, $lang, $db;
		$lang=getLang();
		$sql="SELECT * FROM sys_function";
		$sql.=" WHERE ctrl&8=8 AND ctrl&1=1 AND (lang='$lang')";		
		$sql.=" ORDER BY sort ASC";
		$rs = $db->Execute($sql);
		if (!$rs->RecordCount()) return;
		include(_DOMAIN_ROOT_PATH."/theme/default/templates/menu_top3mobile.php");
	}
	
	//
	function topMenu_duongmn(){
	global $smarty,$themeName,$lable;
	$arr=getTopMenuDuongmn();	
	if(!$arr) return;
	$smarty->registerPlugin("function","viewLanguage", "viewLanguage");
	$smarty->assign('arr',$arr);	
	$smarty->assign('Home',$lable->_("Home"));	
	$smarty->assign('Gallery',$lable->_("Gallery"));	
	$smarty->assign('Forum',$lable->_("Forum"));	
	$smarty->assign('Contact',$lable->_("Contact"));	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/topMenu_duongmn.tpl','topMenu_duongmn_'.$themeName);		
	}
	//
	function viewLanguage(){
		global $lang,$themeName;		
		//if($lang=="en") $imgLang="<img src=\"theme/$themeName/images/vn.gif\" onclick=\"document.frmLang.lang.value='vn'; document.frmLang.submit();\" style=\"cursor:pointer\" />";
		//else $imgLang="<img src=\"theme/$themeName/images/en.gif\" onclick=\"document.frmLang.lang.value='en'; document.frmLang.submit();\" style=\"cursor:pointer\" />";
		//echo "<img src=\"theme/$themeName/images/ge.gif\" onclick=\"document.frmLang.lang.value='de'; document.frmLang.submit();\" style=\"cursor:pointer\" /> &nbsp; <img src=\"theme/$themeName/images/en.gif\" onclick=\"document.frmLang.lang.value='en'; document.frmLang.submit();\" style=\"cursor:pointer\" /> &nbsp; <img src=\"theme/$themeName/images/vn.gif\" onclick=\"document.frmLang.lang.value='vn'; document.frmLang.submit();\" style=\"cursor:pointer\" />";		
		//ok
		echo "<img src=\"../../theme/default/images/vn.gif\" onclick=\"document.frmLang.lang.value='vn'; document.frmLang.submit();\" style=\"cursor:pointer\" alt=\"\"  />&nbsp;<img src=\"../../theme/default/images/en.gif\" alt=\"English\"  onclick=\"document.frmLang.lang.value='en'; document.frmLang.submit();\" style=\"cursor:pointer\" />";	
		
		//echo "<img src=\"../../theme/default/images/vn.gif\"  style=\"cursor:pointer\" alt=\"Tiếng Việt\"  />&nbsp;<img src=\"../../theme/default/images/en.gif\" alt=\"English\"   style=\"cursor:pointer\" />";	
		
		
		
		//echo "<a href=\"http://alcblock.com.vn\"><img src=\"../../theme/default/images/en.gif\" alt=\"English\"  style=\"cursor:pointer\" border=\"0\" /></a>&nbsp;<a href=\"http://udickimbinh.com.vn\"><img src=\"../../theme/default/images/vn.gif\"  style=\"cursor:pointer\" alt=\"\"   border=\"0\"/></a>";	
		
		//echo "<img src=\"../../theme/default/images/vn.gif\" style=\"cursor:pointer\" /> &nbsp;<img src=\"../../theme/default/images/en.gif\" style=\"cursor:pointer\" />";			
			
		//if($lang=="en"){
		//echo "<select class=\"selectlang\" onChange=\"frmLang.lang.value='vn'; frmLang.submit();\" >";	
		//echo "<option  value=\"vn\"   class=\"content\" style=\"color:#0158a5\">Vietnam</option>";
	//	echo "<option  selected=\"selected\"  value=\"en\"   class=\"content\" style=\"color:#0158a5\">English</option>";
		//}else{
	//	echo "<select class=\"selectlang\" onChange=\"frmLang.lang.value='en'; frmLang.submit();\" >";
	//		echo "<option selected=\"selected\"  class=\"content\" style=\"color:#0158a5\"  value=\"vn\">Vietnam</option>";
	//		echo "<option  value=\"en\"  class=\"content\" style=\"color:#0158a5\">English</option>";
	//	}
	//	echo "</select>";		
	}
	//
	function viewLanguage_mobile(){
		global $lang,$themeName;
		echo "<img src=\"../../theme/default/images/en.png\" alt=\"English\"  onclick=\"document.frmLang.lang.value='en'; document.frmLang.submit();\" style=\"cursor:pointer\"  width=\"30px\"/>&nbsp;<img src=\"../../theme/default/images/vi.png\" onclick=\"document.frmLang.lang.value='vn'; document.frmLang.submit();\" style=\"cursor:pointer\" alt=\"Tiêngs Việt\" width=\"30px\"  />";			
	}
	//
	function leftBlock(){		
		$arr=getLeftBlock();
		if(!$arr) return;
		echo "<div class=\"col-xs-12 col-sm-12 col-md-3\">";		
		foreach($arr as $key=>$value){
			echo "<div valign=\"top\" style=\"padding-bottom:10px;\">";
			include_once($value);
			$key();
			echo "</div>";
		}
		echo "</div>";
	}
	//
	function rightBlock(){		
		$arr=getRightBlock();
		if(!$arr) return;
		echo "<div class=\"col-xs-12 col-sm-12 col-md-3 hidden-sx hidden-sm\">";	
		foreach($arr as $key=>$value){
			echo "<div valign=\"top\" style=\"padding-bottom:10px;\">";
			include_once($value);
			$key();
			echo "</div>";
		}
		echo "</div>";
	}
	//
	function centerBlock(){		
		$arr=getCenterBlock();
		if(!$arr) return;		
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		foreach($arr as $key=>$value){
			echo "<tr><td valign=\"top\" style=\"padding-bottom:5px\">";
			include_once($value);
			$key();
			echo "</td></tr>";
		}
		echo "</table>";		
	}
	//
	function TimeCX() {			
		global $lang;
		$Day = date(D);
		if($lang=='vn'){
		switch ($Day)
			{
			case 'Mon': $Day = 'Thứ 2'; break;
			case 'Tue': $Day = 'Thứ 3'; break;
			case 'Wed': $Day = 'Thứ 4'; break;
			case 'Thu': $Day = 'Thứ 5'; break;
			case 'Fri': $Day = 'Thứ 6'; break;
			case 'Sat': $Day = 'Thứ 7'; break;
			case 'Sun': $Day = 'Chủ nhật'; break;
			}
		}	
		echo $Day;
		}
	//
	function ngay() {			
		global $lang;
		$Day = date(D);
		if($lang=='vn'){
		switch ($Day)
			{
			case 'Mon': $Day = '1'; break;
			case 'Tue': $Day = '1'; break;
			case 'Wed': $Day = '1'; break;
			case 'Thu': $Day = '0'; break;
			case 'Fri': $Day = '0'; break;
			case 'Sat': $Day = '0'; break;
			case 'Sun': $Day = '0'; break;
			}
		}	
		return $Day;
	}
	//
	function ngaytsbv() {			
		global $lang;
		$Day = date(D);
		if($lang=='vn'){
		switch ($Day)
			{
			case 'Mon': $Day = '1'; break;
			case 'Tue': $Day = '1'; break;
			case 'Wed': $Day = '1'; break;
			case 'Thu': $Day = '1'; break;
			case 'Fri': $Day = '1'; break;
			case 'Sat': $Day = '0'; break;
			case 'Sun': $Day = '0'; break;
			}
		}	
		return $Day;
	}
	
	function timemua() {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$time0 = date('H:i:s');	
		$time1 = '14:45:00';
		$time2 = '15:45:00';
		$time_stamp = strtotime($time0);
		$time_stamp1 = strtotime($time1);
		$time_stamp2 = strtotime($time2);
		
		if($time_stamp1 < $time_stamp && $time_stamp < $time_stamp2 ){
			$timeduocmua = '0';
		}else{
			$timeduocmua = '1';
		}
		return $timeduocmua;
	
	}		 
?>