<?php
	function updateService(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");
		$address=getParamPost("address");
		$tel=getParamPost("tel");
		$website=getParamPost("website");
		$des=getParamPost("des");
		$lang=getParamPost("lang");
		$no=getParamPost("no");
		$fileName=getParamPost("fileName");
		
		$record=array();
		$record["name"]=$name;
		$record["address"]=$address;
		$record["tel"]=$tel;
		//$record["website"]=correct_url($website);
		$record["website"]=$website;
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["no"]=$no;
		$record["img"]=$fileName;
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/modules/service/images/$fileName";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_service WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_service WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=service";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=service&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getServiceList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_service";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockService(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_service SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_service WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function correct_url ($url)// dua url ve dang chuan http://www.namedomain.com
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
	function serviceDelete(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_service WHERE id=$id";
		$db->Execute($sql);
		serviceList();
	}	
	//
	function getServiceID($id){
		global $db;
		$sql="SELECT * FROM sys_service WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
?>