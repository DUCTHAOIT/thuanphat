<?php
	
	function getGroupPhotoParent(){
		global $db;
		$sql="SELECT sys_photo.*, sys_function.name as funname FROM sys_photo, sys_function WHERE (sys_photo.parent=0) AND (sys_function.id=sys_photo.catID) ORDER BY sys_photo.no DESC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getGroupPhoto(){
		global $db,$lang;
		$sql="SELECT * FROM sys_function WHERE (module='photo') AND (lang='$lang') ORDER BY sort DESC";
	//	echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function update(){
		global $db;
		
		$parent=getParam("parent");
		if(!$parent) $parent=0;
		$id=getParamPost("id");
		$name=getParamPost("name");
		$des=getParamPost("des");
		$groupID=getParamPost("groupID");	
		
		$focus=getParamPost("focus");
		if(!$focus) $focus=0;
		
		$lang=getParamPost("lang");		
		$img=getParamPost("fileName");
		$img1=getParamPost("fileName1");
		$no=getParamPost("no");
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img;
		$to=_DOMAIN_ROOT_PATH."/images/photo/".$img;
		moveFile($from,$to);
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img1;
		$to=_DOMAIN_ROOT_PATH."/images/photo/thumbs/".$img1;
		moveFile($from,$to);
		
		$record=array();
		$record["name"]=$name;
		$record["des"]=$des;
		$record["parent"]=$parent;		
		$record["focus"]=$focus;
		$record["img"]=$img;
		$record["img1"]=$img1;
		$record["lang"]=$lang;
		$record["no"]=$no;		
		//$record["date_create"]=date("Y-m-d");
		$record["date_create"]=time();
		$record["catID"]=$groupID;		
		if(!$id){
			$sql = "SELECT * FROM sys_photo WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);	
			$return=$db->Execute($sql);
			
			if($return){
				$idNew=$db->Insert_ID();				
				$sql="INSERT INTO sys_photo_cat(catID,artID) VALUES('$groupID','$idNew')";
				$return=$db->Execute($sql);				
			}
			
				
		}else{
			$sql = "SELECT * FROM sys_photo WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);
			
			if($return){
				$sql="DELETE FROM sys_photo_cat WHERE artID='$id'";
				$db->Execute($sql);				
				$sql="INSERT INTO sys_photo_cat(catID,artID) VALUES('$groupID','$id')";				
				$return=$db->Execute($sql);			
			}
			
		}
					
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=photo&op=frmcreate";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			if(getParamPost("parent")>0) $ret_page="?m=photo&op=mainlistofgroup&id=".getParamPost("parent");
			else $ret_page="?m=photo";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_photo WHERE (id='$id')";		
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;
	}
	//	
	function lock(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_photo SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_photo WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}	
	//
	function delete(){
		global $db;
		$id=getParamPost("id");
		$sql="DELETE FROM sys_photo WHERE id=$id";
		$db->Execute($sql);
		$sql="DELETE FROM sys_photo WHERE parent=$id";
		@$db->Execute($sql);
		photoListGroup();
	}
	//
	function getPhotoList($id){
		global $db;
		$sql="SELECT * FROM sys_photo WHERE (parent='$id') ORDER BY no DESC";		
		$arr=$db->getAssoc($sql);
		return $arr;
	}
?>