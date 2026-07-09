<?php
	function getPhotoGroup($idF){
		global $db,$lang;
		$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='photo') AND (parent='$idF') ORDER BY sort";	
		$rs=$db->Execute($sql);	

		if($rs->RecordCount()){
			
			//$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) AND (catID=$idF) AND (lang='$lang') ORDER BY `focus` DESC";		
			$sql="SELECT sys_photo.*, sys_function.htaccess FROM sys_photo,sys_function WHERE (sys_function.parent =  '$idF') AND (sys_photo.catID=sys_function.id) AND (sys_photo.ctrl&1=1) AND (sys_photo.parent=0) ORDER BY sys_photo.no DESC";	
			//echo $sql;	
			//$arr=$db->getAssoc($sql);
			$arr=$db->GetAll($sql);	
		}else{
			$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent=0) AND (catID=$idF) ORDER BY `no` DESC";		
			$arr=$db->GetAll($sql);	
		}			
		return $arr;
	}
	//
	function getPhotoList($id){
		global $db,$lang;
		//$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent='$id') AND (lang='$lang') ORDER BY `no` ASC";		
		$sql="SELECT * FROM sys_photo WHERE (ctrl&1=1)  AND (parent='$id') ORDER BY `no` DESC";		
		//$arr=$db->getAssoc($sql);	
		$arr=$db->GetAll($sql);
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