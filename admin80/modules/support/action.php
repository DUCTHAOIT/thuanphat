<?php
	function updateSupport(){
		global $db;		
		
		$id=getParamPost("id");
		$yahoo=getParamPost("yahoo");
		$skype=getParamPost("skype");
		$tel=getParamPost("tel");
		$nick=getParamPost("nick");
		$summary=getParamPost("summary");
		$type=getParamPost("type");
		$lang=getParamPost("lang");
		$no=getParamPost("no");
				
		$record=array();
		$record["yahoo"]=$yahoo;
		$record["skype"]=$skype;
		$record["tel"]=$tel;
		$record["nick"]=$nick;
		$record["summary"]=$summary;
		$record["type"]=$type;
		$record["lang"]=$lang;
		$record["no"]=$no;
		
		if(!$id){			
			$sql = "SELECT * FROM support_online WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM support_online WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);			
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=support";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=support&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getSupportList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="support_online";	
		$obj->fieldsLang="support_online";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();				
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockSupport(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE support_online SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM support_online WHERE  id=$id";
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
	function supportDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM support_online WHERE id=$id";		
		$db->Execute($sql);
		supportList();
	}	
	//
	function getSupportID($id){
		global $db;
		$sql="SELECT * FROM support_online WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getSupportCat($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="support_online_cat";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
?>