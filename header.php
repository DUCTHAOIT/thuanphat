<?php
	global $themeName, $smarty, $lable,$lang, $moduleName,$arr_info_page,$arr_info_title, $db, $hide_slide;
	$username=getSession("username");
	$login_time_stamp=getSession("login_time_stamp");
	$thoigian=time();
	$affiliate_id = getParam("aff");
	if($username)  
	{ 
		if($thoigian-$login_time_stamp >3600)   
		{ 
			session_unset(); 
			session_destroy(); 
			setSession("username","");
		}else{
			setSession("login_time_stamp",time());
		}
		
	}else{
		
		if($affiliate_id){
			setcookie("affiliate_id", $affiliate_id, time() + (8640 * 30), "/");
		}
		$smarty->assign('affiliate_id',$affiliate_id);	
	}
	
	if(isset($_COOKIE['affiliate_id'])) {
	   $affiliate_id = $_COOKIE['affiliate_id'];
	   $smarty->assign('affiliate_id',$affiliate_id);
	}
		
	$smarty->assign('username',$username);
	$MemberName=getMemberNameID($username,"name");
	$MemberEmail=getMemberNameID($username,"username");
	$Membermobile=getMemberNameID($username,"mobile");
	$Memberloai=getMemberNameID($username,"loai");
	$MemberHlv=getMemberNameID($username,"permit");
	
	$smarty->assign('MemberName',$MemberName);
	$smarty->assign('MemberEmail',$MemberEmail);
	$smarty->assign('Membermobile',$Membermobile);
	$smarty->assign('Memberloai',$Memberloai);
	$smarty->assign('MemberHlv',$MemberHlv);
	
	$MemberID=getMemberNameID($username,"id");
	$smarty->assign('MemberID',$MemberID);

	$idF=getparamFID(getParam(idF),true);
	if($idF){
		$themeName=getFunctionNameID($idF,"theme");
		$smarty->assign('imgheader',getFunctionNameID($idF,"img1"));
	
		$idFsub=getparamFID(getParam(idF),false);
		$imgtop=getFunctionNameID($idFsub,"img2");
		if(!$imgtop){ $imgtop=getFunctionNameID($idF,"img2");}
		
		$smarty->assign('imgtop',$imgtop);
	}else{
		if(!$themeName) $themeName="default";
	}

	$arr_info_page=info_page();
	$arr_info_title=info_title();

	if(!$themeName) $themeName="default";

	include_once("theme/$themeName/theme.php");	
	include_once("modules/basket/lib.php");
    $smarty->registerPlugin("function","basket_block", "basket_block");


	$sql="SELECT * FROM sys_config WHERE (name='tel') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$tel=$rs->fields('value');
	
	$sql="SELECT * FROM sys_config WHERE (name='skype') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$skype=$rs->fields('value');
	
	$sql="SELECT * FROM sys_config WHERE (name='email') AND (lang='$lang')";
	$rs=$db->Execute($sql);		
	$email=$rs->fields('value');
	
	
	include_once("modules/control/slide.php");
	$smarty->registerPlugin("function","slide", "slide");

	
	$sql="SELECT * FROM sys_advertise";
	$sql.=" WHERE (ctrl&1=1) AND (position='1') AND (lang='$lang')";
	$sql.=" ORDER BY no ASC LIMIT 0,1";
	$rs=$db->Execute($sql);
	$logo=$rs->fields("img");
	
	$sql="SELECT * FROM sys_advertise";
	$sql.=" WHERE (ctrl&1=1) AND (position='0') AND (lang='$lang')";
	$sql.=" ORDER BY no ASC LIMIT 0,1";
	$rs=$db->Execute($sql);
	$imgbanner=$rs->fields("img");



	
	$smarty->registerPlugin("function","format_number", "format_number");
	$smarty->registerPlugin("function","format_number2", "format_number2");
	$smarty->assign('charset',_CHARSET);
	
	$smarty->assign('keywords',$arr_info_title["keywords"]);	
	$smarty->assign('description',$arr_info_title["description"]);
	$smarty->assign('imgfb',$arr_info_title["img"]);	
	$smarty->assign('title',$arr_info_title["title"]);
	
