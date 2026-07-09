<?php
	function partnerListID($fid){
		global $db,$lang;		
		
		$txtSearch=getParamPost("txtSearch");
		
		$sql="SELECT sys_partner.*, sys_function.htaccess";
		$sql.=" FROM sys_partner_cat , sys_partner, sys_function";
		$sql.=" WHERE sys_partner_cat.artID =  sys_partner.id AND sys_partner_cat.catID =  sys_function.id AND sys_partner.lang='$lang' AND sys_partner.ctrl&1=1";
		$sql.=" AND sys_partner_cat.catID =  '$fid'";
		
		if($txtSearch){
			$sql.=" AND (match(name, summary) against('$txtSearch' in boolean mode))";
		}	
				
		$sql.=" ORDER BY sys_partner.date_create DESC";			
		$arr=$db->GetAll($sql);			
		return $arr;		
	}	
	//
	function partnerID($alias){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_partner";		
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
	function getpartnerListFaq($proID){
		global $db;		
		$sql="SELECT * FROM sys_faq WHERE (ctrl&1=1) AND (proid=$proID)";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//	
?>