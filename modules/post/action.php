<?php	
	function getTopicpost($proID=""){
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
				
		$obj=new menuLevel();
		$obj->sql=$sql;		
		$arr=$obj->orderMenu();				
		return $arr;
	}
	//
	function addpost(){
		global $db, $lable,$lang;
		
				
		loadClass("convertString");
		$converString=new convertString();
		$username=getSession("username");
		$MemberID=getMemberNameID($username,"id");
		$catID=getParamPost("catID");		
		$name=trim(getParamPost("name"));
		
//		$alias= $obj->remoteDiacritic($name);	
		$alias= strtolower($converString->remoteDiacritic($name));
		//$converString->remoteDiacritic($rs->fields("htaccess"))
		//$product_in=str_replace($vowels, "", getParamPost("product_in"));	
		//$price_old=str_replace($vowels, "", getParamPost("price_old"));
		//$price_new=str_replace($vowels, "", getParamPost("price_new"));		
		//if(!$price_new) $price_new=0;
		//$summary=getParamPost("summary");
		$summary=str_replace("'","&#8217;",getParamPost("summary"));// bo dau phay tren
		
		//$content=getParamPost("content");	
		$content=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		
		$date=getParamPost("date");		
		$langID=$lang;		
		$id=getParamPost("id");		
		$imgsmall=getParamPost("imgsmall");
		$imgbig=getParamPost("imgbig");
		
		$model=trim(getParamPost("model"));
		
		$delivery=getParamPost("delivery");
		$promotion=trim(getParamPost("promotion"));
		$baohanh=getParamPost("baohanh");
		
				
		$position=getParamPost("position");
		$solutions=getParamPost("solutions");
		$cooperation=getParamPost("cooperation");
		$search_criteria=getParamPost("search_criteria");
		$hang_san_xuat=getParamPost("hang_san_xuat");
		$tinh_trang=getParamPost("tinh_trang");
		
		$manufacturers=getParamPost("manufacturers");
		$xuatsu=getParamPost("xuatsu");
		
		$loai=getParamPost("loai");
		$linhvuc=getParamPost("linhvuc");
		
		
		
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
		//Ghi du lieu vao base
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/images/product/$filePDF";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_product WHERE 0 = -1";
			$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);			
			$sql = "INSERT INTO sys_product (catID, name, alias, summary, content, model, delivery, product_in, promotion, position, solutions, owner, technical, price,  img, img1, pdf, date_create, lang, special_promotion, sort,xuatsu,manufacturers,baiviet, title, description, keywords,MemberID) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$delivery', '$product_in', '$promotion', '$position', '$solutions', '$owner', '$technical', '$price_new', '$filePDF', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$sort','$str_xuatsu','$str_manufacturers','$baiviet', '$title','$description','$keywords','$MemberID')";
					
			$return=$db->Execute($sql);		
				
		}else{			
			$sql = "SELECT * FROM sys_product WHERE id=$id";
			$rs = $db->Execute($sql);						
			//$sql = $db->GetUpdateSQL($rs, $record);
			$sql= "UPDATE sys_product SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', delivery='$delivery', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', owner='$owner', technical='$technical', price = '$price_new',  img = '$filePDF', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', sort = '$sort',xuatsu='$str_xuatsu',manufacturers='$str_manufacturers',baiviet='$baiviet',title='$title',description='$description',keywords='$keywords',MemberID='$MemberID' WHERE id=$id";
			
			$return=$db->Execute($sql);
			
							
		}	
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=post&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="../user_list/";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function getpostList($all,$pageID,$limit=20){
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
	function getpostID($proID){
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
	function deletepost(){
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
		postList();
	}
	//
	function lockpost(){
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
		$ret_page="?m=post&op=photo&id=$id";
		$a=new msgBox('Error!',"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
		}
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/product/".$imgsmall;
			moveFile($from,$to);			
		}
		@unlink($sourcefile);
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if(file_exists($sourcefile)){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/product/".$imgbig;
			moveFile($from,$to);
			
		}
		@unlink($sourcefile);		
		
		if(!$idPhoto) $sql="INSERT INTO sys_product_photo(proid,img,img1) VALUES ($id,'$imgsmall','$imgbig')";		
		else $sql="UPDATE sys_product_photo SET img='$imgsmall',img1='$imgbig' WHERE id=$idPhoto";
			
		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=post&op=photo&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	function getpostListPhoto($proID){
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
		postListPhoto();
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
		$ret_page="?m=post&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function getpostListFile($proID){
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
		postListFile();
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
	function get_product_list_user($id)
	{
		global $db, $lang, $lable;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		
		$sql="SELECT sys_product.*, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, TO_DAYS(sys_product.date_end) as today, sys_function.htaccess as url";
		$sql.=" FROM sys_product,sys_function";
		//$sql.=" WHERE (sys_product.memberID =  '$id') AND (sys_product.catID=sys_function.id) AND (sys_product.ctrl&1=1)";	
		$sql.=" WHERE (sys_product.memberID =  '$id') AND (sys_product.catID=sys_function.id)";		
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
	function get_product_list_user_off($id)
	{
		global $db, $lang, $lable;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		
		$sql="SELECT sys_product.*, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, TO_DAYS(sys_product.date_end) as today, sys_function.htaccess as url";
		$sql.=" FROM sys_product,sys_function";
		$sql.=" WHERE (sys_product.memberID =  '$id') AND (sys_product.catID=sys_function.id) AND (sys_product.ctrl&1=1)";	
		//$sql.=" WHERE (sys_product.memberID =  '$id') AND (sys_product.catID=sys_function.id)";		
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
	function get_product_list_user_bookmarked($id)
	{
		global $db, $lang, $lable;
		
		$hsx= getParam("hsx");
		$tech=getParam("tech");		
		$sort_by=getParam("sort_by");
		
		
		$sql="SELECT sys_product.*, TO_DAYS(sys_product.date_end) as today, sys_function.htaccess as url";
		$sql.=" FROM sys_product,sys_function, luubai";
		$sql.=" WHERE (luubai.user_id =  '$id') AND (sys_product.catID=sys_function.id) AND (sys_product.id=luubai.post_id) AND (sys_product.ctrl&1=1)";		
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
?>