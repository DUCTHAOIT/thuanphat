<?php
	function getGroupArticle($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='worldwide')";
		$obj->limit="all";
		$obj->orderBy="sort";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		return $arr;		
	}	
	function getTopicProduct($proID=""){
		global $db,$moduleName;
		$sql="SELECT * FROM sys_function WHERE module='worldwide' AND (ctrl&1=1) ORDER BY sort ASC";	
		$arr=$db->GetAssoc($sql);				
		return $arr;
	}
	function updateworldwide(){
		global $db;		
		
		$id=getParamPost("id");
		$catID=getParamPost("catID");	
		
		$name=getParamPost("name");
		$address=getParamPost("address");
		$tel=getParamPost("tel");
		$website=getParamPost("website");
		//$des=getParamPost("des");
		$lang=getParamPost("lang");
		$no=getParamPost("no");
		$position=getParamPost("position");		
		$fileName=getParamPost("fileName");
		$catid=getParamPost("catid");
		$des=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		
		loadClass("convertString");
		$obj= new convertString;
		$alias=$obj->remoteDiacritic($name);	
		
		$filePDF=getParamPost("filePDF");		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		$record=array();
		
		$record["catID"]=$catID;
		$record["name"]=$name;
		$record["alias"]=$alias;
		$record["address"]=$address;
		$record["tel"]=$tel;
		$record["website"]=correct_url($website);
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["no"]=$no;
		$record["position"]=$position;		
		$record["img"]=$fileName;
		
		$record["pdf"]=$filePDF;	
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/images/worldwide/$fileName";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_worldwide WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql="INSERT INTO sys_worldwide ( name, tel, address, website, des, img, no, lang, position, pdf, alias, catID ) VALUES ( '$name', '$tel', '$address', '$website', '$des', '$fileName', '$no', '$lang', '$position', '$pdf', '$alias', '$catID' )";
		//	$sql = $db->GetInsertSQL($rs, $record);
		
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_worldwide WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql= "UPDATE sys_worldwide SET name = '$name', tel = '$tel', address = '$address', website = '$website', des = '$des', img = '$fileName', no = '$no', lang = '$lang', position = '$position', pdf = '$pdf', alias = '$alias', catID = '$catID' WHERE id=$id";
			//$sql = $db->GetUpdateSQL($rs, $record);
			
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=worldwide";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=worldwide&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getworldwideList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$keyword=getParamPost("keyword");		
		$catID=getParamPost("catID");
		
		$obj->fieldsName="sys_worldwide.*, sys_function.name as funname";
		if($catID){ $obj->where.="(sys_worldwide.catID=$catID) AND";}
		if($keyword){  $obj->where.="(sys_worldwide.name LIKE '%".$keyword."%') AND ";	}
		$obj->where.=" sys_function.id =  sys_worldwide.catID ";	
		$obj->tableName="sys_worldwide,sys_function";	
		$obj->fieldsLang="sys_worldwide";
		$obj->limit="all";
		$obj->orderBy="sys_worldwide.no DESC";
		$sql=$obj->sqlSelect();		
	//	echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockworldwide(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_worldwide SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_worldwide WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function correct_url($url)// dua url ve dang chuan http://www.namedomain.com
	{
		If ($url==FALSE) {
		return $url;
		}
		$url=parse_url($url);
		If (stristr($url['host'], "www")==FALSE and $url['scheme']==FALSE and stristr($url['path'], "www")==FALSE) {
		$url['host']="www." .$url['host'];
		}
		$new_url="http:" .$url['port'] ."//" .$url['host'] .$url['path'];
		If ($url['query']!=FALSE) {
		$new_url=$new_url ."?" .$url['query'];
		}
		If ($url['fragment']!=FALSE) {
		$new_url=$new_url ."#" .$url['fragment'];
		}
		return $new_url;
	}
	//
	function worldwideDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_worldwide WHERE id=$id";		
		$db->Execute($sql);
		worldwideList();
	}	
	//
	function getworldwideID($id){
		global $db;
		$sql="SELECT * FROM sys_worldwide WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getworldwideCat($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_worldwide_cat";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
?>