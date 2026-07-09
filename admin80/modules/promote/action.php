<?php
	function updatePromote(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");
		$url=getParamPost("url");		
		$des=getParamPost("des");		
		$fileName=getParamPost("fileName");
		
		$record=array();
		$record["name"]=$name;
		$record["url"]=correct_url($url);		
		$record["des"]=$des;				
		$record["img"]=$fileName;
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/lib/$fileName";
			moveFile($from,$to);
		}
		
		if(!$id){
			$record["date_create"]=date("Y-m-d");
			$sql = "SELECT * FROM promote WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM promote WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=promote";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=promote&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getPromoteList(){
		global $db;		
		$sql="SELECT * FROM promote ORDER BY id DESC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockPromote(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE promote SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM promote WHERE  id=$id";
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
	function promoteDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM promote WHERE id=$id";		
		$db->Execute($sql);
		promoteList();
	}	
	//
	function getPromoteID($id){
		global $db;
		$sql="SELECT * FROM promote WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
?>