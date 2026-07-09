<?php
	function getPhotoGroup(){
		global $db;
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) ORDER BY `no` DESC";		
		$arr=$db->getAssoc($sql);
		return $arr;
	}
	//
	function getPhotoList($id){
		global $db;
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent='$id') ORDER BY `no` DESC";		
		$arr=$db->getAssoc($sql);
		return $arr;
	}
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;	
		return $arr;
	}
?>