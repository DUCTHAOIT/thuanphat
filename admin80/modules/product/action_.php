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
		$price_new=str_replace($vowels, "", getParamPost("price_new"));		
		
		//$summary=getParamPost("summary");
		$summary=str_replace("'","&#8217;",getParamPost("summary"));// bo dau phay tren
		
		//$content=getParamPost("content");	
		$content2=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		
		$foo = $content2;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		$content=$newFoo;
			
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
		$vitri=$newFoo;
		
		//$tienich=getParamPost("content1");
		$tienich=str_replace("'","&#8217;",getParamPost("content1"));// bo dau phay tren
		
		$foo = $tienich;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		$tienich=$newFoo;
		////
		
		$chinhsach=str_replace("'","&#8217;",getParamPost("content2"));// bo dau phay tren
		
		$foo = $chinhsach;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		$chinhsach=$newFoo;
		///
				
		$position=getParamPost("position");
		$solutions=getParamPost("solutions");
		
		$search_criteria=getParamPost("search_criteria");
		$hang_san_xuat=getParamPost("hang_san_xuat");
		$tinh_trang=getParamPost("tinh_trang");
		
		$manufacturers=getParamPost("manufacturers");
		$xuatsu=getParamPost("xuatsu");
		
		$giaidoan=getParamPost("giaidoan");
		$linhvuc=getParamPost("linhvuc");
		
		$baohanh=getParamPost("baohanh");
		
		$title=getParamPost("title");
		$description=getParamPost("description");
		$keywords=getParamPost("keywords");
		
		$special_promotion=getParamPost("special_promotion");
		
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;	
		
		$sort=getParamPost("sort");
		
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
		//
		$tengiaidoan1=trim(getParamPost("tengiaidoan1"));
		$hinhthuc1=trim(getParamPost("hinhthuc1"));
		$soxuatdautu1=trim(getParamPost("soxuatdautu1"));
		
		$tongvondautu1=str_replace($vowels, "", getParamPost("tongvondautu1"));
		$sotienmotxuat1=str_replace($vowels, "", getParamPost("sotienmotxuat1"));
		$chietkhau1=str_replace($vowels, "", getParamPost("chietkhau1"));
		$chietkhau12=str_replace($vowels, "", getParamPost("chietkhau12"));
		
		$soxuatdakeugoi1=trim(getParamPost("soxuatdakeugoi1"));
		$tinhtrangduan1=trim(getParamPost("tinhtrangduan1"));		
		$gioithieu1=str_replace("'","&#8217;",getParamPost("content3"));// bo dau phay tren
		$tiendo1=str_replace("'","&#8217;",getParamPost("content4"));// bo dau phay tren
		$phaply1=str_replace("'","&#8217;",getParamPost("content5"));// bo dau phay tren
		
		///
		$tengiaidoan2=trim(getParamPost("tengiaidoan2"));
		$hinhthuc2=trim(getParamPost("hinhthuc2"));
		$soxuatdautu2=trim(getParamPost("soxuatdautu2"));
		
		$tongvondautu2=str_replace($vowels, "", getParamPost("tongvondautu2"));
		$sotienmotxuat2=str_replace($vowels, "", getParamPost("sotienmotxuat2"));
		$chietkhau2=str_replace($vowels, "", getParamPost("chietkhau2"));
		$chietkhau22=str_replace($vowels, "", getParamPost("chietkhau22"));
	
		$soxuatdakeugoi2=trim(getParamPost("soxuatdakeugoi2"));
		$tinhtrangduan2=trim(getParamPost("tinhtrangduan2"));		
		$gioithieu2=str_replace("'","&#8217;",getParamPost("content6"));// bo dau phay tren
		$tiendo2=str_replace("'","&#8217;",getParamPost("content7"));// bo dau phay tren
		$phaply2=str_replace("'","&#8217;",getParamPost("content8"));// bo dau phay tren
		
		//
		$tengiaidoan3=trim(getParamPost("tengiaidoan3"));
		$hinhthuc3=trim(getParamPost("hinhthuc3"));
		$soxuatdautu3=trim(getParamPost("soxuatdautu3"));
		
		$tongvondautu3=str_replace($vowels, "", getParamPost("tongvondautu3"));
		$sotienmotxuat3=str_replace($vowels, "", getParamPost("sotienmotxuat3"));
		$chietkhau3=str_replace($vowels, "", getParamPost("chietkhau3"));
		$chietkhau32=str_replace($vowels, "", getParamPost("chietkhau32"));
		
		$soxuatdakeugoi3=trim(getParamPost("soxuatdakeugoi3"));
		$tinhtrangduan3=trim(getParamPost("tinhtrangduan3"));		
		$gioithieu3=str_replace("'","&#8217;",getParamPost("content9"));// bo dau phay tren
		$tiendo3=str_replace("'","&#8217;",getParamPost("content10"));// bo dau phay tren
		$phaply3=str_replace("'","&#8217;",getParamPost("content11"));// bo dau phay tren
		
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
					$sql = "INSERT INTO sys_product (catID, name, alias, summary, content, model, delivery, product_in, promotion, position, solutions, tienich, vitri, price_old, price, tinh_trang, img, img1, pdf, date_create, lang, special_promotion, sort,giaidoan,xuatsu,manufacturers,chinhsach, title, description, keywords, tengiaidoan1,hinhthuc1,tongvondautu1,soxuatdautu1,sotienmotxuat1,soxuatdakeugoi1,tinhtrangduan1,gioithieu1,tiendo1,phaply1,tengiaidoan2,hinhthuc2,tongvondautu2,soxuatdautu2,sotienmotxuat2,soxuatdakeugoi2,tinhtrangduan2,gioithieu2,tiendo2,phaply2,tengiaidoan3,hinhthuc3,tongvondautu3,soxuatdautu3,sotienmotxuat3,soxuatdakeugoi3,tinhtrangduan3,gioithieu3,tiendo3,phaply3,chietkhau1,chietkhau12,chietkhau2,chietkhau22,chietkhau3,chietkhau32) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$delivery', '$product_in', '$promotion', '$position', '$solutions', '$tienich', '$vitri', '$price_old', '$price_new', '$tinh_trang', '$imgsmall', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$sort','$giaidoan','$str_xuatsu','$str_manufacturers','$chinhsach', '$title','$description','$keywords','$tengiaidoan1','$hinhthuc1','$tongvondautu1','$soxuatdautu1','$sotienmotxuat1','$soxuatdakeugoi1','$tinhtrangduan1','$gioithieu1','$tiendo1','$phaply1','$tengiaidoan2','$hinhthuc2','$tongvondautu2','$soxuatdautu2','$sotienmotxuat2','$soxuatdakeugoi2','$tinhtrangduan2','$gioithieu2','$tiendo2','$phaply2','$tengiaidoan3','$hinhthuc3','$tongvondautu3','$soxuatdautu3','$sotienmotxuat3','$soxuatdakeugoi3','$tinhtrangduan3','$gioithieu3','$tiendo3','$phaply3','$chietkhau1','$chietkhau12','$chietkhau2','$chietkhau22','$chietkhau3','$chietkhau32')";			
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
					$sql = "INSERT INTO sys_product (catID, name, alias, summary, content, model, delivery, product_in, promotion, position, solutions, tienich, vitri, price_old, price, tinh_trang, img, img1, pdf, date_create, lang, special_promotion, sort,giaidoan,xuatsu,manufacturers,chinhsach, title, description, keywords,tengiaidoan1,hinhthuc1,tongvondautu1,soxuatdautu1,sotienmotxuat1,soxuatdakeugoi1,tinhtrangduan1,gioithieu1,tiendo1,phaply1,tengiaidoan2,hinhthuc2,tongvondautu2,soxuatdautu2,sotienmotxuat2,soxuatdakeugoi2,tinhtrangduan2,gioithieu2,tiendo2,phaply2,tengiaidoan3,hinhthuc3,tongvondautu3,soxuatdautu3,sotienmotxuat3,soxuatdakeugoi3,tinhtrangduan3,gioithieu3,tiendo3,phaply3,chietkhau1,chietkhau12,chietkhau2,chietkhau22,chietkhau3,chietkhau32) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$delivery', '$product_in', '$promotion', '$position', '$solutions', '$tienich', '$vitri', '$price_old', '$price_new', '$tinh_trang', '$imgsmall', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$sort','$giaidoan','$str_xuatsu','$str_manufacturers','$chinhsach', '$title','$description','$keywords''$tengiaidoan1','$hinhthuc1','$tongvondautu1','$soxuatdautu1','$sotienmotxuat1','$soxuatdakeugoi1','$tinhtrangduan1','$gioithieu1','$tiendo1','$phaply1','$tengiaidoan2','$hinhthuc2','$tongvondautu2','$soxuatdautu2','$sotienmotxuat2','$soxuatdakeugoi2','$tinhtrangduan2','$gioithieu2','$tiendo2','$phaply2','$tengiaidoan3','$hinhthuc3','$tongvondautu3','$soxuatdautu3','$sotienmotxuat3','$soxuatdakeugoi3','$tinhtrangduan3','$gioithieu3','$tiendo3','$phaply3','$chietkhau1','$chietkhau12','$chietkhau2','$chietkhau22','$chietkhau3','$chietkhau32')";			
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
					//$sql = $db->GetUpdateSQL($rs, $record);
					$sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', delivery='$delivery', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', tienich='$tienich', vitri='$vitri', price_old = '$price_old', price = '$price_new', tinh_trang = '$tinh_trang', img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', sort = '$sort',giaidoan='$giaidoan',xuatsu='$str_xuatsu',manufacturers='$str_manufacturers',chinhsach='$chinhsach',title='$title',description='$description',keywords='$keywords',tengiaidoan1='$tengiaidoan1',hinhthuc1='$hinhthuc1',tongvondautu1='$tongvondautu1',soxuatdautu1='$soxuatdautu1',sotienmotxuat1='$sotienmotxuat1',soxuatdakeugoi1='$soxuatdakeugoi1',tinhtrangduan1='$tinhtrangduan1',gioithieu1='$gioithieu1',tiendo1='$tiendo1',phaply1='$phaply1',tengiaidoan2='$tengiaidoan2',hinhthuc2='$hinhthuc2',tongvondautu2='$tongvondautu2',soxuatdautu2='$soxuatdautu2',sotienmotxuat2='$sotienmotxuat2',soxuatdakeugoi2='$soxuatdakeugoi2',tinhtrangduan2='$tinhtrangduan2',gioithieu2='$gioithieu2',tiendo2='$tiendo2',phaply2='$phaply2',tengiaidoan3='$tengiaidoan3',hinhthuc3='$hinhthuc3',tongvondautu3='$tongvondautu3',soxuatdautu3='$soxuatdautu3',sotienmotxuat3='$sotienmotxuat3',soxuatdakeugoi3='$soxuatdakeugoi3',tinhtrangduan3='$tinhtrangduan3',gioithieu3='$gioithieu3',tiendo3='$tiendo3',phaply3='$phaply3',chietkhau1='$chietkhau1',chietkhau12='$chietkhau12',chietkhau2='$chietkhau2',chietkhau22='$chietkhau22',chietkhau3='$chietkhau3',chietkhau32='$chietkhau32' WHERE id=$id";
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
					//$sql = $db->GetUpdateSQL($rs, $record);
					//$sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."-".$id."', summary = '$summary', content = '$content', model = '$model', delivery='$delivery', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', tienich='$tienich', price_old = '$price_old', price = '$price_new', tinh_trang = '$tinh_trang', img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion' WHERE id=$id";
					$sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', delivery='$delivery', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', tienich='$tienich', vitri='$vitri', price_old = '$price_old', price = '$price_new', tinh_trang = '$tinh_trang', img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', sort = '$sort',giaidoan='$giaidoan',xuatsu='$str_xuatsu',manufacturers='$str_manufacturers',chinhsach='$chinhsach',title='$title',description='$description',keywords='$keywords',tengiaidoan1='$tengiaidoan1',hinhthuc1='$hinhthuc1',tongvondautu1='$tongvondautu1',soxuatdautu1='$soxuatdautu1',sotienmotxuat1='$sotienmotxuat1',soxuatdakeugoi1='$soxuatdakeugoi1',tinhtrangduan1='$tinhtrangduan1',gioithieu1='$gioithieu1',tiendo1='$tiendo1',phaply1='$phaply1',tengiaidoan2='$tengiaidoan2',hinhthuc2='$hinhthuc2',tongvondautu2='$tongvondautu2',soxuatdautu2='$soxuatdautu2',sotienmotxuat2='$sotienmotxuat2',soxuatdakeugoi2='$soxuatdakeugoi2',tinhtrangduan2='$tinhtrangduan2',gioithieu2='$gioithieu2',tiendo2='$tiendo2',phaply2='$phaply2',tengiaidoan3='$tengiaidoan3',hinhthuc3='$hinhthuc3',tongvondautu3='$tongvondautu3',soxuatdautu3='$soxuatdautu3',sotienmotxuat3='$sotienmotxuat3',soxuatdakeugoi3='$soxuatdakeugoi3',tinhtrangduan3='$tinhtrangduan3',gioithieu3='$gioithieu3',tiendo3='$tiendo3',phaply3='$phaply3',chietkhau1='$chietkhau1',chietkhau12='$chietkhau12',chietkhau2='$chietkhau2',chietkhau22='$chietkhau22',chietkhau3='$chietkhau3',chietkhau32='$chietkhau32' WHERE id=$id";
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