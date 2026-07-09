<?php
	function updateHelp(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");		
		$des=getParamPost("des");
		$lang=getParamPost("lang");
		$no=getParamPost("no");
		$fileName=getParamPost("fileName");
		$flash_file=getParamPost("flash_file");
		
		$record=array();
		$record["name"]=$name;		
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["no"]=$no;
		$record["file_name"]=$fileName;
		$record["flash_file"]=$flash_file;
		//
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/images/help/$fileName";
			moveFile($from,$to);
		}
		//
		if($flash_file){
			$from=_DOMAIN_ROOT_PATH."/temp/$flash_file";
			$to=_DOMAIN_ROOT_PATH."/images/help/$flash_file";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM help WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM help WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=help";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=help&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getHelpList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="help";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockHelp(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE help SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM help WHERE  id=$id";
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
	function helpDelete(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM help WHERE id=$id";
		$db->Execute($sql);
		helpList();
	}	
	//
	function getHelpID($id){
		global $db;
		$sql="SELECT * FROM help WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
?>