<?php
	$id=getParam(id);	
	if($id) $op="detail";	
	$idF=getparamFID(getParam(idF),false);		
	switch ($op){		
		case "product_hang"	: 	product_hang();break;
		case "detail"		: 	product_detail();break;
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
		include_once("modules/product/menuCenterSanpham.php");
		$smarty->registerPlugin("function","menuCenterSanpham","menuCenterSanpham");
		include_once("modules/product/menuCenterSanphamSub.php");
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
			$smarty->assign('New_products',$lable->_("New products"));
			$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
			$smarty->assign('More',$lable->_("More"));
			$smarty->assign('quality_certificate',$lable->_("quality certificate"));
			
			$smarty->registerPlugin("function","product_list_all", "product_list_all");		
			
			
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productMainAll.tpl','productMainAll_');
		
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
			$smarty->assign('New_products',$lable->_("New products"));
			$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
			$smarty->assign('More',$lable->_("More"));
			$smarty->assign('quality_certificate',$lable->_("quality certificate"));
			
			$smarty->registerPlugin("function","product_list", "product_list");		
			
			
			
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productMain.tpl','productMain_');
		}	
		include_once("footer.php");
	}
	//
	//
	function product_detail(){
		global $smarty,$lable, $themeName;
		include_once("header.php");		
		$username=getSession("username");
		$cmt=getMemberNameID($username,"cmt");
		$smarty->assign('cmt',$cmt);
		
		$idF=getparamFID(getParam(idF),false);	
		
		$nguoigioithieu=getParam(aff);
		//echo $u;
		$product_id=getParam(id);		
		$arr=get_product_id($product_id);	
		
		$arrColor=getProductListPhoto($arr["id"]);
        $arrreview=getProductListreview($arr["id"]);
        $total_review=count($arrreview);
        $total_user_rating=gettotalProductListreview($arr["id"]);
        $average_rating = $total_user_rating / $total_review;
		
		$arrmausac=searchmausac($arr["id"]);
		$arrkichco=searchkichco($arr["id"]);
		//print_r($arrColor);
		
		if(count($arrColor)){
			//$smarty->assign('arr',$arr);
			//print_r($arr);			
			$str="<script>\n";
			$str.=" var imgArray=[";
			foreach ($arrColor as $key=>$value){
				$sStr.="'"._DOMAIN_ROOT_URL."/img/product/".$value["img"]."$$$',";	
			}
			$str.= $sStr;
			$str.= "'"._DOMAIN_ROOT_URL."/img/product/note.gif$$$'];\n </script>";
			echo $str;
		}
		
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('num',$num);
        $smarty->assign('arrreview',$arrreview);
        $smarty->assign('average_rating',$average_rating);
        $smarty->assign('total_user_rating',$total_user_rating);
        $smarty->assign('total_review',$total_review);

		$smarty->assign('nguoigioithieu',$nguoigioithieu);
		
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->assign('email',getSession("email"));
		$smarty->assign('ymsupport',getSession("ymsupport"));
		
		$smarty->assign('skype',getSession("skype"));
		$smarty->assign('tel',getSession("tel"));
				
		$smarty->assign('arr',$arr);
		$smarty->registerPlugin("function","productRelation", "productRelation");
		$smarty->registerPlugin("function","articleRelation", "articleRelation");
		$smarty->registerPlugin("function","add_basket", "add_basket");
		
		
		$smarty->assign("arrmausac", $arrmausac);	
		$smarty->assign("arrkichco",$arrkichco);
		
		$smarty->assign('Manufacturers',$lable->_("Manufacturers"));
		$smarty->assign('Origin',$lable->_("Origin"));
		$smarty->assign('quality_certificate',$lable->_("Quality certificate"));
		
		$smarty->assign('ProductRelation',$lable->_("Product Relation"));
		$smarty->assign('Zoom',$lable->_("Zoom"));
		$smarty->assign('promotional',$lable->_("Promotional"));
		$smarty->assign('price',$lable->_("Price"));
		$smarty->assign('Model',$lable->_("Model"));
		
		$smarty->assign('themeName',$themeName);
		
		include_once("modules/product/producthlv.php");
		$smarty->registerPlugin("function","producthlv","producthlv");
		$smarty->registerPlugin("function","diendanmo","diendanmo");
		
		$urlfb=_DOMAIN_ROOT_URL."/".$arr_info_page["url"]."/".$product_id;
		$smarty->assign('urlfb',$urlfb);
		
		
		if($affiliate_id){
			$sqluser="SELECT * FROM user WHERE (email='$affiliate_id')";	
			$rsuser=$db->Execute($sqluser);	
			$loaiuser=$rsuser->fields("loai");
			$nameuser=$rsuser->fields("name");
			$smarty->assign('loaiuser',$loaiuser);
			$smarty->assign('nameuser',$nameuser);
		}
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_detail.tpl','product_detail_');	
		include_once("footer.php");
	}
	//
	//	
	function productRelation(){
		global $smarty,$lable,$themeName,$arr_info_page;
		$idProduct=getParam(id);
		
		//$idF=getparamFID(getParam(idF),false);	
		
		if(!$idF=getParam("submenu")) $idF=getparamFID(getParam(idF),false);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=6;
		
		$arr=get_product_list($idF);
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		$smarty->assign('idProduct',$idProduct);	
		
		$smarty->assign('More',$lable->_("More"));
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productRelation.tpl','productRelation_');
	}
	//
	//	
	function articleRelation(){
		global $smarty,$lable,$themeName,$arr_info_page;
		
		$product_id=getParam(id);		
		$arr=get_product_id($product_id);	
		
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=4;
		
		$arr=articleListID($arr["name"]);
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		$smarty->assign('idProduct',$idProduct);	
		
		$smarty->assign('More',$lable->_("More"));
		$smarty->registerPlugin("function","strstrimtemp", "strstrimtemp");		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/articleProductRelation.tpl','articleProductRelation_');
	}
	//
	function searchmausac($id_product){
		global $smarty,$lable,$themeName,$arr_info_page,$db;	
		if(!$id_product) return;
		if($id_product){
			$sql="SELECT * FROM sys_product WHERE id='$id_product'";
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
	function searchkichco($id_product){
		global $smarty,$lable,$themeName,$arr_info_page,$db;	
		if(!$id_product) return;
		if($id_product){
			$sql="SELECT * FROM sys_product WHERE id='$id_product'";
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
	function productListID($fid,$number_rows,$pageid){
		global $db,$lang;
		if(!$pageid or $pageid==1) $pageid=1;
		$start=($pageid-1)*$number_rows;
		$idProduct=getParam(id);
		
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product";
		$sql.=" WHERE sys_product.catID =  '$fid' AND (sys_product.ctrl&1=1) AND (sys_product.alias<>'$idProduct') AND (sys_product.lang = '$lang')";
		$sql.=" ORDER BY sys_product.date_create DESC LIMIT ".$start.",".$number_rows;
		
		$arr=$db->GetAssoc($sql);	
		return $arr;
	}	
	//
	/**
	 * danh sach san pham da xem
	 *
	 * @param unknown_type $product_id
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
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_manufacturers.tpl','product_manufacturers');
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
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_technical.tpl','product_technical');
		unset($arr_techs);
		unset($arr);
		unset($arr_tech);
	}
	/**
	 * danh sach san pham
	 */
	function product_list()
	{
		global $smarty,$idF, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$sort_by=getParam("sort_by");
		$limit=getParam("limit");
		if(!$limit) $limit=12;
		
		$arr=get_product_list($idF);
		
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list.tpl','product_list_');
	}
	//
	function product_list_all()
	{
		global $smarty,$idF, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=24;
		
		$arr=get_product_list_all();
		
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list_all.tpl','product_list_all_');
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
	function product_hang()
	{
		include_once("header.php");
		global $smarty,$idF, $lable,$arr_info_page,$db;
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=10;
		
		
		$hsx=getParam("hsx");
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.hang_san_xuat =  hang_san_xuat.id)  AND (sys_product.hang_san_xuat = '".$hsx."') AND (sys_product.ctrl&1=1)";				
		$arr=$db->GetAll($sql);
		$numberRecord=count($arr);
		
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=16;
		//echo $sql;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('limit',$limit);
		
		//$arr=get_product_hang($hsx);			
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_list.tpl','product_list_');
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
		
		$sql = "SELECT * FROM sys_commentproduct WHERE 0 = -1";
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
		
		$product_id=getParamPost("product_id");
		$color=getParamPost("color");
		$size=getParamPost("size");
		
		$txt_add_basket=getParamPost("qty");
		
		echo "abc".$size;
		return;
		if(!$txt_add_basket) $txt_add_basket=1;
		
		if($product_id){
			if (!$_SESSION["basket"]){
				session_register("basket");
				$_SESSION["basket"] = array();
			}
	
			if($_SESSION["basket"][$product_id]){
				$_SESSION["basket"][$product_id]["quantity"]=$_SESSION["basket"][$product_id]["quantity"] + $txt_add_basket;
			}else{	
				$_SESSION["basket"][$product_id]=array(				
					"quantity"=>(int)$txt_add_basket				
				);
			}
		}		
		$output=$lable->_("Added to cart");
		echo "<a href=\"/view_basket/\" class=\"content\" style=\"color:#FF0000\" >".$output."</a>";	
	}	
	
	//
	function diendanmo(){
		global $smarty,$db,$themeName,$lable,$lang;	
		//$sql="SELECT sys_worldwide.*, sys_function.htaccess FROM sys_worldwide,sys_function WHERE (sys_worldwide.catID =  sys_function.id) AND (sys_function.ctrl&1=1) AND (sys_worldwide.lang='$lang') AND (sys_worldwide.ctrl&1=1) ORDER BY sys_worldwide.no DESC LIMIT 0,10";	
		$sql="SELECT sys_worldwide.* FROM sys_worldwide WHERE (sys_worldwide.lang='$lang') AND (sys_worldwide.ctrl&1=1) ORDER BY sys_worldwide.no DESC LIMIT 0,10";						
		$arr=$db->GetAssoc($sql);		
		$smarty->assign("arr",$arr);		
		
		$smarty->registerPlugin("function","strstrim", "strstrim");
		$smarty->registerPlugin("function","strstrimtempworldwide", "strstrimtempworldwide");
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/diendanmo.tpl','diendanmo_'.$themeName);
	}
	//	
?>