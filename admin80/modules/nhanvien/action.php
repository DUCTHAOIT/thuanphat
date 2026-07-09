<?php
	function getnhanvienList(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date FROM user WHERE loai=2 ORDER BY id DESC";		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	
	 function nhanvienCreate(){
	 	
		global $db,$lable;
		
		$txtUsername=getParamPost("txtEmail");		
		
		$txtEmail=getParamPost("txtEmail");
		$txtPassword=getParamPost("txtPassword");
		
		$firstname=getParamPost("firstname");
		$lastname=getParamPost("lastname");
		$streetaddress=getParamPost("streetaddress");
		$companyname=getParamPost("companyname");
		$telephone=getParamPost("telephone");		
		$postcode=getParamPost("postcode");
				
		$record=array();
		$record["username"]=$txtUsername;
		$record["email"]=$txtEmail;
		if($txtPassword) $record["password"]= md5($txtPassword);
		
		$record["firstname"]=$firstname;
		$record["lastname"]=$lastname;
		$record["streetaddress"]=$streetaddress;
		$record["companyname"]=$companyname;
		$record["telephone"]=$telephone;		
		$record["postcode"]=$postcode;		
		$record["date_create"]=date("Y-m-d");
		
	 	
	 	
		$sql = "SELECT * FROM user WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);					
		$return=$db->Execute($sql);			

	 	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	 	if($return){			
	 		$ret_page="?m=user";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
	 	}else{
	 		$ret_page="?m=user&op=frmCreate";
	 		$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
	 	}
	 	$a->showMsg();
	 }
	 //	 
	function locknhanvien(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE user SET ctrl=IF(ctrl=1,2,1) WHERE  username='$id'";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM user WHERE  username='$id'";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function getnhanvienID($email){
		global $db;
		$sql="SELECT * FROM user WHERE  username='$email'";		
		$rs=$db->Execute($sql);			
		return $rs->fields;
	}
	//
	function userDelete(){
		global $db;
		$email=getParam("id");
		$sql="DELETE FROM user WHERE id='$email'";
		$db->Execute($sql);
		userList();
	}
	//
	//
	function getnhanvienHD($username){
		global $db;
		$month=getParam("month");
		$monthtoday=date("m");
		$year=getParam("year");
		$yeartoday=date("Y");	
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, user.name as nameuser, MONTH(sys_userorder.date_create) as month, YEAR(sys_userorder.date_create) as year";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.gioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1)";
		if($month){
			$sql.=" AND (MONTH(sys_userorder.date_create) = '$month')";	
		}else{
			$sql.=" AND (MONTH(sys_userorder.date_create) = '$monthtoday')";	
		}
		if($year){
			$sql.=" AND (YEAR(sys_userorder.date_create) = '$year')";	
		}else{
			$sql.=" AND (YEAR(sys_userorder.date_create) = '$yeartoday')";
		}
		$sql.=" ORDER BY sys_userorder.date_create DESC";
		$arr=$db->GetAssoc($sql);
		//echo $sql;
		return $arr;
	}
	//
	function getTSI(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
	
		return $rs->fields;
	}
	//
	function getTSITangGiam(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	//
	function getTSI2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date  FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 1";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function getTSITangGiam2(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date, '".format_date()."') as date FROM xuat_su WHERE type=1  ORDER BY id DESC LIMIT 1,2";
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//	
	function getnhanvienSohuu($username){
		global $db;
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.hdban>0) AND (sys_userorder.loai=2)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
?>