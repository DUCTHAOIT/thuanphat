<?php	
	function getTopicalbums($proID=""){
		global $db,$moduleName,$lang;
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND module='$moduleName' AND (ctrl&1=1) ORDER BY id";
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function addalbums(){
		global $db, $lable;
		$vowels = array(".",",");
		loadClass("convertString");
		$obj= new convertString;
		
		$catID=getParamPost("catID");		
		$name=trim(getParamPost("name"));
		$alias= $obj->remoteDiacritic($name);		
		$price_old=str_replace($vowels, "", getParamPost("price_old"));
		$price_new=str_replace($vowels, "", getParamPost("price_new"));		
		
		$summary=getParamPost("summary");
		$content=getParamPost("content");		
		$date=getParamPost("date");		
		$langID=getParamPost("lang");		
		$id=getParamPost("id");		
		$imgsmall=getParamPost("imgsmall");
		$imgbig=getParamPost("imgbig");
		
		$model=trim(getParamPost("model"));
		$product_in=trim(getParamPost("product_in"));
		$delivery=trim(getParamPost("delivery"));
		$promotion=trim(getParamPost("promotion"));
		$technical=getParamPost("contents");
		$search_criteria=getParamPost("search_criteria");
		$hang_san_xuat=getParamPost("hang_san_xuat");
		$khach_hang=getParamPost("khach_hang");
		$special_promotion=getParamPost("special_promotion");
		
		//if($special_promotion) $special_promotion = 1;
		$special_promotion = 0;
		
		
		if($search_criteria){
			foreach ($search_criteria as $key=>$value){
				$str_search_criteria.=":". $value. ":";
			}
			//$str_search_criteria.=":";
		}
		
		$filePDF=getParamPost("filePDF");		
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/albums/".$imgsmall;
			moveFile($from,$to);			
		}
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if(file_exists($sourcefile)){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/albums/".$imgbig;
			moveFile($from,$to);
			
		}		
		//Ghi du lieu vao base
		$record=array();
		$record["name"]=$name;
		$record["catID"]=$catID;
		$record["alias"]=$alias;
		$record["price_old"]=$price_old;
		$record["price"]=$price_new;
		$record["summary"]=$summary;
		$record["content"]=$content;
		$record["date_create"]=$date;
		$record["lang"]=$langID;		
		$record["img"]=$imgsmall;
		$record["img1"]=$imgbig;
		
		$record["model"]=$model;
		$record["product_in"]=$product_in;
		$record["delivery"]=$delivery;
		$record["promotion"]=$promotion;
		$record["technical"]=$technical;
		$record["search_criteria"]=$str_search_criteria;
		$record["hang_san_xuat"]=$hang_san_xuat;	
		$record["khach_hang"]=$khach_hang;		
		$record["pdf"]=$filePDF;		
		$record["special_promotion"]=$special_promotion;
		
		
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_product WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);			
			$return=$db->Execute($sql);			
		}else{			
			$sql = "SELECT * FROM sys_product WHERE id=$id";
			$rs = $db->Execute($sql);						
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);			
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=albums&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=albums";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function getalbumsList($all,$pageID,$limit=20){
		global $db,$lang,$moduleName;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		$catID=getParam("catID");		
		if(!$catID) { $catID=getParamPost("catID");	}
			
	//	echo "duong".$hang_san_xuat;							
			if(!$keyword){
				$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat";
				$obj->tableName="sys_product ,sys_function";		
						
				if(!$catID){ $obj->where="(sys_product.catID =  sys_function.id) AND (sys_product.special_promotion = 0)";}
				else {$obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id) AND (sys_product.special_promotion = 0)";}						
				$obj->orderBy="today DESC";						
			}else{		
				$obj->fieldsName="sys_product.*, DATE_FORMAT(sys_product.date_create, '".format_date()."') as date_create, TO_DAYS(sys_product.date_create) as today, sys_function.name as nameCat, match(sys_product.name) against('$keyword' in boolean mode) as relevance";
				$obj->tableName="sys_product ,sys_function";
				
				if(!$catID) $obj->where="(sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.summary) AND (sys_product.special_promotion = 0) against('$keyword' in boolean mode))";		
				else $obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id) AND (sys_product.special_promotion = 0) AND (match(sys_product.name, sys_product.summary) against('$keyword' in boolean mode))";		 			
				
				$obj->orderBy="relevance DESC";				
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
	function getalbumsID($proID){
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
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/albums/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/albums/".$arr["img1"];
		return $arr;
	}
	
	//
	function deletealbums(){
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
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/albums/".$rs->fields("img"));
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/albums/".$rs->fields("img1"));
		}
		
		//xoa trong bang albums
		$obj->tableName="sys_product";
		$obj->where="id=$proID";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);		
		
		if(!$return) echo _NO_DELETE_SUCCESSFU;
		albumsList();
	}
	//
	function lockalbums(){
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
	function addPhoto(){
		global $db;
		$uploaddir = _DOMAIN_ROOT_PATH."/temp/";
		$id=getParamPost("id");
		$imgsmall=getParamPost("imgsmall");
		$imgbig=getParamPost("imgbig");
		$idPhoto=getParam("idPhoto");
		
		if(!$imgsmall && !$imgbig){
			include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=albums&op=photo&id=$id";
		$a=new msgBox('Error!',"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
		}
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/albums/".$imgsmall;
			moveFile($from,$to);			
		}
		@unlink($sourcefile);
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if(file_exists($sourcefile)){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/albums/".$imgbig;
			moveFile($from,$to);
			
		}
		@unlink($sourcefile);		
		
		if(!$idPhoto) $sql="INSERT INTO sys_product_photo(proid,img,img1) VALUES ($id,'$imgsmall','$imgbig')";		
		else $sql="UPDATE sys_product_photo SET img='$imgsmall',img1='$imgbig' WHERE id=$idPhoto";
			
		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=albums&op=photo&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	function getalbumsListPhoto($proID){
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
		albumsListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_product_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/albums/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/albums/".$arr["img1"];
		return $arr;
	}
	//
	/**
	 * Hang san xuat
	 *
	 */	
	function manufacturers(){
		global $db;
		$sql="SELECT * FROM hang_san_xuat ORDER BY name ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	////
	function khach_hang(){
		global $db;
		$sql="SELECT * FROM user ORDER BY date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	/**
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
?>