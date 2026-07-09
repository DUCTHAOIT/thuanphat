<?php
	function getMemberList(){
		global $db;
		$sql="SELECT *, concat(fistname,' ',lastname) as fullname FROM sys_member WHERE ctrl <>  '2'";		
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	
	 function memberCreate(){
	 	global $db,$lable;
	 	$memberID=getParamPost("id");	 	
	 	$email=getParamPost("txt_email");
	 	$password=getParamPost("txt_password");
	 	$fistname=getParamPost("txt_fistname");
	 	$lastname=getParamPost("txt_lastname");
	 	$address=getParamPost("txt_address");
	 	$mobile=getParamPost("txt_mobile");
	 	
	 	$arr=getParamPost("cPermit");
		
	 	if(!$arr){
			die($lable->_("Can not update data because you have not chosen the right for members"));
		}
		foreach($arr as $item=>$value){
			$sPermit.="'".$value."',";
		}
		$sPermit=substr($sPermit, 0, strlen($sPermit)-1);		
	 	
	 	$record=array();
	 	$record["email"]=$email;
	 	if($password) $record["password"]=md5($password);
	 	$record["fistname"]=$fistname;
	 	$record["lastname"]=$lastname;
	 	$record["address"]=$address;
	 	$record["mobile"]=$mobile;
	 	$record["permit"]=$sPermit;	 	
	 	if(!$memberID){
	 		$record["date_create"]=date("Y-d-m");
		 	$sql = "SELECT * FROM sys_member WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);					
			$return=$db->Execute($sql);			
	 	}else{	 		
	 		$sql = "SELECT * FROM sys_member WHERE id=$memberID";	 		
			$rs = $db->Execute($sql);						
			$sql = $db->GetUpdateSQL($rs, $record);			
			$return=$db->Execute($sql);	
	 	}	 	
	 	
	 	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	 	if($return){			
	 		$ret_page="?m=member";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
	 	}else{
	 		$ret_page="?m=member&op=frmCreate";
	 		$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
	 	}
	 	$a->showMsg();
	 }
	 //	 
	function lockMember(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_member SET ctrl=IF(ctrl=0,1,0) WHERE  id='$id'";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_member WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function getMemberID($id){
		global $db;
		$sql="SELECT * FROM sys_member WHERE  id='$id'";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function memberDelete(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_member WHERE id=$id";
		$db->Execute($sql);
		memberList();
	}
	//
	function getPermit($sPermit){
		global $db,$lang;
		$sPermit=$sPermit["sPermit"];
		
		$sPermit=str_replace("'", "", $sPermit);
		$permitID=explode(",", $sPermit);
		if(!$permitID) return;
		foreach($permitID as $key => $value){			
			$permit[$value]=true;
		}
		
		loadClass("menuLevel");		
		$obj=new menuLevel();
		$obj->sql="SELECt * FROM sys_menu_admin WHERE ctrl&1=1";
		
		$arr=$obj->orderMenu();
		//print_r($arr);
		foreach($arr as $key => $value){			
			if($permit[$value["id"]]) $checked = "checked";			
			echo '<div style="padding-left:'.$value["level"]*20 .'">';
			if($value["root"]) echo '<input type="checkbox" name="cPermit[]" value="'.$value["id"] .'" '. $checked.' /><b>'.$value["name".$lang].'</b>';
			else echo '<input type="checkbox" name="cPermit[]" value="'.$value["id"] .'" '. $checked.' />'. $value["name".$lang];
			echo '</div>';
			$checked="";
		}		
	}	
?>