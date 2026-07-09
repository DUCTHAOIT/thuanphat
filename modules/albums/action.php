<?php		
	/**
	 * lay du lieu hang san xuat theo chuc nang
	 * $idF = id chuc nang can lay hang san xuat
	 * @param unknown_type $idF
	 * @return unknown
	 */
	function get_manufacturers_of_function_ID($idF)
	{
		global $db;
		if(!$idF) return;
		$sql="SELECT hang_san_xuat.id, hang_san_xuat.name, count(hang_san_xuat.name) as number_product";
		$sql.=" FROM sys_product , hang_san_xuat";
		$sql.=" WHERE (sys_product.hang_san_xuat =  hang_san_xuat.id) AND (sys_product.catID =  '$idF')";
		
		$tech=getParam("tech");
		$arr_tech=explode(":", $tech);
		
		if(count($arr_tech)){
			foreach($arr_tech as $key=>$value)
			{
				if(((int)$value > 0))
				{
					$sql.=" AND (sys_product.search_criteria LIKE '%:".$value.":%')";
				}
			}
		}
		
		$sql.=" GROUP BY hang_san_xuat.name";
		
		$sql.=" ORDER BY hang_san_xuat.name ASC";
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		
		return $arr;
	}
	
	/**
	 * Danh sach thong so ky thuat
	 * $fid id chuc nang
	 * @param unknown_type $fid
	 * @return unknown
	 */
	function get_technicalList($fid)
	{
		if(!$fid) return;
		global $db;
		
		//danh sach tieu chi tiem kiem theo chuc nang
		loadClass("menuLevel");
		$obj=new menuLevel();
		$obj->sql="SELECT * FROM sys_product_search WHERE catID='$fid' ORDER BY order_number";
		$arr=$obj->orderMenu();
		
		$tech=getParam("tech");
		$hsx=getParam("hsx");
		
		$arr_tech=explode(":", $tech);
		if($arr_tech)
		{
			foreach($arr_tech as $key => $value)
			{
				if($value) $arr_techs[$value]=$value;
			}
		}
		
		//print_r($arr_techs);
		//dem so san pham theo tung tieu chi
		
		$sql="SELECT sys_product_search.id, count(sys_product_search.id) as number_product";
		$sql.=" FROM sys_product , sys_product_search";
		$sql.=" WHERE (sys_product_search.catID =  '$fid') AND (sys_product.catID =  sys_product_search.catID)";
		$sql.=" AND (sys_product.search_criteria LIKE concat(\"%:\", sys_product_search.id, \":%\"))";
		
		if($hsx) $sql.=" AND (sys_product.hang_san_xuat='$hsx')";
		
		if($tech)
		{
			$arr_tech=explode(":", $tech);
			if(count($arr_tech))
			{
				foreach($arr_tech as $key=>$value)
				{
					if(((int)$value > 0))
					{
						$sql.=" AND (sys_product.search_criteria LIKE concat(\"%:\", ".$value .", \":%\"))";						
					}
				}
			}
		}
		
		$sql.=" GROUP BY sys_product_search.id";
		//echo $sql;		
		$arr_number=$db->GetAssoc($sql);	
		
		if(!$arr_number) return;
		foreach ($arr as $key=>$value){
			$id=$value["id"];
			if($arr_number[$id] || $value["parent"]==0){
				$arr_output[$id]["name"]=$value["name"];
				$arr_output[$id]["parent"]=$value["parent"];
				$arr_output[$id]["number_product"]=(int)$arr_number[$id]["number_product"];
				
				if($arr_techs[$id] > 0)
				{
					$arr_output[$id]["select"]=1;
				}
			}
		}
		
		unset($arr_number);
		unset($arr);
		
		return $arr_output;
	}
	
	function get_albums_list($idF)
	{
		global $db;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.khach_hang, sys_product.model, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.catID =  '$idF') AND (sys_product.khach_hang ='0') AND (sys_product.ctrl&1=1)";
		$arr_tech=explode(":", $tech);
		foreach($arr_tech as $key=>$value)
		{
			if(((int)$value > 0))
			{
				$sql.=" AND (search_criteria LIKE '%:".$value.":%')";
			}
		}
		
		$sql.=" ORDER BY";
		if($sort_by=="thapcao") $sql.=" price ASC";
		elseif($sort_by=="caothap") $sql.=" price DESC";
		else $sql.=" today DESC";
		$arr=$db->GetAll($sql);		
		return $arr;
	}
	//
	function get_albums_search_id($id){
		global $db;
		if(!$id) return;
		$sql="SELECT * FROM sys_product_search WHERE id='$id'";
		$arr=$db->GetAssoc();
		return $arr;
	}
	/**
	 * Thong tin chi tiet san pham
	 *
	 * @param unknown_type $id
	 */
	function get_albums_id($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_product.* ";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	function get_albums_access($id)
	{
		global $db;
		if(!$id) return;
		$sql="UPDATE `sys_product` SET `access`=`access`+1 WHERE (`id`='$id')";		
		$db->Execute($sql);
	}
	/**
	 * san pham cung hang san xuat voi san pham dang xem
	 *
	 * @param unknown_type $product_id
	 * @return unknown
	 */
	function get_albums_and_manufacturers($product_id)
	{
		global $db;	
		
		if(!$product_id) return;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo, TO_DAYS(sys_product.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_product.hang_san_xuat =  (SELECT hang_san_xuat FROM sys_product WHERE id='$product_id')) AND (sys_product.catID =  (SELECT catID FROM sys_product WHERE id='$product_id')) AND (sys_product.id<>'$product_id') AND  (sys_product.hang_san_xuat =  hang_san_xuat.id) AND (sys_product.ctrl&1=1) AND (sys_function.id=sys_product.catID)";
		$sql.=" ORDER BY today desc LIMIT 0,10";	
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	/**
	 * san pham cung thong so ky thuat voi san pham dang xem
	 *
	 * @param unknown_type $product_id
	 */
	function get_albums_in_technical($product_id,$value)
	{
		global $db;			
		if(!$product_id) return;
				
		// danh sach san pham cung thong so ky thuat			
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo, TO_DAYS(sys_product.date_create) as today, (select name FROM sys_product_search WHERE id='$value') as name_hsx, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_product.id<>'$product_id') AND  (sys_product.hang_san_xuat =  hang_san_xuat.id) AND (sys_product.ctrl&1=1)";	
		$sql.=" AND (search_criteria LIKE '%:".$value.":%') AND (sys_function.id=sys_product.catID)";
		$sql.=" ORDER BY today desc LIMIT 0,10";
		//echo $sql."<p>";
		$arr=$db->GetAll($sql);		
		return $arr;
	}
	//
	function get_albums_hang($hsx)
	{
		global $db;
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.model, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo, TO_DAYS(sys_product.date_create) as today";
		$sql.=" FROM sys_product , hang_san_xuat";
		$sql.=" WHERE (sys_product.hang_san_xuat =  hang_san_xuat.id) AND (sys_product.ctrl&1=1) AND (sys_product.hang_san_xuat='$hsx')";
		
		$sql.=" ORDER BY";
		if($sort_by=="thapcao") $sql.=" price ASC";
		elseif($sort_by=="caothap") $sql.=" price DESC";
		else $sql.=" today DESC";
		//echo $sql;
		$arr=$db->GetAll($sql);
		return $arr;
	}
	function getalbumsListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//
	function articleListID($fid){
		global $db,$lang;		
		
		$txtSearch=getParamPost("txtSearch");
		
		$sql="SELECT sys_article.*";
		$sql.=" FROM sys_article_cat , sys_article";
		$sql.=" WHERE sys_article_cat.artID =  sys_article.id AND sys_article.lang='$lang' AND sys_article.ctrl&1=1";
		$sql.=" AND sys_article_cat.catID =  '$fid'";
		
		if($txtSearch){
			$sql.=" AND (match(name, summary) against('$txtSearch' in boolean mode))";
		}	
				
		$sql.=" ORDER BY sys_article.id DESC";			
		$arr=$db->GetAll($sql);			
		return $arr;		
	}	
	//
?>