<?php
	switch ($op){		
		default 			:	mainShow(); break;
	}
	//
	function mainShow(){
		global $smarty, $themeName, $lable, $lang, $db;
		include_once("header.php");
		
		include_once("modules/home/articlehome2.php");
		$smarty->registerPlugin("function","articlehome2","articlehome2");	
		
		include_once("modules/home/inveslist.php");
		$smarty->registerPlugin("function","inveslist","inveslist");	
		
		
		include_once("modules/control/nhungconso.php");	
		$smarty->registerPlugin("function","nhungconso","nhungconso");
		
		include_once("modules/control/advertiseCenter.php");	
		$smarty->registerPlugin("function","advertiseCenter","advertiseCenter");
		
		include_once("modules/control/advertiseGiovang.php");	
		$smarty->registerPlugin("function","advertiseGiovang","advertiseGiovang");	
		//include_once("modules/control/menuproducthome.php");
		include_once("modules/support_online/view_support_online_home.php");	
		$smarty->registerPlugin("function","view_support_online_home", "view_support_online_home");
				
		
		include_once("modules/invest/dangky.php");
		$smarty->registerPlugin("function","dangky","dangky");	
		
		//$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
		//$rs=$db->Execute($sql);		
		//$address=$rs->fields('value');
		//$smarty->assign('address',$address);
		$smarty->assign('navtheothang',htmlcontent(136));
		$smarty->assign('navgiaidoan',htmlcontent(137));
		
		$smarty->assign('danhmucdttstt',htmlcontent(129));
		$smarty->assign('danhmucdttsbv',htmlcontent(131));
		
		$smarty->assign('navtstt',htmlcontent(130));
		$smarty->assign('navtsbv',htmlcontent(132));
		
		$smarty->registerPlugin("function","about","about");			
		$smarty->registerPlugin("function","FunctionHome","FunctionHome");
		$smarty->registerPlugin("function","special_promotion_flash","special_promotion_flash");
		$smarty->registerPlugin("function","combo_home","combo_home");
		$smarty->registerPlugin("function","partnerhlv","partnerhlv");
        $smarty->registerPlugin("function","testimonials","testimonials");
		$smarty->registerPlugin("function","advertiseHome","advertiseHome");
		include_once("modules/home/articlehome.php");
		$smarty->registerPlugin("function","articlehome","articlehome");	
		
		
		$smarty->registerPlugin("function","videoHome","videoHome");
		
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/index.tpl','$themeName'.$themeName);		
		include_once("footer.php");
	}
	//
	//
	function FunctionHome(){
		global $smarty,$db,$themeName,$lable,$lang;	
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (img1>'0') AND (ctrl&1=1) AND (parent='48') ORDER BY sort ASC LIMIT 0,3";
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);		
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('More',$lable->_("More"));
		$smarty->assign('arrTopicProductHome',getTopicProductHome());
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/FunctionHome.tpl','FunctionHomee_'.$themeName);
	}
	//
	//
	function FunctionHomeCLB(){
		global $smarty,$db,$themeName,$lable,$lang;	
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&17=17) AND (parent='287') ORDER BY sort ASC LIMIT 0,3";
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/FunctionHomeCLB.tpl','FunctionHomeCLB_'.$themeName);
	}
	
	//
	function special_promotion_flash()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.img1, sys_product.alias, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_function.id='48') AND (sys_product.lang='$lang') AND (sys_product.ctrl&1=1)";
		$sql.=" ORDER BY sys_product.sort DESC LIMIT 0,10";
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);	
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign("Special_promotion",$lable->_("Special promotion"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_special_promotion.tpl','product_special_promotion_');
	}
	//
	//
	function combo_home()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		/*
		$sql="SELECT sys_gopvon.*, TO_DAYS(sys_gopvon.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_gopvon , sys_function";
		$sql.=" WHERE (sys_gopvon.catID =  sys_function.id) AND (sys_gopvon.lang='$lang') AND (sys_gopvon.ctrl&1=1)";
		$sql.=" ORDER BY sys_gopvon.date_create DESC LIMIT 0,10";
		*/
		$sql="SELECT sys_product.*, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product, sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_function.id='48') AND (sys_product.lang='$lang') AND (sys_product.ctrl&1=1) AND (sys_product.special_promotion=1)";
		$sql.=" ORDER BY sys_product.date_create DESC LIMIT 0,10";
		
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);	
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign("Special_promotion",$lable->_("Special promotion"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/combo_home.tpl','combo_home_');
	}
	//
    function testimonials(){

        global $smarty,$db,$themeName,$lable,$lang;

        $sql="SELECT sys_worldwide.*, sys_function.htaccess FROM sys_worldwide,sys_function WHERE (sys_worldwide.catID =  sys_function.id) AND (sys_function.ctrl&1=1) AND (sys_worldwide.lang='$lang') AND (sys_worldwide.ctrl&1=1) ORDER BY sys_worldwide.no DESC LIMIT 0,19";

        $arr=$db->GetAssoc($sql);

        $smarty->assign("arr",$arr);



        $smarty->registerPlugin("function","strstrimhlv", "strstrimhlv");

        $smarty->display(_DOMAIN_ROOT_TEMPLATE.'/testimonials.tpl','testimonials_'.$themeName);

    }
	//
	//
	function AboutHome(){
		global $smarty,$db,$themeName,$lable,$lang;		
		if($lang=='vn'){
			$sql="SELECT * FROM sys_function WHERE id='107'";		
		}else{
			$sql="SELECT * FROM sys_function WHERE id='107'";	
		}
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('About',$lable->_("About us"));
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/AboutHome.tpl','AboutHome_'.$themeName);
	}
	//
	//
	function partnerhlv(){
		global $smarty,$db,$themeName,$lable,$lang;	
		$sql="SELECT sys_partner.id,sys_partner.name,sys_partner.summary,sys_partner.content,sys_partner.alias,DATE_FORMAT(sys_partner.date_create, '".format_date()."') as date_create, TO_DAYS(sys_partner.date_create) as today, sys_partner.img,sys_partner_cat.catID, sys_function.htaccess FROM sys_partner_cat,sys_partner,sys_function WHERE sys_partner_cat.artID =  sys_partner.id AND sys_partner_cat.catID =  sys_function.id AND sys_function.ctrl&1=1 AND (sys_function.ctrl&1=1) AND (sys_function.module='partner') AND sys_partner.lang='$lang' AND sys_partner.ctrl&1=1 ORDER BY today DESC LIMIT 0,18";			
		//$sql="SELECT *,sys_function FROM sys_function WHERE (parent='48') AND (lang='$lang') AND (img1>'0') ORDER BY sort ASC LIMIT 0, 3";		
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);	
		$smarty->registerPlugin("function","strstrimhlv", "strstrimhlv");	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/partnerhlv.tpl','hoidap_'.$themeName);
	}
	
		
	//
	function getTopicProductHome($proID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="sort";
		$obj->where="module='product' AND (ctrl&1=1)";
		$obj->limit="all";
		$sql=$obj->sqlSelect();
				
		$obj=new menuLevel();
		$obj->sql=$sql;				
		$arr=$obj->orderMenu();			
		return $arr;
	}
	//
	function about(){
		global $smarty,$db,$themeName,$lable,$lang;		
		
		if($lang=='vn'){
			$id=138;
		}else{
			$id=50;
		}
		$sql="SELECT * FROM sys_htmlpage WHERE (ctrl&1=1) AND (id=$id)";		
		$rs=$db->Execute($sql);
		
		if($lang=='vn'){
			$about=strstrimtempworldwide($rs->fields("content"),30);
		}else{
			$about=strstrimtempworldwide($rs->fields("content"),30);
		}
		$about=$rs->fields("content");
		$smarty->assign('Detail',$lable->_("Detail"));
		$smarty->assign('About_us',$lable->_("About us"));		
		$smarty->assign('about',$about);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/AboutHome.tpl','AboutHome_'.$themeName);
	}
	//
	function videoHome(){	
		global $smarty,$lable,$themeName,$db,$lang;
		$sql="SELECT * FROM sys_video";
		//$sql.=" WHERE (ctrl&1=1) AND (lang='$lang')";
		$sql.=" WHERE (ctrl&1=1)";
		$sql.=" ORDER BY no ASC LIMIT 0,3";
		$arr=$db->GetAssoc($sql);
					
		$clip=getParam("clip");
		$smarty->assign('theme',$themeName);
		$smarty->assign('arr',$arr);
		$smarty->assign('clip',$clip);
		$smarty->assign('Advertise',$lable->_("Advertise"));	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/video.tpl','video_');	
	}
	//
	function advertiseHome(){	
		global $smarty,$lable,$themeName,$db,$lang;
		$sql="SELECT * FROM sys_advertise";
		$sql.=" WHERE (ctrl&1=1) AND (position='2') AND (lang='$lang')";
		$sql.=" ORDER BY no ASC LIMIT 0,1";
		$arr=$db->GetAssoc($sql);
		$smarty->assign('theme',$themeName);
		$smarty->assign('arr',$arr);
		$smarty->assign('Advertise',$lable->_("Advertise"));	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseCenter.tpl','advertiseLeft_');	
	}
	//
?>