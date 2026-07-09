<?php
	function inveslistListID($fid){
		global $db,$lang;		
		
		$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='inveslist') AND (parent='$fid') ORDER BY sort";	
		$rs=$db->Execute($sql);	

		if($rs->RecordCount()){
		
				$txtSearch=getParamPost("txtSearch");
				$sql="SELECT sys_inveslist.*, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create, sys_function.htaccess";
				$sql.=" FROM sys_inveslist_cat , sys_inveslist, sys_function";
				$sql.=" WHERE sys_inveslist_cat.artID =  sys_inveslist.id AND sys_inveslist_cat.catID =  sys_function.id AND sys_function.parent='$fid' AND sys_function.ctrl&1=1 AND sys_inveslist.lang='$lang' AND sys_inveslist.ctrl&1=1";
				$sql.=" GROUP BY sys_inveslist.id ORDER BY sys_inveslist.date_create DESC";	
				$arr=$db->GetAll($sql);
				return $arr;
				
		}else{
		
			$txtSearch=getParamPost("txtSearch");
			$sql="SELECT sys_inveslist.*, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create, sys_function.htaccess";
			$sql.=" FROM sys_inveslist_cat , sys_inveslist, sys_function";
			$sql.=" WHERE sys_inveslist_cat.artID =  sys_inveslist.id AND sys_inveslist_cat.catID =  sys_function.id AND sys_inveslist.lang='$lang' AND sys_inveslist.ctrl&1=1";
			$sql.=" AND sys_inveslist_cat.catID =  '$fid'";
			if($txtSearch){
				$sql.=" AND (match(name, summary) against('$txtSearch' in boolean mode))";
			}	
			$sql.=" ORDER BY sys_inveslist.date_create DESC";				
			$arr=$db->GetAll($sql);			
			return $arr;
	  }		
	  
	}	
	//
	function inveslistListRe($fid){
		global $db,$lang;		
		
		$txtSearch=getParamPost("txtSearch");
		
		$sql="SELECT sys_inveslist.*, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create, sys_function.htaccess";
		$sql.=" FROM sys_inveslist_cat , sys_inveslist, sys_function";
		$sql.=" WHERE sys_inveslist_cat.artID =  sys_inveslist.id AND sys_inveslist_cat.catID =  sys_function.id AND sys_inveslist.lang='$lang' AND sys_inveslist.ctrl&1=1";
		$sql.=" AND sys_inveslist_cat.catID =  '$fid'";
		
		if($txtSearch){
			$sql.=" AND (match(name, summary) against('$txtSearch' in boolean mode))";
		}	
				
		$sql.=" ORDER BY sys_inveslist.date_create DESC LIMIT 0,11";		
		$arr=$db->GetAll($sql);			
		return $arr;		
	}	
	//
	function inveslistID($alias){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_inveslist";		
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
	function getinveslistListFaq($proID){
		global $db;		
		$sql="SELECT * FROM sys_commentinveslist WHERE (ctrl&1=1) AND (proid=$proID)";		
		$arr=$db->GetAssoc($sql);			
		return $arr;
	}	
	//	
?>