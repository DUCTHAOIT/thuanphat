<?php	
	function getTopicvoucher($proID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="id";
		// list cac dau muc la voucher
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
	function addvoucher(){
		global $db, $lable,$lang;
		

		$vowels = array(".",",");
		
		$userid=getParamPost("userid");
		$id=getParamPost("id");
		$des=getParamPost("des");
		
		$loai=str_replace($vowels, "", getParamPost("loai"));
		$soluong=str_replace($vowels, "", getParamPost("soluong"));
		
		if(!$id){	
			$name=generateRandomString();
			for ($i = 1; $i <= $soluong; $i++) {
				$name=generateRandomString();
				$sql = "SELECT * FROM sys_voucher WHERE 0 = -1";
				$rs = $db->Execute($sql);		
				$sql = "INSERT INTO sys_voucher (name, loai, des) VALUES ( '$name', '$loai', '$des')";			
				$return=$db->Execute($sql);
			}
		}else{			
			$sql = "SELECT * FROM sys_voucher WHERE id=$id";
			$rs = $db->Execute($sql);						
			//$sql = $db->GetUpdateSQL($rs, $record);
			$sql= "UPDATE sys_voucher SET name = '$name', loai = '$loai', des = '$des' WHERE id=$id";
			
			$return=$db->Execute($sql);
			
							
		}		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=voucher&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=voucher";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function getvoucherList_($all,$pageID,$limit=20){
		global $db;
		$sql="SELECT sys_voucher.*, DATE_FORMAT(sys_voucher.date_create, '%d/%m/%Y') as date_create, TO_DAYS(sys_voucher.date_create) as today FROM sys_voucher WHERE loai=0 AND hdban=0 ORDER BY today DESC";
		//echo $sql."<br>";
		//return;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;			
		return $arr;
	}
	//
	function getvoucherList($all,$pageID,$limit=20){
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$userid=getParam("userid");
		$obj->fieldsName="sys_voucher.*, DATE_FORMAT(sys_voucher.date_create, '%d/%m/%Y') as date_create";
		$obj->tableName="sys_voucher";
		//$obj->where="sys_voucher.loai=0 AND sys_voucher.hdban=0 AND user.id=sys_voucher.userid";
		//$obj->where="sys_voucher.name='1bwISI1cX1C'";	
		//if($userid) $obj->where.=" AND sys_voucher.userid='".$userid."'";	
		$obj->groupBy="sys_voucher.id";
		$obj->orderBy="sys_voucher.id DESC";	
		$obj->fieldsLang="sys_voucher";
		
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
	//
	function getvoucherListBan($all,$pageID,$limit=20){
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$userid=getParam("userid");
		$obj->fieldsName="sys_voucher.*, DATE_FORMAT(sys_voucher.date_create, '%d/%m/%Y') as date_create, user.name username";
		$obj->tableName="sys_voucher ,user";
		$obj->where="sys_voucher.loai=0 AND sys_voucher.hdban>0 AND user.id=sys_voucher.userid";	
		if($userid) $obj->where.=" AND sys_voucher.userid='".$userid."'";	
		$obj->groupBy="sys_voucher.id";
		$obj->orderBy="sys_voucher.id DESC";	
		$obj->fieldsLang="sys_voucher";
		
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
	//
	function checkFuncName($arr,$k){
		foreach($arr as $key=>$value){
			if($value["proID"]==$k) $name .= $value["name"].",";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function getvoucherID($proID){
		global $db;
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*, DATE_FORMAT(date_create, '%Y-%m-%d') as date_create";
		$obj->tableName="sys_voucher";		
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;
	}
	//
	//
	function deleteban(){
		global $db;
		
		$id=getParam("id");
		
		$sql="DELETE FROM  sys_voucher WHERE (id=$id)";
		$result=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=voucher&f=hdban";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	
	//
	function deletevoucher(){
		global $db,$lable;
		$proID=getParamPost("id");
		loadClass("constructSql");		
		$obj=new constructSql();
		//Xoa file anh
		$obj->tableName="sys_voucher";
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		
		//xoa trong bang voucher
		$obj->tableName="sys_voucher";
		$obj->where="id=$proID";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);		
		
		if(!$return) echo _NO_DELETE_SUCCESSFU;
		voucherList();
	}
	//
	function lockvoucher(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_voucher SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_voucher WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	//
	function daban(){
		global $db,$lang,$lable;		
		$id=getParam("id");	
		$hdban=getParam("hdban");	
		$soluongban=getParam("soluongban");	
		$sql="UPDATE sys_voucher SET trangthai=IF(trangthai=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		
		$sqlconlai="SELECT * FROM sys_voucher WHERE  id=$hdban";
		$rs=$db->Execute($sqlconlai);
		$conlai=$rs->fields("model");
		$price_old=$conlai*$rs->fields("price");
		if($conlai>0){
			$sqlhdban="UPDATE sys_voucher SET product_in='0', price_old='$price_old' WHERE id=$hdban";		
			$db->Execute($sqlhdban);
		}else{
			$sqlhdban="UPDATE sys_voucher SET trangthai=IF(trangthai=0,1,0), `product_in`=`product_in`-$soluongban WHERE id=$hdban";		
			$db->Execute($sqlhdban);
		}
	
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=voucher&f=hdban";
	
		$a=new msgBox("Xac thuc thanh cong","OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();	
	}
	//
	function huy(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_voucher SET trangthai=2 WHERE id=$id";		
		$db->Execute($sql);
		
		$sqlhuy="SELECT * FROM sys_voucher WHERE id=$id";
		$rs=$db->Execute($sqlhuy);
		$luonghuy=$rs->fields("model");
		$hdban=$rs->fields("hdban");
		
		$sql="UPDATE sys_voucher SET model=model+'".$luonghuy."', product_in=product_in-'".$luonghuy."' WHERE id=$hdban";	
			
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=voucher&f=hdban";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function addPhoto(){
		global $db;
		$id=getParamPost("id");
		foreach($_FILES['img_file']['name'] as $name => $value)
		{
			$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
			$source_img = $_FILES['img_file']['tmp_name'][$name];
			$path_img = _DOMAIN_ROOT_PATH."/images/voucher/".$name_img;	
			
			move_uploaded_file($source_img, $path_img);
			
			$sql="INSERT INTO sys_voucher_photo(proid, img, img1) VALUES('$id','$name_img',NOW())";
			$return=$db->Execute($sql); 
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=voucher&op=photo&id=$id";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=voucher&op=photo&id=$id";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		
	}
	//
	function getvoucherListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_voucher_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function deletePhoto(){
		global $db;
		$id=getParamPost("photoID");
		$sql="DELETE FROM sys_voucher_photo WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		voucherListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_voucher_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/voucher/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/voucher/".$arr["img1"];
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
	
		if(!$idFile) $sql="INSERT INTO sys_voucher_file(proid,file,content,name,date_create,size) VALUES ($id,'$file','$content','$name','$date_create','$size')";		
		else $sql="UPDATE sys_voucher_file SET file='$file',content='$content',name='$name',date_create='$date_create',size='$size' WHERE id=$idFile";		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=voucher&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function getvoucherListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_voucher_file WHERE proid=$proID";				
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	//
	function deleteFile(){
		global $db;
		$id=getParamPost("fileID");
		$sql="DELETE FROM sys_voucher_file WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		voucherListFile();
	}	
	//
	function getFileID($id){
		global $db;
		$sql="SELECT * FROM sys_voucher_file WHERE id=$id";		
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
		$sql="UPDATE sys_voucher_file SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_voucher_file WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
?>