//	$smarty->assign('description',getSession("site_name"));
	$smarty->assign('ymsupport',getSession("ymsupport"));
	$smarty->assign('theme',$themeName);	
	$smarty->assign('lang',$lang);	
	$smarty->assign('moduleName',$moduleName);	
	$smarty->assign('logo',$logo);	
	$smarty->assign('idF',$idF);	
	$smarty->assign('tel',$tel);	
	$smarty->assign('skype',$skype);	
	$smarty->assign('email',$email);
	$smarty->assign('product_id',$product_id);


	//$smarty->registerPlugin("function","menu_more", "menu_more");
	//$smarty->registerPlugin("function","topMenu", "topMenu");
	//$smarty->registerPlugin("function","topMenu_duongmn", "topMenu_duongmn");
	$smarty->registerPlugin("function","topMenucap2", "topMenucap2");	
	$smarty->registerPlugin("function","topMenucap2mobile", "topMenucap2mobile");	
	$smarty->registerPlugin("function","viewLanguage", "viewLanguage");
	$smarty->registerPlugin("function","viewLanguage_mobile", "viewLanguage_mobile");		
	$smarty->registerPlugin("function","leftBlock", "leftBlock");
	$smarty->registerPlugin("function","TimeCX", "TimeCX");
	$smarty->registerPlugin("function","datevn", "datevn");
	
	
	$smarty->assign('Product_name',$lable->_("Product name"));
	$smarty->assign('Product_group',$lable->_("Product group"));
	$smarty->assign('Date',$lable->_("Date"));
	$smarty->assign('Search',$lable->_("Search"));
	$smarty->assign('Keywords',$lable->_("Keywords"));

	$smarty->assign('hide_slide', !empty($hide_slide));

	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/header.tpl','header_'.$lang);
	
	function info_page(){
		//$id=getParam("idF");	
		$id=getparamFID(getParam(idF),false);	
		global $db,$lang;
		
		if($id)
		{
			$sql="SELECT name as title, ".getSession("rewrite_url")." as url, parent FROM sys_function WHERE id='$id'";
			$rs=$db->Execute($sql);
			$arr=$rs->fields;
		}
		else 
		{
			//$arr["title"]=getSession("web_title");
			$sql="SELECT * FROM sys_config WHERE (name='web_title') AND (lang='$lang')";
			$rs=$db->Execute($sql);
			$arr=$rs->fields('value');			
			
		}
		return $arr;
	}
	//
	//
	function info_title(){
		global $db,$lang;
		$product_id=getParam("id");
		
		if(!$product_id){
			$id=getparamFID(getParam("idF"),false);
			if($id)
			{
				$sql="SELECT name as title, keywords, description, title as title2,img1 FROM sys_function WHERE id='$id'";
				
				$rs=$db->Execute($sql);
				if(!$rs->fields('title2')){$arr["title"]=$rs->fields('title');}else{$arr["title"]=$rs->fields('title2');}
				
				if(!$rs->fields('keywords')){
					$sql="SELECT * FROM sys_config WHERE (name='meta_keys') AND (lang='$lang')";
					$rs=$db->Execute($sql);
					$arr["keywords"]=$rs->fields('value');					
				}else{
					$arr["keywords"]=$rs->fields('keywords');	
				}
				if(!$rs->fields('description')){
					$sql="SELECT * FROM sys_config WHERE (name='site_name') AND (lang='$lang')";
					$rs=$db->Execute($sql);
					$arr["description"]=$rs->fields('value');
				}else{
					$arr["description"]=$rs->fields('description');	
				}
				
				if($rs->fields('img1')){
					$arr["img"]="images/function/".$rs->fields('img1');	
				}else{
					$arr["img"]="theme/default/images/header/logo.png";
				}
				
				
			}
			else 
			{
				//$arr["title"]=getSession("web_title");			
				$sql="SELECT * FROM sys_config WHERE (name='web_title') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["title"]=$rs->fields('value');
				
				$sql="SELECT * FROM sys_config WHERE (name='meta_keys') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["keywords"]=$rs->fields('value');
				
				$sql="SELECT * FROM sys_config WHERE (name='site_name') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["description"]=$rs->fields('value');
				
				$arr["img"]="theme/default/images/header/logo.png";
			}
		}else{
				$sql_news="SELECT * FROM sys_article WHERE alias='$product_id'";
				$rs_news=$db->Execute($sql_news);
				$alia_news = str_replace("-", " ", str_replace("&*#39;","",$rs_news->fields("alias")));

				$sql_partner="SELECT * FROM sys_worldwide WHERE alias='$product_id'";
				$rs_partner=$db->Execute($sql_partner);
				$alia_partner = str_replace("-", " ", str_replace("&*#39;","",$rs_partner->fields("alias")));
				
				$sql="SELECT * FROM sys_product WHERE alias='$product_id'";
				$rs=$db->Execute($sql);
				
				$alia = str_replace("-", " ", str_replace("&*#39;","",$rs->fields("alias")));
				
				if($rs_news->fields("name")){
					//$arr["title"]=$rs_news->fields("name")." | ".$alia_news;		
					$arr["title"]=$rs_news->fields("name");
				}else{
					if($rs_partner->fields("name")){
						//$arr["title"]=$rs_partner->fields("name")." | ".$alia_partner;	
						$arr["title"]=$rs_partner->fields("name");	
					}else{					
						//$arr["title"]=$rs->fields("name")." | ".$alia;	
						$arr["title"]=$rs->fields("name");		
					}	
				}	
				//
				if($rs_news->fields("summary")){
					//$arr["title"]=$rs_news->fields("name")." | ".$alia_news;		
					$arr["keywords"]=$rs_news->fields("summary");
				}else{
					if($rs_partner->fields("summary")){
						//$arr["title"]=$rs_partner->fields("name")." | ".$alia_partner;	
						$arr["keywords"]=$rs_partner->fields("summary");	
					}else{					
						//$arr["title"]=$rs->fields("name")." | ".$alia;	
						if($rs->fields("summary")){
						$arr["keywords"]=$rs->fields("summary");		
						}else{
							$sql="SELECT * FROM sys_config WHERE (name='meta_keys') AND (lang='$lang')";
							$rscf=$db->Execute($sql);
							$arr["keywords"]=$rscf->fields('value');		
						}		
					}	
				}	
				//
				//
				if($rs_news->fields("description")){
					//$arr["title"]=$rs_news->fields("name")." | ".$alia_news;		
					$arr["description"]=$rs_news->fields("description");
				}else{
					if($rs_partner->fields("description")){
						//$arr["title"]=$rs_partner->fields("name")." | ".$alia_partner;	
						$arr["description"]=$rs_partner->fields("description");	
					}else{					
						//$arr["title"]=$rs->fields("name")." | ".$alia;	
						if($rs->fields("description")){
						$arr["description"]=$rs->fields("description");		
						}else{
							$sql="SELECT * FROM sys_config WHERE (name='site_name') AND (lang='$lang')";
							$rscf=$db->Execute($sql);
							$arr["description"]=$rscf->fields('value');		
						}
					}	
				}	
				//
				if($rs_news->fields("img")){
					//$arr["title"]=$rs_news->fields("name")." | ".$alia_news;		
					$arr["img"]="images/article/".$rs_news->fields("img");
				}else{
					if($rs_partner->fields("img")){
						//$arr["title"]=$rs_partner->fields("name")." | ".$alia_partner;	
						$arr["img"]="images/gopvon/".$rs_partner->fields("img");	
					}else{					
						//$arr["title"]=$rs->fields("name")." | ".$alia;	
						if($rs->fields("img")){
							$arr["img"]="images/product/".$rs->fields("img");
						}else{
							$arr["img"]="theme/default/images/header/logo.png";		
						}
					}	
				}	
				if($arr["title"]==''){
					//$arr["title"]=getSession("web_title");			
				$sql="SELECT * FROM sys_config WHERE (name='web_title') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["title"]=$rs->fields('value');
				
				$sql="SELECT * FROM sys_config WHERE (name='meta_keys') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["keywords"]=$rs->fields('value');
				
				$sql="SELECT * FROM sys_config WHERE (name='site_name') AND (lang='$lang')";
				$rs=$db->Execute($sql);
				$arr["description"]=$rs->fields('value');
				
				$arr["img"]="theme/default/images/header/logo.png";
				}
			
			
		}	
		return $arr;	
	}
	//
	//
	function menu_more()
	{
		global $smarty;
		$arr=get_more_menu();
		$smarty->assign('arr',$arr);
		//$smarty->assign('hotline',getSession("hotline"));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menu_more.tpl','index_');
	}
	//
	function datevn(){
		$ngay_gio_hien_tai=time();	
	//	echo $ngay_gio_hien_tai."-";	
		$arr_thu=array(1 => "Thứ 2", 2 => "Thứ 3", 3 => "Thứ 4", 4 => "Thứ 5" ,5 => "Thứ 6" ,6 => "Thứ 7" ,7 => "CN");
		echo "". $arr_thu[date("N",$ngay_gio_hien_tai)].", ".date("j",$ngay_gio_hien_tai)."/".date("n",$ngay_gio_hien_tai)."/".date("Y",$ngay_gio_hien_tai).", ".date("H",$ngay_gio_hien_tai).":".date("i",$ngay_gio_hien_tai).":".date("s",$ngay_gio_hien_tai)."";
		
	}
	//
	//
	function special_promotion()
	{
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.img1, sys_product.alias, sys_product.model, sys_product.delivery, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.lang='$lang') AND (sys_product.ctrl&1=1) AND (sys_product.special_promotion=1)";
		$sql.=" ORDER BY today DESC";
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);	
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=4;	
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign("Special_promotion",$lable->_("Special promotion"));
		$smarty->assign("Product_Focus",$lable->_("Products from United Ngoc Lan"));
		
		$smarty->registerPlugin("function","strstrimtemp","strstrimtemp");
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_special_promotion.tpl','product_special_promotion_');
	}
	function htmlfun(){
		global $smarty,$db,$themeName,$lable,$lang;		
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (img1>'0') AND (ctrl&17=17) AND (module='htmlpage')  ORDER BY sort ASC LIMIT 0,3";		
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);	
			
		//$smarty->registerPlugin("function","strstrimtemp","strstrimtemp");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/htmlfun.tpl','htmlfun_'.$themeName);
	}
?>