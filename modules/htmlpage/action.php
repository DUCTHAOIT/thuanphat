<?php
	function getHtmlpageID($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_htmlpage";		
		$obj->where="id=$id";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$rs=$db->Execute($sql);		
		$arr=$rs->fields;		
		return $arr;
	}	
	//
?>