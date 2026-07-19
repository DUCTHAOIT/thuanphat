<?php	
	function getTopicProduct($proID=""){
		global $db,$moduleName;
		$sql="SELECT * FROM sys_function WHERE (lang='vn') AND module='product' AND (ctrl&1=1) ORDER BY id";	
		$arr=$db->getAssoc($sql);					
		return $arr;
	}
	function getTopicProduct_($proID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="id";
		// list cac dau muc la product
		$obj->where="module='$moduleName' AND (ctrl&1=1)";
		//list het
		//$obj->where="(ctrl&1=1)";
		//
		$obj->limit="all";
		$sql=$obj->sqlSelect();
		echo $sql;		
		$obj=new menuLevel();
		$obj->sql=$sql;		
		$arr=$obj->orderMenu();				
		return $arr;
	}
	//
	function addProduct(){
		global $db, $lable,$lang;
		$vowels = array(".",",");
				
		loadClass("convertString");
		$converString=new convertString();
		
		$catID=getParamPost("catID");		
		$name=trim(getParamPost("name"));
		
//		$alias= $obj->remoteDiacritic($name);	
		$alias= strtolower($converString->remoteDiacritic($name));
		//$converString->remoteDiacritic($rs->fields("htaccess"))
			
		$price_old=str_replace($vowels, "", getParamPost("price_old"));
        if(!$price_old) $price_old=0;
		$price_new=str_replace($vowels, "", getParamPost("price_new"));
        if(!$price_new) $price_new=0;

		//$summary=getParamPost("summary");
		$summary=str_replace("'","&#8217;",getParamPost("summary"));// bo dau phay tren
		
		//$content=getParamPost("content");	
		$content2=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		
		$foo = $content2;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$content = str_replace($search, $replace, $newFoo);
		
		$date=getParamPost("date");		
		//$langID=getParamPost("lang");	
		$langID=$lang;	
		$id=getParamPost("id");		
		$imgsmall=getParamPost("imgsmall");
		$imgbig=getParamPost("imgbig");
		
		$model=trim(getParamPost("model"));
		$product_in=trim(getParamPost("product_in"));
		$delivery=trim(getParamPost("delivery"));
		$promotion=trim(getParamPost("promotion"));
		
		//$vitri=getParamPost("contents");
		$vitri=str_replace("'","&#8217;",getParamPost("contents"));// bo dau phay tren
		
		$foo = $vitri;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$vitri = str_replace($search, $replace, $newFoo);
		
		//$tienich=getParamPost("content1");
		$tienich=str_replace("'","&#8217;",getParamPost("content1"));// bo dau phay tren
		
		$foo = $tienich;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$tienich = str_replace($search, $replace, $newFoo);
		////
		
		$chinhsach=str_replace("'","&#8217;",getParamPost("content2"));// bo dau phay tren
		
		$foo = $chinhsach;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$chinhsach = str_replace($search, $replace, $newFoo);
		////
				
		$position=getParamPost("position");
		$solutions=getParamPost("solutions");
		
		$search_criteria=getParamPost("search_criteria");
		$hang_san_xuat=getParamPost("hang_san_xuat");
		$tinh_trang=getParamPost("tinh_trang");
		
		$manufacturers=getParamPost("manufacturers");
		$xuatsu=getParamPost("xuatsu");
		
		$giaidoan=getParamPost("giaidoan");
		
		$title=getParamPost("title");
		$description=getParamPost("description");
		$keywords=getParamPost("keywords");
		
		$special_promotion=getParamPost("special_promotion");
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;

		$is_activation_combo=getParamPost("is_activation_combo");
		if($is_activation_combo) $is_activation_combo = 1;
		else $is_activation_combo = 0;

		$commission_amount=str_replace($vowels, "", getParamPost("commission_amount"));
		if(!$commission_amount) $commission_amount=0;

		// "Hoa hồng sản phẩm" (mục 3 BUSINESS_RULES.md - nền tính quỹ chia hoa hồng) phải nhỏ hơn giá niêm
		// yết ($price_new), không cho phép admin nhập bằng/vượt giá bán (bổ sung 2026-07-16).
		if($price_new > 0 && $commission_amount >= $price_new){
			include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
			$ret_page="?m=product&op=frm".($id ? "&id=$id" : "");
			$a=new msgBox("Hoa hồng sản phẩm phải nhỏ hơn giá niêm yết.","OKOnly", "Message", array($ret_page), 1);
			$a->showMsg();
		}

		$accept_card_payment=getParamPost("accept_card_payment");
		if($accept_card_payment) $accept_card_payment = 1;
		else $accept_card_payment = 0;

		$accept_tich_luy_payment=getParamPost("accept_tich_luy_payment");
		if($accept_tich_luy_payment) $accept_tich_luy_payment = 1;
		else $accept_tich_luy_payment = 0;

		$accept_tieu_dung_payment=getParamPost("accept_tieu_dung_payment");
		if($accept_tieu_dung_payment) $accept_tieu_dung_payment = 1;
		else $accept_tieu_dung_payment = 0;

		$accept_kha_dung_payment=getParamPost("accept_kha_dung_payment");
		if($accept_kha_dung_payment) $accept_kha_dung_payment = 1;
		else $accept_kha_dung_payment = 0;

		$sort=getParamPost("sort");
        if(!$sort) $sort = 0;
		
		if($search_criteria){
			foreach ($search_criteria as $key=>$value){
				$str_search_criteria.=":". $value. ":";
			}
			//$str_search_criteria.=":";
		}
		
		if($manufacturers){
			foreach ($manufacturers as $key=>$value){
				$str_manufacturers.=":". $value. ":";
			}
			//$str_search_criteria.=":";
		}
		if($xuatsu){
			foreach ($xuatsu as $key=>$value){
				$str_xuatsu.=":". $value. ":";
			}
			//$str_search_criteria.=":";
		}
		
		$filePDF=getParamPost("filePDF");		
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/product/".$imgsmall;
			moveFile($from,$to);			
		}
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if(file_exists($sourcefile)){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/product/".$imgbig;
			moveFile($from,$to);
			
		}
		
		$groupID=getParamPost("groupID");	
		//
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT id FROM sys_product WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					
					$sql = "SELECT * FROM sys_product WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);			
					$sql = "INSERT INTO sys_product (catID, name, alias, summary, content, model, product_in, promotion, position, solutions, tienich, vitri, price_old, price, img, img1, pdf, date_create, lang, special_promotion, is_activation_combo, commission_amount, accept_card_payment, accept_tich_luy_payment, accept_tieu_dung_payment, accept_kha_dung_payment, sort, xuatsu, manufacturers, chinhsach, title, description, keywords) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$product_in', '$promotion', '$position', '$solutions', '$tienich', '$vitri', '$price_old', '$price_new', '$imgsmall', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$is_activation_combo', '$commission_amount', '$accept_card_payment', '$accept_tich_luy_payment', '$accept_tieu_dung_payment', '$accept_kha_dung_payment', '$sort','$str_xuatsu','$str_manufacturers','$chinhsach', '$title','$description','$keywords')";
					$return=$db->Execute($sql);	
					if($return){
						$idNew=$db->Insert_ID();
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_product_admin_cat(catID,artID) VALUES('$value','$idNew')";
							$return=$db->Execute($sql);
						}
					}						
			}else{
					$sql = "SELECT * FROM sys_product WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);			
					$sql = "INSERT INTO sys_product (catID, name, alias, summary, content, model, product_in, promotion, position, solutions, tienich, vitri, price_old, price, img, img1, pdf, date_create, lang, special_promotion, is_activation_combo, commission_amount, accept_card_payment, accept_tich_luy_payment, accept_tieu_dung_payment, accept_kha_dung_payment, sort, xuatsu, manufacturers, chinhsach, title, description, keywords) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$product_in', '$promotion', '$position', '$solutions', '$tienich', '$vitri', '$price_old', '$price_new', '$imgsmall', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$is_activation_combo', '$commission_amount', '$accept_card_payment', '$accept_tich_luy_payment', '$accept_tieu_dung_payment', '$accept_kha_dung_payment', '$sort','$str_xuatsu','$str_manufacturers','$chinhsach', '$title','$description','$keywords')";
					$return=$db->Execute($sql);		
					$idNew=$db->Insert_ID();
					
					$sql = "UPDATE sys_product SET";
					$sql.=" alias='".$alias."-".$idNew."' WHERE id='$idNew'";					
					$db->Execute($sql);
					
					if($return){
						$idNew=$db->Insert_ID();
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_product_admin_cat(catID,artID) VALUES('$value','$idNew')";
							$return=$db->Execute($sql);
						}
					}
			}
		}else{			
			$sql = "SELECT id FROM sys_product WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					
					$sql = "SELECT * FROM sys_product WHERE id=$id";
					$rs = $db->Execute($sql);
					$sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', tienich='$tienich', vitri='$vitri', price_old = '$price_old', price = '$price_new', img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', is_activation_combo = '$is_activation_combo', commission_amount = '$commission_amount', accept_card_payment = '$accept_card_payment', accept_tich_luy_payment = '$accept_tich_luy_payment', accept_tieu_dung_payment = '$accept_tieu_dung_payment', accept_kha_dung_payment = '$accept_kha_dung_payment', sort = '$sort', xuatsu='$str_xuatsu', manufacturers='$str_manufacturers', chinhsach='$chinhsach',title='$title',description='$description',keywords='$keywords' WHERE id=$id";
					$return=$db->Execute($sql);
					if($return){
						$sql="DELETE FROM sys_product_admin_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_product_admin_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
					}
					
			}else{
					$sql = "SELECT * FROM sys_product WHERE id=$id";
					$rs = $db->Execute($sql);
                    $sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', tienich='$tienich', vitri='$vitri', price_old = '$price_old', price = '$price_new', img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', is_activation_combo = '$is_activation_combo', commission_amount = '$commission_amount', accept_card_payment = '$accept_card_payment', accept_tich_luy_payment = '$accept_tich_luy_payment', accept_tieu_dung_payment = '$accept_tieu_dung_payment', accept_kha_dung_payment = '$accept_kha_dung_payment', sort = '$sort', xuatsu='$str_xuatsu', manufacturers='$str_manufacturers', chinhsach='$chinhsach',title='$title',description='$description',keywords='$keywords' WHERE id=$id";
					$return=$db->Execute($sql);
					if($return){
						$sql="DELETE FROM sys_product_admin_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_product_admin_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
					}
			}	
							
		}		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=product&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=product";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function getProductList($all,$pageID,$limit=20){
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		$catID=getParam("catID");		
		if(!$catID) $catID=getParamPost("catID");		
		
		$hang_san_xuat=getParam("hang_san_xuat");		
		if(!$hang_san_xuat) $hang_san_xuat=getParamPost("hang_san_xuat");		
	//	echo "duong".$hang_san_xuat;		
		if(!$hang_san_xuat){ 			
			if(!$keyword){
				$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat";
				$obj->tableName="sys_product ,sys_function";		
						
				if(!$catID){ $obj->where="(sys_product.catID =  sys_function.id)";}
				else {$obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id)";}						
				$obj->orderBy="today DESC";						
			}else{		
				$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat, match(sys_product.name,sys_product.model) against('$keyword' in boolean mode) as relevance";
				$obj->tableName="sys_product ,sys_function";
				
				if(!$catID) $obj->where="(sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.model) against('$keyword' in boolean mode))";		
				else $obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.model) against('$keyword' in boolean mode))";		 			
				
				$obj->orderBy="relevance DESC";				
			}
		}else{		
			if(!$keyword){
					$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat, hang_san_xuat.name as nameHSX";
					$obj->tableName="sys_product,sys_function,hang_san_xuat";		
					
					$obj->where="(sys_product.hang_san_xuat=$hang_san_xuat) AND (sys_product.hang_san_xuat =  hang_san_xuat.id) AND";
							
					if(!$catID){ $obj->where.=" (sys_product.catID =  sys_function.id)";}
					else {$obj->where.=" (sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id)";}		
									
					$obj->orderBy="today DESC";						
				}else{		
					$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat, hang_san_xuat.name as nameHSX, match(sys_product.name,sys_product.model) against('$keyword' in boolean mode) as relevance";
					$obj->tableName="sys_product,sys_function,hang_san_xuat";
					
					$obj->where="(sys_product.hang_san_xuat=$hang_san_xuat) AND (sys_product.hang_san_xuat =  hang_san_xuat.id) AND";
					
					if(!$catID) $obj->where.=" (sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.model) against('$keyword' in boolean mode))";		
					else $obj->where.=" (sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.model) against('$keyword' in boolean mode))";		 			
					
					$obj->orderBy="relevance DESC";				
				}
		}
		$obj->fieldsLang="sys_product";
		
		if($all==false){
			$obj->limit_start = $pageID;
			$obj->limit=$limit;
		}else $obj->limit="All";
		
		$sql=$obj->sqlSelect();
		//echo $sql."<br>";
		//return;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;			
		return $arr;
	}
	//
	function checkFuncName($arr,$k){
		foreach($arr as $key=>$value){
			if($value["proID"]==$k) $name .= $value["name"].",";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function getProductID($proID){
		global $db;
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*, DATE_FORMAT(date_create, '%Y-%m-%d') as date_create";
		$obj->tableName="sys_product";		
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/product/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/product/".$arr["img1"];
		return $arr;
	}
	
	//
	function deleteProduct(){
		global $db,$lable;
		$proID=getParamPost("id");
		loadClass("constructSql");		
		$obj=new constructSql();
		//Xoa file anh
		$obj->tableName="sys_product";
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		if(($rs->fields("img")) or ($rs->fields("img1"))){
			loadClass("fileSystem");
			$objs=new fileSystem();
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/product/".$rs->fields("img"));
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/product/".$rs->fields("img1"));
		}
		
		//xoa trong bang product
		$obj->tableName="sys_product";
		$obj->where="id=$proID";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);		
		
		if(!$return) echo _NO_DELETE_SUCCESSFU;
		productList();
	}
	//
	function lockProduct(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_product SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_product WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	//
	//
	function addPhoto(){
		global $db;
		$id=getParamPost("id");
		foreach($_FILES['img_file']['name'] as $name => $value)
		{
			$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
			$source_img = $_FILES['img_file']['tmp_name'][$name];
			$path_img = _DOMAIN_ROOT_PATH."/images/product/".$name_img;	
			
			move_uploaded_file($source_img, $path_img);
			
			$sql="INSERT INTO sys_product_photo(proid, img, img1) VALUES('$id','$name_img',NOW())";
			$return=$db->Execute($sql); 
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=product&op=photo&id=$id";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=product&op=photo&id=$id";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		
	}
	//
	//
	function getProductListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function deletePhoto(){
		global $db;
		$id=getParamPost("photoID");
		$sql="DELETE FROM sys_product_photo WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		productListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_product_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/product/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/product/".$arr["img1"];
		return $arr;
	}
	//
	/**
	 * Hang san xuat
	 *
	 */	
	function manufacturers(){
		global $db;
		$sql="SELECT * FROM hang_san_xuat ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	function xuatsu(){
		global $db;
		$sql="SELECT * FROM xuat_su ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function linhvuc(){
		global $db;
		$sql="SELECT * FROM linhvuc ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function loai(){
		global $db;
		$sql="SELECT * FROM loai ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function dongsp(){
		global $db;
		$sql="SELECT * FROM dongsp ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	/**
	 * Tinh trang hang
	 *
	 */	
	function tinh_trang(){
		global $db;
		$sql="SELECT * FROM tinh_trang ORDER BY name ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function addFile(){
		global $db;
		$uploaddir = _DOMAIN_ROOT_PATH."/temp/";
		
		$id=getParamPost("id");
		$file=getParamPost("file");		
		$idFile=getParamPost("idFile");
		$name=getParamPost("name");
		$content=getParamPost("content");
		$date_create=date("Y-m-d");
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$file;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/lib/".$file;
			moveFile($from,$to);	
		    $size=file_size($to);
		    if(!$size) $size="";		
		}	
		@unlink($sourcefile);		
	
		if(!$idFile) $sql="INSERT INTO sys_product_file(proid,file,content,name,date_create,size) VALUES ($id,'$file','$content','$name','$date_create','$size')";		
		else $sql="UPDATE sys_product_file SET file='$file',content='$content',name='$name',date_create='$date_create',size='$size' WHERE id=$idFile";		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=product&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function getproductListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_product_file WHERE proid=$proID";				
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	//
	function deleteFile(){
		global $db;
		$id=getParamPost("fileID");
		$sql="DELETE FROM sys_product_file WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		productListFile();
	}	
	//
	function getFileID($id){
		global $db;
		$sql="SELECT * FROM sys_product_file WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["file"]) $arr["file_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["file_view"]=_DOMAIN_ROOT_URL."/lib/".$arr["file"];	
		return $arr;
	}
	//
	//
	function lockFile(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_product_file SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_product_file WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function getGroupAdmin($artID=""){
		global $db,$lang;
		$sql="SELECT *, concat(fistname,' ',lastname) as fullname FROM sys_member WHERE ctrl =  '1'";		
		$arr=$db->GetAssoc($sql);

		$sqlcat="SELECt * FROM sys_product_admin_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sqlcat);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="checked=\"checked\"";
			//echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
?>