<?php
	function updateWeblink(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");
		$url=getParamPost("url");		
		$no=getParamPost("no");	
		$des=getParamPost("des");	
		$lang=getParamPost("lang");	
		$fileName=getParamPost("fileName");
		
		$record=array();
		$record["name"]=$name;
		$record["url"]=$url;	
		//$record["url"]=correctUrl($url);	
		$record["des"]=$des;
		$record["no"]=$no;
		$record["lang"]=$lang;	
		$record["img"]=$fileName;
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/images/advertise/$fileName";
			moveFile($from,$to);
		}	
		
		if(!$id){			
			$sql = "SELECT * FROM sys_weblink WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_weblink WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);			
		}		
		if($return){			
			echo _UPDATE_SUCCESSFU;
		}else{			
			echo _ERRO;
		}
		listWeblink();		
	}
	//
	function getWeblinkList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_weblink";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockWeblink(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_weblink SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_weblink WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function correctUrl ($url)// dua url ve dang chuan http://www.namedomain.com
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
	function getWeblinkID($id){
		global $db;
		$sql="SELECT * FROM sys_weblink WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function deleteWeblink(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_weblink WHERE id=$id";
		$db->Execute($sql);
		listWeblink();
	}	
	
?>