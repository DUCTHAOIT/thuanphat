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
		$sql="SELECT hang_san_xuat.id, hang_san_xuat.name, count(hang_san_xuat.name) as number_gopvon";
		$sql.=" FROM sys_gopvon , hang_san_xuat";
		$sql.=" WHERE (sys_gopvon.hang_san_xuat =  hang_san_xuat.id) AND (sys_gopvon.catID =  '$idF')";
		
		$tech=getParam("tech");
		$arr_tech=explode(":", $tech);
		
		if(count($arr_tech)){
			foreach($arr_tech as $key=>$value)
			{
				if(((int)$value > 0))
				{
					$sql.=" AND (sys_gopvon.search_criteria LIKE '%:".$value.":%')";
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
		$obj->sql="SELECT * FROM sys_gopvon_search WHERE catID='$fid' ORDER BY order_number";
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
		
		$sql="SELECT sys_gopvon_search.id, count(sys_gopvon_search.id) as number_gopvon";
		$sql.=" FROM sys_gopvon , sys_gopvon_search";
		$sql.=" WHERE (sys_gopvon_search.catID =  '$fid') AND (sys_gopvon.catID =  sys_gopvon_search.catID)";
		$sql.=" AND (sys_gopvon.search_criteria LIKE concat(\"%:\", sys_gopvon_search.id, \":%\"))";
		
		if($hsx) $sql.=" AND (sys_gopvon.hang_san_xuat='$hsx')";
		
		if($tech)
		{
			$arr_tech=explode(":", $tech);
			if(count($arr_tech))
			{
				foreach($arr_tech as $key=>$value)
				{
					if(((int)$value > 0))
					{
						$sql.=" AND (sys_gopvon.search_criteria LIKE concat(\"%:\", ".$value .", \":%\"))";						
					}
				}
			}
		}
		
		$sql.=" GROUP BY sys_gopvon_search.id";
		//echo $sql;		
		$arr_number=$db->GetAssoc($sql);	
		
		if(!$arr_number) return;
		foreach ($arr as $key=>$value){
			$id=$value["id"];
			if($arr_number[$id] || $value["parent"]==0){
				$arr_output[$id]["name"]=$value["name"];
				$arr_output[$id]["parent"]=$value["parent"];
				$arr_output[$id]["number_gopvon"]=(int)$arr_number[$id]["number_gopvon"];
				
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
	
	function get_gopvon_list($idF)
	{
		global $db, $lang, $lable;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		$idParent=getparamFID(getParam(idF),true);
		$idsub=getparamFID(getParam(idF),false);		
		$parent=getFunctionNameID($idF,"parent");		
		
		$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='gopvon') AND (parent='$idF') ORDER BY sort";	
		$rs=$db->Execute($sql);	

		if($rs->RecordCount()){
		

				$sql="SELECT sys_gopvon.*, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, TO_DAYS(sys_gopvon.date_create) as today, sys_function.htaccess as url";
				$sql.=" FROM sys_gopvon,sys_function";
				$sql.=" WHERE (sys_function.parent =  '$idF') AND (sys_gopvon.catID=sys_function.id) AND (sys_gopvon.ctrl&1=1)";
				//$sql.=" WHERE (sys_gopvon.lang =  '$lang') AND (sys_gopvon.ctrl&1=1)";
				
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
				//else $sql.=" today DESC";
				else $sql.=" today DESC";
				//echo $sql;
				$arr=$db->GetAll($sql);
				return $arr;		
		}else{
		
		$sql="SELECT sys_gopvon.*, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, TO_DAYS(sys_gopvon.date_create) as today, sys_function.htaccess as url";
		$sql.=" FROM sys_gopvon,sys_function";
		$sql.=" WHERE (sys_gopvon.catID =  '$idF') AND (sys_gopvon.catID=sys_function.id) AND (sys_gopvon.ctrl&1=1)";
		//$sql.=" WHERE (sys_gopvon.lang =  '$lang') AND (sys_gopvon.ctrl&1=1)";
		
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
		//echo $sql;
		$arr=$db->GetAll($sql);
		return $arr;
		}
	}
	//
	function get_gopvon_list_all()
	{
		global $db, $lang;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
				
		
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.img1, sys_gopvon.alias, sys_gopvon.delivery, sys_gopvon.promotion, TO_DAYS(sys_gopvon.date_create) as today, sys_function.htaccess";
		$sql.=" FROM sys_gopvon, sys_function";
		$sql.=" WHERE (sys_gopvon.catID =  sys_function.id) AND (sys_gopvon.ctrl&1=1)";
		//$sql.=" WHERE (sys_gopvon.lang =  '$lang') AND (sys_gopvon.ctrl&1=1)";
		
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
		else $sql.=" sort DESC";
		//echo $sql;
		$arr=$db->GetAll($sql);
		return $arr;
	
	}
	//
	function get_gopvon_list_re($idF)
	{
		global $db, $lang;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.img1, sys_gopvon.alias, sys_gopvon.delivery, sys_gopvon.promotion, TO_DAYS(sys_gopvon.date_create) as today, sys_function.htaccess";
		$sql.=" FROM sys_gopvon, sys_function";
		$sql.=" WHERE (sys_gopvon.catID =  '$idF') AND (sys_function.id =  '$idF') AND (sys_gopvon.ctrl&1=1)";
		//$sql.=" WHERE (sys_gopvon.lang =  '$lang') AND (sys_gopvon.ctrl&1=1)";
		
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
		else $sql.=" sort DESC";
		//echo $sql;
		$arr=$db->GetAll($sql);
		return $arr;
	
	}
	//
	function get_gopvon_search_id($id){
		global $db;
		if(!$id) return;
		$sql="SELECT * FROM sys_gopvon_search WHERE id='$id'";
		$arr=$db->GetAssoc();
		return $arr;
	}
	/**
	 * Thong tin chi tiet san pham
	 *
	 * @param unknown_type $id
	 */
	
	function get_gopvon_id($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_gopvon.*";
		$sql.=" FROM sys_gopvon";
		$sql.=" WHERE (sys_gopvon.alias='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	
	function get_gopvon_id_ok($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_gopvon.*";
		$sql.=" FROM sys_gopvon";
		$sql.=" WHERE (sys_gopvon.id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	function get_gopvon_access($id)
	{
		global $db;
		if(!$id) return;
		$sql="UPDATE `sys_gopvon` SET `access`=`access`+1 WHERE (`id`='$id')";		
		$db->Execute($sql);
	}
	/**
	 * san pham cung hang san xuat voi san pham dang xem
	 *
	 * @param unknown_type $gopvon_id
	 * @return unknown
	 */
	function get_gopvon_and_manufacturers($gopvon_id)
	{
		global $db;	
		
		if(!$gopvon_id) return;
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.model, sys_gopvon.delivery, sys_gopvon.promotion, hang_san_xuat.logo, TO_DAYS(sys_gopvon.date_create) as today, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_gopvon , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_gopvon.hang_san_xuat =  (SELECT hang_san_xuat FROM sys_gopvon WHERE id='$gopvon_id')) AND (sys_gopvon.catID =  (SELECT catID FROM sys_gopvon WHERE id='$gopvon_id')) AND (sys_gopvon.id<>'$gopvon_id') AND  (sys_gopvon.hang_san_xuat =  hang_san_xuat.id) AND (sys_gopvon.ctrl&1=1) AND (sys_function.id=sys_gopvon.catID)";
		$sql.=" ORDER BY today desc LIMIT 0,10";	
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	/**
	 * san pham cung thong so ky thuat voi san pham dang xem
	 *
	 * @param unknown_type $gopvon_id
	 */
	function get_gopvon_in_technical($gopvon_id,$value)
	{
		global $db;			
		if(!$gopvon_id) return;
				
		// danh sach san pham cung thong so ky thuat			
		
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.model, sys_gopvon.delivery, sys_gopvon.promotion, hang_san_xuat.logo, TO_DAYS(sys_gopvon.date_create) as today, (select name FROM sys_gopvon_search WHERE id='$value') as name_hsx, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_gopvon , hang_san_xuat, sys_function";
		$sql.=" WHERE (sys_gopvon.id<>'$gopvon_id') AND  (sys_gopvon.hang_san_xuat =  hang_san_xuat.id) AND (sys_gopvon.ctrl&1=1)";	
		$sql.=" AND (search_criteria LIKE '%:".$value.":%') AND (sys_function.id=sys_gopvon.catID)";
		$sql.=" ORDER BY today desc LIMIT 0,10";
		//echo $sql."<p>";
		$arr=$db->GetAll($sql);		
		return $arr;
	}
	//
	function get_gopvon_hang($hsx)
	{
		global $db;
		$sql="SELECT sys_gopvon.id, ".check_view_script("sys_gopvon.name")." as name, ".check_view_script("sys_gopvon.summary")." as summary, sys_gopvon.price_old, sys_gopvon.price, sys_gopvon.img, sys_gopvon.model, sys_gopvon.delivery, sys_gopvon.promotion, hang_san_xuat.logo, TO_DAYS(sys_gopvon.date_create) as today";
		$sql.=" FROM sys_gopvon , hang_san_xuat";
		$sql.=" WHERE (sys_gopvon.hang_san_xuat =  hang_san_xuat.id) AND (sys_gopvon.ctrl&1=1) AND (sys_gopvon.hang_san_xuat='$hsx')";
		
		$sql.=" ORDER BY";
		if($sort_by=="thapcao") $sql.=" price ASC";
		elseif($sort_by=="caothap") $sql.=" price DESC";
		else $sql.=" sort DESC";
		//echo $sql;
		$arr=$db->GetAll($sql);
		return $arr;
	}
	function getgopvonListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_gopvon_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//
	//
	function getgopvonListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_gopvon_file WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}
	
	function articleListID($txtSearch){
		global $db,$lang;		
		
		$sql="SELECT sys_article.*, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, sys_function.htaccess";
		$sql.=" FROM sys_article_cat , sys_article, sys_function";
		$sql.=" WHERE sys_article_cat.artID =  sys_article.id AND sys_article_cat.catID =  sys_function.id AND sys_article.lang='$lang' AND sys_article.ctrl&1=1";
		$sql.=" AND sys_article_cat.catID =  '519'";
		
		$sql.=" AND (sys_article.name LIKE '%".$txtSearch."%')";
		
		$sql.=" ORDER BY sys_article.date_create DESC";			
		
		$arr=$db->GetAll($sql);			
		return $arr;		
	}	
	//
	function getgopvonListFaq($proID){
		global $db;		
		$sql="SELECT * FROM sys_commentgopvon WHERE (ctrl&1=1) AND (proid=$proID)";		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}	
?>