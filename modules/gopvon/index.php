<?php
	$id=getParam(id);	
	if($id) $op="detail";	
	$idF=getparamFID(getParam(idF),false);		
	switch ($op){		
		case "gopvon_hang"	: 	gopvon_hang();break;
		case "detail"		: 	gopvon_detail();break;
		case "add_basket"		: 	add_basket();break;
		case "insertFaqarticle"	:	insertFaqarticle(); break;
		default 			:	mainShow(); break;
	}
		
	function mainShow()
	{		
		include_once("header.php");
		global $smarty, $lable,$arr_info_page,$db;
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$idF=getparamFID(getParam(idF),false);
		include_once("modules/gopvon/menuCenterSanpham.php");
		$smarty->registerPlugin("function","menuCenterSanpham","menuCenterSanpham");
		include_once("modules/gopvon/menuCenterSanphamSub.php");
		$smarty->registerPlugin("function","menuCenterSanphamSub","menuCenterSanphamSub");
		if($idF=='1'){
		
			$hsx= getParam("hsx");
			$tech=getParam("tech");	
			$sory_by=getParam("sort_by");
			$limit=getParam("limit");
			
		
			$smarty->assign('url_sort_by',getFunctionNameID($idF,"htaccess"));		
			$smarty->assign('hsx',$hsx);
			$smarty->assign('tech',$tech);
			$smarty->assign('sort_by',$sory_by);
			$smarty->assign('limit',$limit);
			
			$smarty->assign('img2',getFunctionNameID($idF,"img2"));
			$smarty->assign('des',getFunctionNameID($idF,"des"));
			$smarty->assign('name',getFunctionNameID($idF,"name"));
			$smarty->assign('nameFun',getFunctionNameSub($idF));
			
			
			$smarty->assign('Compare',$lable->_("Compare"));		
			$smarty->assign('Sort_by',$lable->_("Sort by"));
			
			$smarty->assign('Price_low_to_high',$lable->_("Price low to high"));
			$smarty->assign('Price_high_to_low',$lable->_("Price high to low"));
			$smarty->assign('New_gopvons',$lable->_("New gopvons"));
			$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
			$smarty->assign('More',$lable->_("More"));
			$smarty->assign('quality_certificate',$lable->_("quality certificate"));
			
			$smarty->registerPlugin("function","gopvon_list_all", "gopvon_list_all");		
			
			
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvonMainAll.tpl','gopvonMainAll_');
		
		}else{
		
			$hsx= getParam("hsx");
			$tech=getParam("tech");	
			$sory_by=getParam("sort_by");			
			$limit=getParam("limit");			
		
			$smarty->assign('url_sort_by',getFunctionNameID($idF,"htaccess"));		
			$smarty->assign('hsx',$hsx);
			$smarty->assign('tech',$tech);
			$smarty->assign('sort_by',$sory_by);
			$smarty->assign('limit',$limit);
			
					
			$smarty->assign('img2',getFunctionNameID($idF,"img2"));
			$smarty->assign('des',getFunctionNameID($idF,"des"));
			$smarty->assign('name',getFunctionNameID($idF,"name"));
			$smarty->assign('nameFun',getFunctionNameSub($idF));
			
			
			$smarty->assign('Compare',$lable->_("Compare"));		
			$smarty->assign('Sort_by',$lable->_("Sort by"));
			
			$smarty->assign('Price_low_to_high',$lable->_("Price low to high"));
			$smarty->assign('Price_high_to_low',$lable->_("Price high to low"));
			$smarty->assign('New_gopvons',$lable->_("New gopvons"));
			$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
			$smarty->assign('More',$lable->_("More"));
			$smarty->assign('quality_certificate',$lable->_("quality certificate"));
			
			$smarty->registerPlugin("function","gopvon_list", "gopvon_list");		
			
			
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvonMain.tpl','gopvonMain_');
		}	
		include_once("footer.php");
	}
	//
	//
	function gopvon_detail(){
		global $smarty,$lable, $themeName;
		include_once("header.php");		
		$username=getSession("username");
		$cmt=getMemberNameID($username,"cmt");
		$smarty->assign('cmt',$cmt);
		
		$idF=getparamFID(getParam(idF),false);	
		
		//$gopvon_id=getParam(_ID_PRODUCT);
		$gopvon_id=getParam(id);		
		$arr=get_gopvon_id($gopvon_id);	
		
		$arrColor=getgopvonListPhoto($arr["id"]);	
		$arrFaq=getgopvonListFaq($arr["id"]);
		
		$arrmausac=searchmausac($arr["id"]);
		$arrkichco=searchkichco($arr["id"]);
		//print_r($arrColor);
		
		if(count($arrColor)){
			//$smarty->assign('arr',$arr);
			//print_r($arr);			
			$str="<script>\n";
			$str.=" var imgArray=[";
			foreach ($arrColor as $key=>$value){
				$sStr.="'"._DOMAIN_ROOT_URL."/img/gopvon/".$value["img"]."$$$',";	
			}
			$str.= $sStr;
			$str.= "'"._DOMAIN_ROOT_URL."/img/gopvon/note.gif$$$'];\n </script>";
			echo $str;
		}
		
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('arrFaq',$arrFaq);
		$smarty->assign('num',$num);
		
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->assign('email',getSession("email"));
		$smarty->assign('ymsupport',getSession("ymsupport"));
		
		$smarty->assign('skype',getSession("skype"));
		$smarty->assign('tel',getSession("tel"));
				
		$smarty->assign('arr',$arr);
		$smarty->registerPlugin("function","gopvonRelation", "gopvonRelation");
		$smarty->registerPlugin("function","articleRelation", "articleRelation");
		$smarty->registerPlugin("function","add_basket", "add_basket");
		
		
		$smarty->assign("arrmausac", $arrmausac);	
		$smarty->assign("arrkichco",$arrkichco);
		
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		$smarty->assign('Origin',$lable->_("Origin"));
		$smarty->assign('quality_certificate',$lable->_("Quality certificate"));
		
		$smarty->assign('gopvonRelation',$lable->_("gopvon Relation"));
		$smarty->assign('Zoom',$lable->_("Zoom"));
		$smarty->assign('promotional',$lable->_("Promotional"));
		$smarty->assign('price',$lable->_("Price"));
		$smarty->assign('Model',$lable->_("Model"));
		
		$smarty->assign('themeName',$themeName);
		
		include_once("modules/gopvon/menuCenterSanpham.php");
		$smarty->registerPlugin("function","menuCenterSanpham","menuCenterSanpham");
		include_once("modules/gopvon/menuCenterSanphamSub.php");
		$smarty->registerPlugin("function","menuCenterSanphamSub","menuCenterSanphamSub");
		
		$urlfb=_DOMAIN_ROOT_URL."/".$arr_info_page["url"]."/".$gopvon_id;
		$smarty->assign('urlfb',$urlfb);
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_detail.tpl','gopvon_detail_');	
		include_once("footer.php");
	}
	//
	//	
	function gopvonRelation(){
		global $smarty,$lable,$themeName,$arr_info_page;
		$idgopvon=getParam(id);
		
		//$idF=getparamFID(getParam(idF),false);	
		
		if(!$idF=getParam("submenu")) $idF=getparamFID(getParam(idF),false);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=6;
		
		$arr=get_gopvon_list($idF);
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		$smarty->assign('idgopvon',$idgopvon);	
		
		$smarty->assign('More',$lable->_("More"));
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvonRelation.tpl','gopvonRelation_');
	}
	//
	//	
	function articleRelation(){
		global $smarty,$lable,$themeName,$arr_info_page;
		
		$gopvon_id=getParam(id);		
		$arr=get_gopvon_id($gopvon_id);	
		
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=4;
		
		$arr=articleListID($arr["name"]);
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		$smarty->assign('idgopvon',$idgopvon);	
		
		$smarty->assign('More',$lable->_("More"));
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articlegopvonRelation.tpl','articlegopvonRelation_');
	}
	//
	function searchmausac($id_gopvon){
		global $smarty,$lable,$themeName,$arr_info_page,$db;	
		if(!$id_gopvon) return;
		if($id_gopvon){
			$sql="SELECT * FROM sys_gopvon WHERE id='$id_gopvon'";
			$rs=$db->Execute($sql);
			$manufacturers=$rs->fields("manufacturers");
			$manufacturers=explode(":", $manufacturers);		
			if($manufacturers){
					foreach($manufacturers as $keys=>$values){
						$arr_manufacturers[$values]=$values;
					}
				}
			}	
			$sql="SELECT * FROM hang_san_xuat ORDER BY sort ASC";
			$arr=$db->GetAssoc($sql);	
		
			if(!$arr) return;
		
			foreach($arr as $key=>$value){
				
					if($arr_manufacturers[$value["id"]]){	
						$arrmau[]=$arr[$key];
					//	$output.='<img class="btn" color="'.$value["name"].'" src="'._DOMAIN_ROOT_URL.'/images/logo/'.$value["logo"].'" width="20px" alt="'.$value["name"].'" />&nbsp;';
						}
					//	else $output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="manufacturers[]" value="'.$value["id"].'" />&nbsp;<img src=""'._DOMAIN_ROOT_URL.'"/images/logo/'.$value["logo"].'" width="20px" />&nbsp;'.$value["name"].'</div>';
				
			}	
		return $arrmau;			
	}
	//
	function searchkichco($id_gopvon){
		global $smarty,$lable,$themeName,$arr_info_page,$db;	
		if(!$id_gopvon) return;
		if($id_gopvon){
			$sql="SELECT * FROM sys_gopvon WHERE id='$id_gopvon'";
			$rs=$db->Execute($sql);
			$xuatsu=$rs->fields("xuatsu");
			$xuatsu=explode(":", $xuatsu);		
			if($xuatsu){
				foreach($xuatsu as $keys=>$values){
					$arr_xuatsu[$values]=$values;
				}
			}
		}		
			$sql="SELECT * FROM xuat_su ORDER BY sort ASC";		
			$arr=$db->GetAssoc($sql);			
			if(!$arr) return;		
			foreach($arr as $key=>$value){				
					if($arr_xuatsu[$value["id"]]){	
						$arrkichco[]=$arr[$key];					
						}
			}		
		
		return $arrkichco;			
	}
	
	//
	function gopvonListID($fid,$number_rows,$pageid){
		global $db,$lang;
		if(!$pageid or $pageid==1) $pageid=1;
		$start=($pageid-1)*$number_rows;
		$idgopvon=getParam(id);
		
		$sql="SELECT sys_gopvon.*";
		$sql.=" FROM sys_gopvon";
		$sql.=" WHERE sys_gopvon.catID =  '$fid' AND (sys_gopvon.ctrl&1=1) AND (sys_gopvon.alias<>'$idgopvon') AND (sys_gopvon.lang = '$lang')";
		$sql.=" ORDER BY sys_gopvon.date_create DESC LIMIT ".$start.",".$number_rows;
		
		$arr=$db->GetAssoc($sql);	
		return $arr;
	}	
	//
	/**
	 * danh sach san pham da xem
	 *
	 * @param unknown_type $gopvon_id
	 */	
	/**
	 * Hien thi danh sach cac hang theo chuc nang
	 *
	 */
	function manufacturers_of_function_ID()
	{
		global $smarty,$idF, $lable;		
		
		$hsx= getParam("hsx");
		
		$arr=get_manufacturers_of_function_ID($idF);	
		if(!$arr) return;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('hsx',$hsx);
		$smarty->assign('url',url_value(true));		
		
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		
		$smarty->registerPlugin("function","remote_url", "remote_url");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_manufacturers.tpl','gopvon_manufacturers');
	}
	/**
	 * Hien thi danh sach tieu chi tim kiem theo chuc nang
	 */
	function technicalList(){
		global $smarty,$idF;
		$arr=get_technicalList($idF);
		
		if(!$arr) return;
		
		$tech=getParam("tech");
		$hsx= getParam("hsx");
		
		$arr_techs=explode(":", $tech);
		if($arr_techs)
		{
			foreach($arr_techs as $key => $value)
			{
				if($value)
				{
					$parent=$arr[$value]["parent"];
					if($parent) $arr_tech[$parent]=$value;
				}
			}
		}		
		
		$smarty->assign('url',url_value(false));
		$smarty->assign('arr',$arr);
		$smarty->assign('arr_tech',$arr_tech);
		
		$smarty->registerPlugin("function","remote_url", "remote_url");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_technical.tpl','gopvon_technical');
		unset($arr_techs);
		unset($arr);
		unset($arr_tech);
	}
	/**
	 * danh sach san pham
	 */
	function gopvon_list()
	{
		global $smarty,$idF, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$sort_by=getParam("sort_by");
		$limit=getParam("limit");
		if(!$limit) $limit=12;
		
		$arr=get_gopvon_list($idF);
		
		$numberRecord=count($arr);
		//echo $numberRecord;		
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Details"));
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_list.tpl','gopvon_list_');
	}
	//
	function gopvon_list_all()
	{
		global $smarty,$idF, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=24;
		
		$arr=get_gopvon_list_all();
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Dosage',$lable->_("Dosage"));
		$smarty->assign('Package',$lable->_("Package"));
		$smarty->assign('Detail',$lable->_("Detail"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_list_all.tpl','gopvon_list_all_');
	}
	//
	function url_value($fix)
	{
		global $arr_info_page;
		$url=_DOMAIN_ROOT_URL.'/'.$arr_info_page["url"];
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		
		if($fix)
		{
			if(!$hsx & !$tech) $url.="hsx=";
			if($tech) $url.="tech=".$tech."&hsx=";	
		}
		else 
		{	
			if($hsx) $url.="hsx=".$hsx."&";
			$url.="tech=";
			
			if($tech)
			{
				$arr_tech=explode(":", $tech);
				if(count($arr_tech))
				{
					foreach($arr_tech as $key=>$value)
					{
						if((int)$value>0)
						{
							$url.=":".$value.":";
						}
					}
				}
			}			
		}		
		return $url;
	}
	//
	function remote_url($id)
	{
		global $arr_info_page;
		$url=_DOMAIN_ROOT_URL.'/'.$arr_info_page["url"];
		$hsx= getParam("hsx");
		$tech=getParam("tech");			
		$id=$id["id"];
		if($id==0)
		{
			$url.="tech=".$tech;
		}
		else 
		{
			if($hsx) $url.="hsx=".$hsx;
			$arr_tech=explode(":", $tech);
			if(count($arr_tech) > 3)
			{
				$url.="&tech=";
			}
			if($tech)
			{
				$arr_tech=explode(":", $tech);
				if(count($arr_tech))
				{
					foreach($arr_tech as $key=>$value)
					{
						if(((int)$value > 0) and ($value!=$id))
						{
							$url.=":".$value.":";
						}
					}
				}
			}			
		}
		return $url;
	}
	//
	function gopvon_hang()
	{
		include_once("header.php");
		global $smarty,$idF, $lable,$arr_info_page,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		
		
		$hsx=getParam("hsx");
		
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.model, sys_gopvon.delivery, sys_gopvon.promotion, hang_san_xuat.logo, TO_DAYS(sys_gopvon.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_gopvon , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_gopvon.catID =  sys_function.id) AND (sys_gopvon.hang_san_xuat =  hang_san_xuat.id)  AND (sys_gopvon.hang_san_xuat = '".$hsx."') AND (sys_gopvon.ctrl&1=1)";				
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=16;
		//echo $sql;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		//$arr=get_gopvon_hang($hsx);			
		//$numberRecord=count($arr);
		//echo $numberRecord;
		
		$smarty->assign('arr',$arr);
		//$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/?".$arr_info_page["url"],$numberRecord,$limit,$pageID));
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/san_pham_hang_".$hsx,$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/gopvon_list.tpl','gopvon_list_');
		include_once("footer.php");
	}	
	//
	function insertFaqarticle(){
		
		global $db,$lang;	
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");	
		$email=getParamPost("email");	
		$address=getParamPost("address");
		$question=getParamPost("question");	
		$proid=getParamPost("proid");		
		$chatluong=getParamPost("chatluong");
		$hinhdang=getParamPost("hinhdang");	
		$gia=getParamPost("gia");		
		
		$record=array();
		$record["name"]=$name;
		$record["email"]=$email;
		$record["address"]=$address;
		$record["question"]=$question;
		$record["proid"]=$proid;		
		$record["chatluong"]=$chatluong;
		$record["hinhdang"]=$hinhdang;
		$record["gia"]=$gia;
		$record["lang"]=$lang;		
		
		$sql = "SELECT * FROM sys_commentgopvon WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);
		
		
		//////	
		if(!$return){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"color:#016434; padding:40px; padding-top:80px\" align=\"center\">Có lỗi sảy ra!</td>
				  </tr>				 
				</table>";
		}else{
			if($lang=='vn'){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"padding:40px; padding-top:80px\" align=\"center\">Cám ơn nhận xét của quý khách. Nhận xét sẽ hiển thị sau khi được thông qua.</td>
				  </tr>				  
				</table>";
			}else{
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"padding:40px; padding-top:80px\" align=\"center\">We have received your comment! Thank you!</td>
				  </tr>				  
				</table>";
			}	
		}	
	}
	
	function add_basket(){		
		global $smarty,$lang,$lable;
		
		$gopvon_id=getParamPost("gopvon_id");
		$color=getParamPost("color");
		$size=getParamPost("size");
		
		$txt_add_basket=getParamPost("qty");
		
		echo "abc".$size;
		return;
		if(!$txt_add_basket) $txt_add_basket=1;
		
		if($gopvon_id){
			if (!$_SESSION["basket"]){
				session_register("basket");
				$_SESSION["basket"] = array();
			}
	
			if($_SESSION["basket"][$gopvon_id]){
				$_SESSION["basket"][$gopvon_id]["quantity"]=$_SESSION["basket"][$gopvon_id]["quantity"] + $txt_add_basket;
			}else{	
				$_SESSION["basket"][$gopvon_id]=array(				
					"quantity"=>(int)$txt_add_basket				
				);
			}
		}		
		$output=$lable->_("Added to cart");
		echo "<a href=\"/view_basket/\" class=\"content\" style=\"color:#FF0000\" >".$output."</a>";	
	}	
?>