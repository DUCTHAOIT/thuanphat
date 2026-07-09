<?php
	function getUserList($all,$pageID,$limit=20){
		global $db;
        loadClass("constructSql");
        $obj=new constructSql();
		$keyword=trim(getParamPost("keyword"));
		/*if($keyword){
		$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date FROM user WHERE ((name LIKE '%".$keyword."%') OR (email LIKE '%".$keyword."%') OR (mobile LIKE '%".$keyword."%')) ORDER BY id DESC";
		}else{
		$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date FROM user ORDER BY id DESC";
		}*/

        if(!$keyword){
            $obj->fieldsName="user.*";
            $obj->tableName="user";
            $obj->orderBy="user.id DESC";
        }else{
            $obj->fieldsName="user.*";
            $obj->tableName="user";
            $obj->where="((name LIKE '%".$keyword."%') OR (email LIKE '%".$keyword."%') OR (mobile LIKE '%".$keyword."%'))";
            $obj->orderBy="user.id DESC";
        }

        if($all==false){
            $obj->limit_start = $pageID;
            $obj->limit=$limit;
        }else $obj->limit="All";
        $sql=$obj->sqlSelect();
        $arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	
	 function userCreate(){
	 	
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
function changepass(){

    global $db,$lable;

    $id=getParamPost("id");
    $txtPassword=getParamPost("txtPassword");

    if($txtPassword){
        $sql="UPDATE user SET password='".md5($txtPassword)."' WHERE (id='$id')";

        $return=$db->Execute($sql);
    }
    include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
    if($return){
        $ret_page="?m=user";
        $a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
    }else{
        $ret_page="?m=user&op=frmCreate&id='$id'";
        $a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
    }
    $a->showMsg();
}
	 //	 
	function lockUser(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE user SET ctrl=IF(ctrl=0,1,0) WHERE  username='$id'";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM user WHERE  username='$id'";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function lockHLV(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE user SET permit=IF(permit=0,1,0) WHERE username='$id'";
		$db->Execute($sql);
		//$sql="SELECT * FROM sys_userorder WHERE id=$id";
		//$rs=$db->Execute($sql);
		//echo "<img src=\"images/daban".$rs->fields("hoancoc").".gif\" style=\"cursor:pointer\" />";
	}
	//
	//
	function loaiUser(){
		global $db,$lang,$lable;		
		$id=getParam("id");	
		$loai=getParam("loai");
		$sql="UPDATE user SET loai=$loai WHERE  username='$id'";		
		$db->Execute($sql);
		
	}
	//
	function nhanvienUser(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE user SET loai=IF(loai=0,2,0) OR loai=IF(loai=1,2,1) WHERE  username='$id'";		
		$db->Execute($sql);
		$sql="SELECT loai FROM user WHERE  username='$id'";
		$rs=$db->Execute($sql);
		if($rs->fields("loai")=='2'){
			echo '<label class="switch" >
      <input type="checkbox" checked onclick="callLoai("'.$rs->fields("username").'")" >
      <span class="slider round" ></span>
    </label>';
		}else{
			echo '<label class="switch" >
      <input type="checkbox" onclick="callLoai("'.$rs->fields("username").'")" >
      <span class="slider round" ></span>
    </label>';
		}
		echo $rs->fields("loai");
	}
	//
	function getUserID($id){
		global $db;
		$sql="SELECT * FROM user WHERE  id='$id'";
		$rs=$db->Execute($sql);		
		return $rs->fields;
	}
	//
	function userDelete(){
		global $db;
		$email=getParam("id");
		$sql="DELETE FROM user WHERE username='$email'";
		$db->Execute($sql);
		userList();
	}
	//
	//
	function getUserHDmuachung($username){
		global $db;
		$username=$username["username"];
		$sql="SELECT COUNT(sys_userorder.id) as sohd";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.email = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loaidt=0)";
		$rs=$db->Execute($sql);
		$sohd=$rs->fields("sohd");
		if($sohd>1){$soluonghd='<span style="color:#FF0000">'.$sohd.'</span>';}else{$soluonghd=$sohd;} 
		return $soluonghd;
	}
	//
	//
	function getUserHDgopvon($username){
		global $db;
		$username=$username["username"];
		$sql="SELECT COUNT(sys_userorder.id) as sohd";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.email = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loaidt=1)";
		$rs=$db->Execute($sql);
		$sohd=$rs->fields("sohd");
		if($sohd>1){$soluonghd='<span style="color:#FF0000">'.$sohd.'</span>';}else{$soluonghd=$sohd;} 
		return $soluonghd;
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
	function getUserSohuu($username){
		global $db;
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		//$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.hdban>0) AND (sys_userorder.loai=0)";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.hdban>0)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function gethdmuachungList($id){
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$id=getParam("id");
		$proid=getParam("proid");
		$keyword=getParamPost("keyword");
		
		$loaihd=getParam("loaihd");
		
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2, user.name username, sys_product.name as nameproduct, sys_product.id as proid";
		$obj->tableName="sys_userorder ,user, sys_product";
		$obj->where="(user.id=sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_userorder.loaidt=0)";	
		$obj->where.=" AND (sys_userorder.email='".$id."')";	
		if($proid) $obj->where.=" AND (sys_product.id='".$proid."')";
		//hd dat mua
		if($loaihd=='1') $obj->where.=" AND (sys_userorder.ctrl=0) AND (sys_userorder.hoancoc=0)";
		//hd chua tt het
		if($loaihd=='2') $obj->where.=" AND (sys_userorder.ctrl=1) AND (sys_userorder.hoancoc=0) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)>0)";
		//hd dã tt het
		if($loaihd=='3') $obj->where.=" AND (sys_userorder.ctrl=1) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)=0)";
		// dh hoan coc
		if($loaihd=='4') $obj->where.=" AND (sys_userorder.ctrl=0) AND (sys_userorder.hoancoc=1)";
		// dh chuyen nhuong
		if($loaihd=='5') $obj->where.=" AND (sys_userorder.ctrl=1) AND (sys_userorder.hdban>0)";
			
		if($keyword){
			$obj->where.=" AND ((sys_product.name LIKE '%".$keyword."%') OR (sys_userorder.name LIKE '%".$keyword."%'))";
		}
		
		$obj->groupBy="sys_userorder.id";
		$obj->orderBy="sys_userorder.id DESC";	
		$obj->fieldsLang="sys_userorder";
		
		if($all==false){
			$obj->limit_start = $pageID;
			$obj->limit=$limit;
		}else $obj->limit="All";
		
		$sql=$obj->sqlSelect();
		//echo $sql."<br>";
		//return;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;			
		return $arr;
		
	}
	//
	function getUserorder($username){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, sys_product.name as nameproduct, sys_product.alias, sys_product.promotion, sys_function.htaccess as url";
		$sql.=" FROM user, sys_userorder, sys_product, sys_function";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_product.catID=sys_function.id)";
		$sql.=" ORDER BY sys_userorder.date_create DESC";
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function getUserHocvien($username){
		global $db;
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, user.email as emailhlv";
		$sql.=" FROM sys_inveslist_cat , sys_userorder, user";
		$sql.=" WHERE sys_inveslist_cat.artID =  sys_userorder.lop AND sys_inveslist_cat.catID =  user.id AND sys_userorder.ctrl&1=1";
		$sql.=" AND user.username =  '$username'";
		$sql.=" ORDER BY sys_userorder.id DESC";	
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getUserGioithieu($username){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, sys_product.name as nameproduct, sys_product.alias, sys_function.htaccess as url";
		$sql.=" FROM user, sys_userorder, sys_product, sys_function";
		$sql.=" WHERE (sys_userorder.nguoigioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_product.catID=sys_function.id)";
		$sql.=" ORDER BY sys_userorder.date_create DESC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	
	//
	function diemdanh($id){
		global $themeName, $smarty, $lable, $db;
		$id=$id["id"];
		$sql="SELECT sys_nhanxet.*, DATE_FORMAT(sys_nhanxet.date_create, '".format_date()."') as date_create FROM sys_nhanxet WHERE sys_nhanxet.iduserorder=$id ORDER BY date_create ASC";
		$arr=$db->GetAssoc($sql);
		$smarty->assign('arr',$arr);	
		$smarty->assign('name',$name);	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_diemdanh.tpl','user_diemdanh_'.$themeName);
		return;	
	}
	//
	
	//
	function nameHlv($id){
		global $themeName, $smarty, $lable, $db;
		$id=$id["id"];
	
		$sql="SELECT * FROM sys_inveslist WHERE id=$id";	
		$rs=$db->Execute($sql);
		$name=$rs->fields("name");
		
		$sqluser="SELECT user.* FROM user,sys_inveslist_cat,sys_inveslist WHERE user.id = sys_inveslist_cat.catID AND sys_inveslist.id=sys_inveslist_cat.artID AND sys_inveslist.id=$id";
		$arruser=$db->GetAssoc($sqluser);
		$smarty->assign('arruser',$arruser);	
		$smarty->assign('name',$name);	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/user_danhsach_file.tpl','user_danhsach_file_'.$themeName);
		
		return;	
	}
	//
?>