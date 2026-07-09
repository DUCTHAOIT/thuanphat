<?php
	function worldwideListID($fid){
		global $db,$lang;
		
		$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='worldwide') AND (parent='$fid') ORDER BY sort";
		$rs=$db->Execute($sql);	
		if($rs->RecordCount()){		
			$sql="SELECT sys_worldwide.*,  sys_function.htaccess as url";
			$sql.=" FROM sys_worldwide , sys_function";
			$sql.=" WHERE (sys_worldwide.catID =  sys_function.id) AND (sys_worldwide.ctrl&1=1) AND (sys_worldwide.lang='$lang')";
			$sql.=" ORDER BY no ASC";
		}else{
			$sql="SELECT sys_worldwide.*,  sys_function.htaccess as url";
			$sql.=" FROM sys_worldwide , sys_function";
			$sql.=" WHERE (sys_worldwide.catID =  sys_function.id) AND (sys_worldwide.ctrl&1=1) AND (sys_worldwide.lang='$lang') AND (sys_worldwide.catID = '$fid')";
			$sql.=" ORDER BY no ASC";
		}
		$arr=$db->GetAll($sql);
		
		return $arr;		
	}	
	//
	function worldwideID($alias){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_worldwide";		
		$obj->where="alias='$alias'";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$rs=$db->Execute($sql);		
		$arr=$rs->fields;		
		return $arr;
	}
	//	
	//	
	function functionList($fid){
		global $db;
		$sql="SELECT id,name,parent,url FROM sys_function";
		$sql.=" WHERE (ctrl&1=1)  AND (parent=$fid)";
		$sql.=" ORDER BY sort";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getworldwideListFaq($proID){
		global $db;		
		$sql="SELECT * FROM sys_faq WHERE (ctrl&1=1) AND (proid=$proID)";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//	
	function getTopicWorldwide(){
		global $db,$moduleName;
		$sql="SELECT * FROM sys_function WHERE module='worldwide' AND (ctrl&1=1) AND (parent<>0) ORDER BY sort ASC";	
		$arr=$db->GetAssoc($sql);				
		return $arr;
	}
?>