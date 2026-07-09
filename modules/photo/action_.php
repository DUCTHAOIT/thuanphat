<?php
	function getPhotoGroup($idF){
		global $db,$lang;
		//$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) AND (catID=$idF) AND (lang='$lang') ORDER BY `focus` DESC";		
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) ORDER BY `no` ASC";		
		$arr=$db->getAssoc($sql);
		if(count($arr)==0){
//			$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) AND (lang='$lang') ORDER BY `focus` DESC";		
			$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) ORDER BY `no` ASC";		
			$arr=$db->getAssoc($sql);
		}		
		return $arr;
	}
	//
	function getPhotoList($id){
		global $db,$lang;
		//$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent='$id') AND (lang='$lang') ORDER BY `no` ASC";		
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent='$id') ORDER BY `no` ASC";		
		$arr=$db->getAssoc($sql);	
		return $arr;
	}
	//
	function getPhotoID($id){
		global $db,$lang;
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;	
		return $arr;
	}
?>