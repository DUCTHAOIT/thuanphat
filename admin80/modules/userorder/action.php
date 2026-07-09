<?php	
	function getTopicuserorder($proID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="id";
		// list cac dau muc la userorder
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
	function adduserorder(){
		global $db, $lable,$lang;
		
		

		$vowels = array(".",",");
				
		loadClass("convertString");
		$converString=new convertString();
		
		$catID=getParamPost("catID");		
		$name=trim(getParamPost("name"));
		$userid=getParamPost("userid");
		
//		$alias= $obj->remoteDiacritic($name);	
		$alias= strtolower($converString->remoteDiacritic($name));
		//$converString->remoteDiacritic($rs->fields("htaccess"))
		$product_in=str_replace($vowels, "", getParamPost("product_in"));	
		$price_old=str_replace($vowels, "", getParamPost("price_old"));
		$price_new=str_replace($vowels, "", getParamPost("price_new"));		
		if(!$price_new) $price_new=0;
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
		//$technical=getParamPost("contents");
		$technical=str_replace("'","&#8217;",getParamPost("contents"));// bo dau phay tren
		
		//$owner=getParamPost("content1");
		$owner=str_replace("'","&#8217;",getParamPost("content1"));// bo dau phay tren
		$baiviet=str_replace("'","&#8217;",getParamPost("content2"));// bo dau phay tren
				
		$position=getParamPost("position");
		$solutions=getParamPost("solutions");
		$cooperation=getParamPost("cooperation");
		$search_criteria=getParamPost("search_criteria");
		$hang_san_xuat=getParamPost("hang_san_xuat");
		$tinh_trang=getParamPost("tinh_trang");
		
		$manufacturers=getParamPost("manufacturers");
		
		
		$loai=getParamPost("loai");
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
			$to=_DOMAIN_ROOT_PATH."/images/userorder/".$imgsmall;
			moveFile($from,$to);			
		}
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if(file_exists($sourcefile)){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/userorder/".$imgbig;
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
		$record["owner"]=$owner;
		$record["position"]=$position;
		$record["solutions"]=$solutions;
		$record["cooperation"]=$cooperation;
		
		$record["search_criteria"]=$str_search_criteria;
		$record["hang_san_xuat"]=$hang_san_xuat;	
		$record["tinh_trang"]=$tinh_trang;		
		$record["pdf"]=$filePDF;		
		$record["special_promotion"]=$special_promotion;
		
		
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
			$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);			
			$sql = "INSERT INTO sys_userorder (catID, name, alias, summary, content, model, delivery, product_in, promotion, position, solutions, owner, technical, price, price_old,  img, img1, pdf, date_create, lang, special_promotion, sort,userid,manufacturers,baiviet, title, description, keywords,baohanh,tinh_trang) VALUES ( '$catID', '$name', '$alias', '$summary', '$content', '$model',  '$delivery', '$product_in', '$promotion', '$position', '$solutions', '$owner', '$technical', '$price_new', '$price_old', '$imgsmall', '$imgbig', '$filePDF', '$date', '$langID', '$special_promotion', '$sort','$userid','$str_manufacturers','$baiviet', '$title','$description','$keywords','$baohanh','$tinh_trang')";			
			$return=$db->Execute($sql);
			/*
			Upload nhieu anh cho sp
			if($return){
				$idNew=$db->Insert_ID();
				foreach($_FILES['img_file']['name'] as $name => $value)
				{
					$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
					$source_img = $_FILES['img_file']['tmp_name'][$name];
					$path_img = _DOMAIN_ROOT_PATH."/images/userorder/".$name_img;	
					
					move_uploaded_file($source_img, $path_img);
					
					$sql="INSERT INTO sys_userorder_photo(proid, img, img1) VALUES('$idNew','$name_img',NOW())";
					$return=$db->Execute($sql); 
				}	
			}
			*/	
				
		}else{			
			$sql = "SELECT * FROM sys_userorder WHERE id=$id";
			$rs = $db->Execute($sql);						
			//$sql = $db->GetUpdateSQL($rs, $record);
			$sql= "UPDATE sys_userorder SET catID = '$catID', name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', model = '$model', delivery='$delivery', product_in='$product_in', promotion='$promotion', position='$position', solutions='$solutions', owner='$owner', technical='$technical', price = '$price_new', price_old='$price_old',  img = '$imgsmall', img1 = '$imgbig', pdf = '$filePDF', date_create = '$date', lang = '$langID', special_promotion = '$special_promotion', sort = '$sort',userid='$userid',manufacturers='$str_manufacturers',baiviet='$baiviet',title='$title',description='$description',keywords='$keywords',baohanh='$baohanh',tinh_trang='$tinh_trang' WHERE id=$id";
			
			$return=$db->Execute($sql);
			
							
		}		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=userorder&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=userorder";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function getuserorderList($all,$pageID,$limit=20){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, TO_DAYS(sys_userorder.date_create) as today FROM sys_userorder ORDER BY today DESC";
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
	function getuserorderID($proID){
		global $db;
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*, DATE_FORMAT(date_create, '%Y-%m-%d') as date_create";
		$obj->tableName="sys_userorder";		
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/userorder/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/userorder/".$arr["img1"];
		return $arr;
	}
	
	//
	function deleteuserorder(){
		global $db,$lable;
		$proID=getParamPost("id");
		loadClass("constructSql");		
		$obj=new constructSql();
		//Xoa file anh
		$obj->tableName="sys_userorder";
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		if(($rs->fields("img")) or ($rs->fields("img1"))){
			loadClass("fileSystem");
			$objs=new fileSystem();
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/userorder/".$rs->fields("img"));
			$objs->delFile(_DOMAIN_ROOT_PATH ."/images/userorder/".$rs->fields("img1"));
		}
		
		//xoa trong bang userorder
		$obj->tableName="sys_userorder";
		$obj->where="id=$proID";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);		
		
		if(!$return) echo _NO_DELETE_SUCCESSFU;
		userorderList();
	}
	//
	function lockuserorder(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_userorder SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_userorder WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	//
	function addPhoto(){
		global $db;
		$id=getParamPost("id");
		foreach($_FILES['img_file']['name'] as $name => $value)
		{
			$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
			$source_img = $_FILES['img_file']['tmp_name'][$name];
			$path_img = _DOMAIN_ROOT_PATH."/images/userorder/".$name_img;	
			
			move_uploaded_file($source_img, $path_img);
			
			$sql="INSERT INTO sys_userorder_photo(proid, img, img1) VALUES('$id','$name_img',NOW())";
			$return=$db->Execute($sql); 
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=userorder&op=photo&id=$id";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=userorder&op=photo&id=$id";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		
	}
	//
	function getuserorderListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_userorder_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function deletePhoto(){
		global $db;
		$id=getParamPost("photoID");
		$sql="DELETE FROM sys_userorder_photo WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		userorderListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_userorder_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/userorder/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/userorder/".$arr["img1"];
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
	function getarruser(){
		global $db;
		$sql="SELECT * FROM user WHERE (ctrl&1=1) ORDER BY id DESC";
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
		$sql="SELECT * FROM tinh_trang ORDER BY sort ASC";
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
	
		if(!$idFile) $sql="INSERT INTO sys_userorder_file(proid,file,content,name,date_create,size) VALUES ($id,'$file','$content','$name','$date_create','$size')";		
		else $sql="UPDATE sys_userorder_file SET file='$file',content='$content',name='$name',date_create='$date_create',size='$size' WHERE id=$idFile";		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=userorder&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function getuserorderListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_userorder_file WHERE proid=$proID";				
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	//
	function deleteFile(){
		global $db;
		$id=getParamPost("fileID");
		$sql="DELETE FROM sys_userorder_file WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		userorderListFile();
	}	
	//
	function getFileID($id){
		global $db;
		$sql="SELECT * FROM sys_userorder_file WHERE id=$id";		
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
		$sql="UPDATE sys_userorder_file SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_userorder_file WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
?>