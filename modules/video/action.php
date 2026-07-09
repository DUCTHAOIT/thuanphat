<?php
	function getPhotoGroup(){
		global $db;
		$sql="SELECT * FROM sys_video WHERE (ctrl&1=1) ORDER BY `no` ASC";	
				
		$arr=$db->getAssoc($sql);
		return $arr;
	}
	//
	function getPhotoList($id){
		global $db;
		$sql="SELECT * FROM sys_video WHERE (ctrl&1=1) ORDER BY `no` ASC";		
		$arr=$db->getAssoc($sql);
		return $arr;
	}
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_video WHERE (ctrl&1=1) AND (id='$id')";		
	
		$rs=$db->Execute($sql);
		$arr=$rs->fields;	
		return $arr;
	}
?>