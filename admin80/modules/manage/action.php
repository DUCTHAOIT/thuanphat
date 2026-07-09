<?php
	function updateManage(){
		global $db;		
		
		$id=getParamPost("id");
		$name=getParamPost("name");
		$position=getParamPost("position");
		$des=getParamPost("des");
		$lang=getParamPost("lang");
		$fileName=getParamPost("fileName");
		
		$record=array();
		$record["name"]=$name;
		$record["position"]=$position;
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["img"]=$fileName;
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/modules/manage/images/$fileName";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_manage WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_manage WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		if($return){
			$ret_page="?m=manage";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=manage&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}	
	//
	function getManageList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_manage";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();
		$arr=$db->GetAssoc($sql);
		return $arr;
	}	
	//
	function getManageID($id){
		global $db;
		$sql="SELECT * FROM sys_manage WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//	 
	function lockManage(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_manage SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_manage WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}	
	//
	function deleteManage(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_manage WHERE id=$id";
		$db->Execute($sql);
		manageList();
	}
?>