<?php
	function getGrouphieuqua($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='hieuqua')";
		$obj->limit="all";
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);

		$sql="SELECt * FROM sys_hieuqua_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			//echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function getGroupProduct($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='product')";
		$obj->limit="all";
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);	
		$sql="SELECt * FROM sys_hieuqua_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function updatehieuqua(){
		global $db,$lang;			
		$id=getParamPost("id");
		$loai=1;
		$giatri1=getParamPost("giatri1");
		$giatri2=getParamPost("giatri2");		
		$giatri3=getParamPost("giatri3");		
		
		$date_create=getParamPost("date");
		
		$nam=date("Y", strtotime($date_create)); // gives 201101
		$thang=date("m", strtotime($date_create)); // gives 201101
		$ngay=date("d", strtotime($date_create)); // gives 201101
		
		$namvni=date("Y", strtotime($date_create)); // gives 201101
		$thangvni=date("m", strtotime($date_create)); // gives 201101
		$ngayvni=date("d", strtotime($date_create)); // gives 201101
		
		
		
		if(!$id){
			$sql = "SELECT * FROM sys_hieuqua WHERE 0 = -1";
			$rs = $db->Execute($sql);
			
			$sqlupdown="SELECT * FROM  sys_hieuqua WHERE (ctrl&1=1) ORDER BY date_create DESC LIMIT 0 , 1";	
			$rsupdown = $db->Execute($sqlupdown);
			$giatriupdown1=$rsupdown->fields("giatri1");
			$giatriupdown3=$rsupdown->fields("giatri3");
			
			$tangtruong1=($giatri1-$giatriupdown1)/$giatriupdown1*100;
			$tangtruong1=round($tangtruong1,2);
			
			$tangtruong2=($giatri3-$giatriupdown3)/$giatriupdown3*100;
			$tangtruong2=round($tangtruong2,2);
			
			//$sql = $db->GetInsertSQL($rs, $record);				
			$sql = "INSERT INTO sys_hieuqua ( giatri1, giatri2, giatri3, nam, thang, ngay, namvni, thangvni, ngayvni, date_create, lang, tangtruong1, tangtruong2, loai) VALUES ( '$giatri1', '$giatri2', '$giatri3', '$nam', '$thang', '$ngay', '$namvni', '$ngayvni', '$thangvni', '$date_create', '$lang', '$tangtruong1', '$tangtruong2','$loai')";				
			$return=$db->Execute($sql);
			//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_hieuqua_cat					
		}else{
			$sql = "SELECT * FROM sys_hieuqua WHERE id=$id";
			$rs = @$db->Execute($sql);
			
			
			//$sqlupdown="SELECT * FROM  sys_hieuqua WHERE (ctrl&1=1) ORDER BY date_create DESC LIMIT 1,2";	
			//$arrCat=$db->getAssoc($sql);
			//$rsupdown = $db->Execute($sqlupdown);
			//$giatriupdown1=$rsupdown->fields("giatri1");
			//$giatriupdown3=$rsupdown->fields("giatri3");
			
			//$tangtruong1=($giatri1-$giatriupdown1)/$giatriupdown1*100;
			//$tangtruong1=round($tangtruong1,2);
			
			//$tangtruong2=($giatri3-$giatriupdown3)/$giatriupdown3*100;
			//$tangtruong2=round($tangtruong2,2);
			//echo $giatri3."-".$giatriupdown3."-".$tangtruong2;
			//return;	
			//$sql = @$db->GetUpdateSQL($rs, $record);					
			$sql= "UPDATE sys_hieuqua SET giatri1 = '$giatri1', giatri2 = '$giatri2', giatri3 = '$giatri3', nam = '$nam', thang = '$thang', ngay = '$ngay', namvni = '$namvni', thangvni = '$thangvni', ngayvni = '$ngayvni', date_create = '$date_create', loai = '$loai' WHERE id=$id";
			$return=$db->Execute($sql);
			//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_hieuqua_cat
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=hieuqua2&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=hieuqua2";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function arrList(){		
		global $db,$lang;		
		$sql="SELECT sys_hieuqua.*, DATE_FORMAT(sys_hieuqua.date_create, '".format_date()."') as date_create FROM sys_hieuqua WHERE (lang='$lang') AND (loai=1) ORDER BY sys_hieuqua.date_create DESC";
	
		$arr=$db->GetAssoc($sql);					
		return $arr;
	}
	//
	function checkFuncName($arr,$k){
		foreach($arr as $key=>$value){
			if($value["artID"]==$k) $name .= $value["name"].",";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function gethieuquaID($id){
		if(!$id) return;
		global $db;		
		loadClass("constructSql");
		$selectID = $selectID["selectID"];
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_hieuqua";
		//$obj->fieldsLang="sys_hieuqua";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function deletehieuqua(){
		global $db;
		$id=getParamPost("id");
		if(!$id){			
			messange(_ERRO);
			listhieuqua();
			return;
		}		
		loadClass("constructSql");		
		$obj=new constructSql();				
		$obj->tableName="sys_hieuqua";
		$obj->where="sys_hieuqua.id =  $id";
		$obj->limit="all";		
		$sql=$obj->sqlDelete();	
		
		if(!$db->Execute($sql)){
			messange(_ERRO);
		}else{			
			messange(_DELETE_SUCCESSFU);
		}
		listhieuqua();
	}
	//
	//
	function lockhieuqua(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_hieuqua SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_hieuqua WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
?>