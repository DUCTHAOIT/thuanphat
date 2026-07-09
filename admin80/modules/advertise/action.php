<?php
	function updateAdvertise(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");
		$address=getParamPost("address");
		$tel=getParamPost("tel");
		$website=getParamPost("website");
		$des=getParamPost("des");
		$lang=getParamPost("lang");
		$no=getParamPost("no");
		$position=getParamPost("position");		
		$fileName=getParamPost("fileName");
		$catid=getParamPost("catid");
		
		$filePDF=getParamPost("filePDF");		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		$record=array();
		$record["name"]=$name;
		$record["address"]=$address;
		$record["tel"]=$tel;
		$record["website"]=correct_url($website);
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["no"]=$no;
		$record["position"]=$position;		
		$record["img"]=$fileName;
		$record["catid"]=$catid;
		$record["pdf"]=$filePDF;	
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/images/advertise/$fileName";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_advertise WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_advertise WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=advertise";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=advertise&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getAdvertiseList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_advertise";	
		$obj->fieldsLang="sys_advertise";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockAdvertise(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_advertise SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_advertise WHERE  id=$id";
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
	function advertiseDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_advertise WHERE id=$id";		
		$db->Execute($sql);
		advertiseList();
	}	
	//
	function getAdvertiseID($id){
		global $db;
		$sql="SELECT * FROM sys_advertise WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getAdvertiseCat($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_advertise_cat";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
?>