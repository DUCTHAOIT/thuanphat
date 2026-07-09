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
	
	function get_product_list($idF)
	{
		global $db, $lang;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		$idParent=getparamFID(getParam(idF),true);
		$idsub=getparamFID(getParam(idF),false);
		if($idParent==$idsub){
			global $db,$lang;
			$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='product') AND (parent='$idF') ORDER BY sort";	
			$rs=$db->Execute($sql);	
			if($rs->RecordCount()){	?>	
			 <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <?php
			$j=0;
			while(!$rs->EOF){
			?>
			 <tr height="100%">
			  <td width="100%" valign="top" align="left">	
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td nowrap="nowrap" align="left" valign="bottom" style="padding-top:5px; border-bottom:1px dotted #CCCCCC"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>" class="title" style="color:#990000;"><?php echo $rs->fields("name");?></a></td>		
				  </tr>
				  <tr>	
					<td valign="bottom" style="padding-top:10px; padding-bottom:5px;" width="100%" align="center">						
					<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%"  >
					  <tr>
				 <?php
					$sql="SELECT * FROM sys_product WHERE (sys_product.catID = ".$rs->fields("id").") ORDER BY date_create DESC LIMIT 0,3";				
					$arr_product=$db->GetAssoc($sql);
					if(count($arr_product)){					
					foreach($arr_product as $k=>$v){
						?>
							<td align="center" valign="top" style="padding:5px">
							    <div style="border:1px solid #dddddd;">
                                <a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]; ?>"><img src="<?php echo _DOMAIN_ROOT_URL;?>/img/product/<?php echo $v["img"]?>" border="0" hspace="10" vspace="10" width="200px"/></a></div>
								<?php
								echo "<div class=\"title\"  align=\"center\" style=\"padding:5px;\"><a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\" class=\"title\">".$v["name"]."</a></div>";										
								?>
							</td> 
						<?php
					  }						
					}						
				  ?>
				  		</tr>
						</table>			
						</td>
					  </tr>	
				 </table>
				</td>
			  </tr>
			  <?php 
					$j++;
					$rs->MoveNext();						
				}
				?>
			</table>
		<?php
		}			
		}else{
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.img1, sys_product.alias, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.catID =  '$idF') AND (sys_product.ctrl&1=1)";
		//$sql.=" WHERE (sys_product.lang =  '$lang') AND (sys_product.ctrl&1=1)";
		
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
	function get_product_list_all()
	{
		global $db, $lang;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
				
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.img1, sys_product.alias, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today, sys_function.htaccess";
		$sql.=" FROM sys_product, sys_function";
		$sql.=" WHERE (sys_product.catID =  sys_function.id) AND (sys_product.ctrl&1=1)";
		//$sql.=" WHERE (sys_product.lang =  '$lang') AND (sys_product.ctrl&1=1)";
		
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
	//
	function get_product_list_re($idF)
	{
		global $db, $lang;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		$sql="SELECT sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price_old, sys_product.price, sys_product.img, sys_product.img1, sys_product.alias, sys_product.delivery, sys_product.promotion, TO_DAYS(sys_product.date_create) as today, sys_function.htaccess";
		$sql.=" FROM sys_product, sys_function";
		$sql.=" WHERE (sys_product.catID =  '$idF') AND (sys_function.id =  '$idF') AND (sys_product.ctrl&1=1)";
		//$sql.=" WHERE (sys_product.lang =  '$lang') AND (sys_product.ctrl&1=1)";
		
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
	//
	function get_product_search_id($id){
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
	
	function get_product_id($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.alias='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	
	function get_product_id_ok($id)
	{
		global $db;
		if(!$id) return;		
		
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product";
		$sql.=" WHERE (sys_product.id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;		
	}
	function get_product_access($id)
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
	function get_product_and_manufacturers($product_id)
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
	function get_product_in_technical($product_id,$value)
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
	function get_product_hang($hsx)
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
	function getProductListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//
	//
	function getproductListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_file WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}
	
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