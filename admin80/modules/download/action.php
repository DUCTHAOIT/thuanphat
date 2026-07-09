<?php
	function getDownloadList($catID=""){
		global $db;
		$keyworld=getParamPost("keyword");
		
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_download.id, sys_download.ctrl, sys_function.name as topicName, sys_download.name, sys_download.file_name, sys_download.no, sys_download.catID";
		$obj->tableName="sys_function , sys_download";
		$obj->limit="all";
		$obj->orderBy="no";		
		if($catID) $sql="(sys_function.id =  sys_download.catID) AND (sys_function.id=$catID)";
		else $sql="(sys_function.id =  sys_download.catID)";
		if($keyworld) $sql.=" AND match(sys_download.name) against('$keyworld' in boolean mode)";
		$obj->where=$sql;
		$obj->fieldsLang="sys_function";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function updateDownload(){
		global $db;		
		
		$id=getParamPost("id");
		$catID=getParamPost("catID");
		$name=getParamPost("name");		
		$content=getParamPost("content");				
		$lang=getParamPost("lang");
		$no=getParamPost("no");		
		$file_name=getParamPost("file_name");		
		
		$record=array();
		$record["catID"]=$catID;
		$record["name"]=$name;		
		$record["des"]=$content;		
		$record["lang"]=$lang;
		$record["no"]=$no;		
		$record["file_name"]=$file_name;		
		
		if($file_name){
			$from=_DOMAIN_ROOT_PATH."/temp/$file_name";
			$to=_DOMAIN_ROOT_PATH."/modules/download/store/$file_name";
			moveFile($from,$to);
		}
		
		
		if(!$id){			
			$sql = "SELECT * FROM sys_download WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_download WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=download";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=download&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function lock(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_download SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_download WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function getDownloadID($id){
		global $db;
		$sql="SELECT * FROM sys_download WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function delete(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_download WHERE id=$id";
		$db->Execute($sql);
		downloadList();
	}
	//
	function getTopicDownload(){
		global $db,$lang;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='download')";
		$obj->limit="all";
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);		
		return $arr;		
	}
?>