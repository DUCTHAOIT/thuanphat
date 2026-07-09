<?php
	global $db, $lang, $moduleName, $lable, $themeName;
	// trang truoc $ret_page = $_SERVER['HTTP_REFERER'];
    if($affiliate_id){
        $tennguoigiothieu = getUsersID($affiliate_id,"name");
        $smarty->assign("tennguoigiothieu", $tennguoigiothieu);
    }
	
	$sql="SELECT * FROM sys_config WHERE (name='address') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$address=$rs->fields('value');
	
	$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$support=$rs->fields('value');
	
	include_once("modules/control/visitor.php");
	$smarty->registerPlugin("function","visitor","visitor");
	
	$sql="SELECT * FROM sys_config WHERE (name='hotline') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$facebook=$rs->fields('value');
	$smarty->assign('facebook',$facebook);
	
		
	include "theme/$themeName/templates/menu_button_default.php";
	$smarty->registerPlugin("function","menu_button_default", "menu_button_default");	
	
	
	include_once("modules/control/weblink.php");
	$smarty->registerPlugin("function","weblink","weblink");	

	$sql="SELECT * FROM sys_advertise";
	$sql.=" WHERE (ctrl&1=1) AND (position='0') AND (lang='$lang')";
	$sql.=" ORDER BY no ASC LIMIT 0,1";
	$rs=$db->Execute($sql);
	$imgpopup=$rs->fields("img");
	$urlpopup=$rs->fields("website");
	
	$smarty->assign('imgpopup',$imgpopup);	
	$smarty->assign('urlpopup',$urlpopup);	
	
	$smarty->assign("address", $address);	
	$smarty->assign("support", $support);	
	$smarty->assign('email',getSession("email"));		
	$smarty->assign('urlshare',$_SERVER['REQUEST_URI']);
	$smarty->assign('ret_page',$_SERVER['REQUEST_URI']);
	$smarty->assign('Top',$lable->_("Top"));
	$smarty->registerPlugin("function","rightBlock", "rightBlock");	
	$smarty->registerPlugin("function","centerBlock", "centerBlock");
	$smarty->registerPlugin("function","button_menu", "button_menu");	
	
	$smarty->registerPlugin("function","advertise_footer", "advertise_footer");	
	$smarty->registerPlugin("function","advertise_button", "advertise_button");	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/footer.tpl','footer_'.$themeName);
	
	/**
	 * hien thi chuc nang ruoi footer
	 *
	 */
	//
	//danh dau menu.
	?>	
	<script language="javascript">
		function paintMenu00(id){
			document.getElementById('a'+id).style.color="#2fd7b3";
		//	document.getElementById('center'+id).className ="menuOn";
		//	document.getElementById(id).className ="menuLeftOn";
		//	document.getElementById('back'+ id).className ="menuOnBack";
		//	document.getElementById('next'+ id).className ="menuOnNext";		
		}
		
		function paintMenu0(id){
		//	document.getElementById('center'+id).className ="menuCenterOn";
			document.getElementById('a'+id).style.color="#2fd7b3";
			
		//	document.getElementById('aleft'+id).style.color="#ffffff";
		//	document.getElementById('left'+ id).className ="menuLeftOn";
			
		//	document.getElementById('next'+ id).className ="menuOnNext";		
		}
		
		function paintMenu1(id){
			
		//	document.getElementById('sp'+id).style.color="ffffff";
			document.getElementById('a'+id).style.color="#f1592a";
		//	document.getElementById('left'+ id).className ="menuLeftOn";
		
		
	//		
	
	//		document.getElementById('backleft'+ id).className ="menuLeftOnBack";
	//		document.getElementById('nextleft'+ id).className ="menuLeftOnNext";	
		}
		function paintMenuPro(id){
			
			document.getElementById('a'+id).style.color="#f1592a";	
			//document.getElementById(id).style.color="#fd0505";
			//document.getElementById(id).className ="menuOn";
		}
		//
		function paintMenuUser(id){
			document.getElementById('center'+id).className ="menuCenterOn";
		//	document.getElementById('a'+id).style.color="#f37022";
		//	document.getElementById('aleft'+id).style.color="#ffffff";
		//	document.getElementById('left'+ id).className ="menuLeftOn";
		//	document.getElementById('next'+ id).className ="menuOnNext";		
		}
		
	</script>
	<?php
	$fid=getParam("idF");	
	if($fid=='1000'){
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "paintMenuUser(1000);\n";
		echo "paintMenuUser(2000);\n";
		echo "</script>\n";
		
	}
	if($fid=='1001'){
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "paintMenuUser(1001);\n";
		echo "paintMenuUser(2001);\n";
		echo "</script>\n";
		
	}
	
	if(!$fid){
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "paintMenu0(556);\n";
		echo "</script>\n";
	}
	if($fid){
		$arr=explode("_", $fid);		
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		foreach($arr as $key=>$value){				
			echo "paintMenu$key($value);\n";
		}
		echo "</script>\n";
	}
	
		$alias = getParam("id");	
		if($alias){
			$sql="SELECT id FROM sys_product WHERE alias='$product_id'";
			$rs=$db->Execute($sql);
			$proID=$rs->fields("id");	
				
			echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
			echo "paintMenuPro($proID);\n";	
			echo "</script>\n";	
		}
	if($moduleName=='product'){
		$idF=getparamFID(getParam(idF),false);
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "paintMenuPro($idF);\n";	
		echo "</script>\n";	
	}	
	
	
	$idF2=getparamFID(getParam(idF),false);
	$parentroot=getFunctionNameID($idF2,"parentroot");
	
	
	if($parentroot>0){
		
		echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
		foreach($arr as $key=>$value){				
			echo "paintMenu00($parentroot);\n";
		}
		echo "</script>\n";
		
		if($idF2){
			echo "\n<script language=\"javascript\" type=\"text/javascript\">\n";
			foreach($arr as $key=>$value){				
				echo "paintMenuPro($idF2);\n";
			}
			echo "</script>\n";
		}
	}
	
	function button_menu()
	{
		global $smarty;
		$arr=get_button_menu();
		
		$smarty->assign('arr',$arr);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menu_button.tpl','index_');
	}	
	//
	function advertise_button()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT * FROM sys_advertise";
		$sql.=" WHERE (ctrl&1=1) AND (position='1') AND (lang='$lang')";
		$sql.=" ORDER BY no ASC";
		$arr=$db->GetAssoc($sql);
		//$arr=$db->GetAll($sql);		
		$smarty->assign('arr',$arr);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/doitac2.tpl','index_');
	}	
	//
	function advertise_footer()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT * FROM sys_advertise";
		$sql.=" WHERE (ctrl&1=1) AND (position='3') AND (lang='$lang')";
		$sql.=" ORDER BY no ASC LIMIT 0,1";
		$arr=$db->GetAssoc($sql);
		$smarty->assign('theme',$themeName);
		$smarty->assign('arr',$arr);
		$smarty->assign('Advertise',$lable->_("Advertise"));	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseCenter.tpl','advertiseLeft_');	
	}
?>