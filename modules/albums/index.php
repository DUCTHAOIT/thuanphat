<?php

	$idF=getparamFID(getParam(idF),false);		
	switch ($op){		
		case "albums_hang"	: 	albums_hang();break;
		default 			:	mainShow(); break;
	}
		
	function mainShow()
	{		
		include_once("header.php");
		global $smarty, $lable,$arr_info_page,$idF;				
		$hsx= getParam("hsx");
		$tech=getParam("tech");	
		$sory_by=getParam("sort_by");
		
		$img1=getFunctionNameID($idF,"img1");		
		
		$arrrelation=articleListID($idF);
		
		//$smarty->assign('url_sort_by',$arr_info_page["url"]);		
		$smarty->assign('url_sort_by',getFunctionNameID($idF,"htaccess"));		
		$smarty->assign('hsx',$hsx);
		$smarty->assign('tech',$tech);
		$smarty->assign('sort_by',$sory_by);
		
		$smarty->assign('img1',$img1);
		$smarty->assign('arrrelation',$arrrelation);
		
		$smarty->assign('Compare',$lable->_("Compare"));		
		$smarty->assign('Sort_by',$lable->_("Sort by"));
		
		$smarty->assign('Price_low_to_high',$lable->_("Price low to high"));
		$smarty->assign('Price_high_to_low',$lable->_("Price high to low"));
		$smarty->assign('New_albumss',$lable->_("New albumss"));
		//$smarty->assign('',$lable->_(""));
		
		$smarty->registerPlugin("function","manufacturers_of_function_ID", "manufacturers_of_function_ID");
		$smarty->registerPlugin("function","technicalList", "technicalList");
		$smarty->registerPlugin("function","albums_list", "albums_list");
		$smarty->registerPlugin("function","advertiseLeft", "advertiseLeft");		
		
		include_once("modules/basket/lib.php");
		$smarty->registerPlugin("function","basket_block", "basket_block");
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albumsMain.tpl','albumsMain_');
		include_once("footer.php");
	}	
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
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums_manufacturers.tpl','albums_manufacturers');
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
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums_technical.tpl','albums_technical');
		unset($arr_techs);
		unset($arr);
		unset($arr_tech);
	}
	/**
	 * danh sach san pham
	 */
	function albums_list()
	{
		global $smarty,$idF, $lable,$arr_info_page;
		$pageID=getParam("pageID");
		if(!$pageID) $pageID=0;
		$limit=16;
		
		$arr=get_albums_list($idF);
		
		$numberRecord=count($arr);
				
		$smarty->assign('arr',$arr);
		$smarty->assign('url',_DOMAIN_ROOT_URL."/".$arr_info_page["url"]);
		$smarty->assign('limit',$limit);
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		
		$smarty->assign('pageID',$pageID);		
		$smarty->assign('sPage',sPage(_DOMAIN_ROOT_URL."/".$arr_info_page["url"],$numberRecord,$limit,$pageID));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums_list.tpl','albums_list_');
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
	function albums_hang()
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
		
		//$arr=get_albums_hang($hsx);			
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
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums_list.tpl','albums_list_');
		include_once("footer.php");
	}
	//
	function advertiseLeft(){	
		global $smarty,$lable,$themeName,$db,$lang;
		$sql="SELECT * FROM sys_advertise";
		$sql.=" WHERE (ctrl&1=1) AND lang='$lang'";
		$sql.=" ORDER BY no ASC LIMIT 0,16";
		$arrAd=$db->GetAssoc($sql);			
		
		$smarty->assign('theme',$themeName);
		$smarty->assign('arrAd',$arrAd);
		$smarty->assign('Advertise',$lable->_("Advertise"));
		$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeft.tpl','advertiseLeft_');	
	}
?>