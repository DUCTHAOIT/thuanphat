<?php	
	function getTopichdmuachung($proID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="id";
		// list cac dau muc la userorder
		$obj->where="module='$moduleName' AND (ctrl&1=1)";
		//list het
		//$obj->where="(ctrl&1=1)";
		//
		$obj->limit="all";
		$sql=$obj->sqlSelect();
				
		$obj=new menuLevel();
		$obj->sql=$sql;		
		$arr=$obj->orderMenu();				
		return $arr;
	}
	//
	function addhdmuachung(){
		global $db, $lable,$lang;
		$admin=getSession("uid");

		$vowels = array(".",",");
		$id=getParamPost("id");	
		$userid=getParamPost("userid");
		$lop=getParamPost("lop");
		
		//$sotienmotxuat=str_replace($vowels, "", getParamPost("sotienmotxuat"));	
		//$chietkhau=str_replace($vowels, "", getParamPost("chietkhau"));	
		//$tongtien=str_replace($vowels, "", getParamPost("tongtien"));	
		
		$cklan1=str_replace($vowels, "", getParamPost("cklan1"));	
		$cklan2=str_replace($vowels, "", getParamPost("cklan2"));
		$ngaycklan1=getParamPost("ngaycklan1");	
		$ngaycklan2=getParamPost("ngaycklan2");	
		$hoahong=str_replace($vowels, "", getParamPost("hoahong"));
		
		//$ngayhoancoc=getParamPost("ngayhoancoc");	
		if(!$cklan2) $cklan2=0;
		$content=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		$langID=$lang;		
		
		
		$filePDF=getParamPost("filePDF");
	
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
			$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);			
			$sql = "INSERT INTO sys_userorder (hoahong, cklan1, cklan2, ngaycklan1, ngaycklan2, content, lop) VALUES ('$hoahong', '$cklan1', '$cklan2', '$ngaycklan1', '$ngaycklan2', '$content', '$lop')";	
					
			$return=$db->Execute($sql);
			/*
			Upload nhieu anh cho sp
			if($return){
				$idNew=$db->Insert_ID();
				foreach($_FILES['img_file']['name'] as $name => $value)
				{
					$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
					$source_img = $_FILES['img_file']['tmp_name'][$name];
					$path_img = _DOMAIN_ROOT_PATH."/images/userorder/".$name_img;	
					
					move_uploaded_file($source_img, $path_img);
					
					$sql="INSERT INTO sys_userorder_photo(proid, img, img1) VALUES('$idNew','$name_img',NOW())";
					$return=$db->Execute($sql); 
				}	
			}
			*/	
				
		}else{			
			$sql = "SELECT * FROM sys_userorder WHERE id=$id";
			$rs = $db->Execute($sql);
			
			$sql = "UPDATE sys_userorder SET hoahong='$hoahong', cklan1 = '$cklan1', cklan2 = '$cklan2', ngaycklan1 = '$ngaycklan1', content = '$content', lop = '$lop', admin = '$admin', ctrl='1'";
			if($ngaycklan2) $sql.=", ngaycklan2 = '$ngaycklan2'";
			$sql.=" WHERE id=$id";
			$return=$db->Execute($sql);
			if($return){
				$sql="SELECT * FROM user WHERE (id='$userid') AND (ctrl='0')";
				
				$rs = $db->Execute($sql);
				if($rs){
					$password=uniquenameadmin();
					
					$emailFrom		=getSession("email");
					$nameFrom		=getSession("site_name");			
					$emailTo      	= $rs->fields("email");
					$nameTo			= $rs->fields("name");
					$mobile			= $rs->fields("mobile");
					$txtEmail		= $rs->fields("email");	
			
					$subject = "Xác nhận tài khoản thành viên VIP trên "._DOMAIN_ROOT_URL."";
					$message= "Xin chào <b>".$nameTo."</b><br><br>";
					$message.= "Chúc mừng bạn đã được nâng cấp lên thành viên VIP trên hệ thống "._DOMAIN_ROOT_URL." <br><br>";
					$message.= "Bạn sẽ được hưởng hoa hồng theo chính sách của chúng tôi khi giới thiệu thành công các học viên mới tham gia khóa học của "._DOMAIN_ROOT_URL.". <br><br>";
					$message= "<b>Thông tin tài khoản:</b><br><br>";
					$message.= "Tên đăng nhập: ".$txtEmail." hoặc ".$mobile." <br><br>";
					$message.= "Mật khẩu: ". $password ."<br><br>";
					
					include('../phpmailer/class.smtp.php');
					include "../phpmailer/class.phpmailer.php"; 
					include_once("../phpmailer/config.php");
					$mail = sendMailer($subject, $message, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom); 
					if($mail==1){					
						$sql="UPDATE `user` SET `ctrl`='1',password='".md5($password)."' WHERE (`id`='$userid')";
						$db->Execute($sql);
					}
				}
				// gửi mail thông báo tạo tk cho user
			}
			//
			// upload file
							
		}
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=hdmuachung&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=hdmuachung";
			$a=new msgBox("Cập nhật thành công","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function gethdmuachungList_($all,$pageID,$limit=20){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, TO_DAYS(sys_userorder.date_create) as today FROM sys_userorder WHERE loai=0 AND hdban=0 ORDER BY today DESC";
		//echo $sql."<br>";
		//return;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;			
		return $arr;
	}
	//
	function gethdmuachungList($all,$pageID,$limit){
		global $db;
		$uid=getSession("uid");	
		//echo $uid;		
		if(!$uid) header("Location: login.php");
		
		loadClass("constructSql");		
		$obj=new constructSql();
		$userid=getParam("userid");
		$aff=getParam("aff");
		$proid=getParam("proid");
		//$sale=getParam("sale");
		$keyword=trim(getParamPost("keyword"));
		
		$loaihd=getParam("loaihd");
		
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2, user.name username, sys_product.name as nameproduct, sys_product.id as proid";
		$obj->tableName="sys_userorder ,user, sys_product";
		$obj->where="(user.id=sys_userorder.userid) AND (sys_product.id = sys_userorder.catID)";	
		if($userid) $obj->where.=" AND (sys_userorder.userid='".$userid."')";	
		if($aff) $obj->where.=" AND (sys_userorder.nguoigioithieu='".$aff."')";	
		if($proid) $obj->where.=" AND (sys_product.id='".$proid."')";
		if($uid<>15) $obj->where.=" AND (sys_userorder.sale='".$uid."')";
		//hd dat mua
		if($loaihd=='1') $obj->where.=" AND (sys_userorder.ctrl=0)";
		//hd chua tt het
		if($loaihd=='2') $obj->where.=" AND (sys_userorder.ctrl=1) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)>0)";
		//hd đã tt het
		if($loaihd=='3') $obj->where.=" AND (sys_userorder.ctrl=1) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)=0)";
		// dh hoan coc
		if($loaihd=='4') $obj->where.=" AND (sys_userorder.ctrl=0)";
		// dh chuyen nhuong
		if($loaihd=='5') $obj->where.=" AND (sys_userorder.ctrl=1) AND (sys_userorder.hdban>0)";
			
		if($keyword){
			$obj->where.=" AND ((sys_product.name LIKE '%".$keyword."%') OR (sys_userorder.name LIKE '%".$keyword."%') OR (sys_userorder.email LIKE '%".$keyword."%') OR (sys_userorder.mobile LIKE '%".$keyword."%'))";
		}
		
		//$obj->where.=" AND sys_product_admin_cat.catID=$uid AND sys_product.id =  sys_product_admin_cat.artID";
		
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
	//
	function gethdmuachungListBan($all,$pageID,$limit=20){
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$userid=getParam("userid");
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, user.name username";
		$obj->tableName="sys_userorder,user";
		$obj->where="sys_userorder.loai=0 AND sys_userorder.hdban>0 AND user.id=sys_userorder.userid";	
		if($userid) $obj->where.=" AND sys_userorder.userid='".$userid."'";	
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
	//
	function checkFuncName($arr,$k){
		foreach($arr as $key=>$value){
			if($value["proID"]==$k) $name .= $value["name"].",";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function gethdmuachungID($proID){
		global $db;
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, sys_product.name as nameproduct, sys_product.id as proid";
		$obj->tableName="sys_userorder, sys_product";		
		$obj->where="(sys_userorder.id=$proID) AND (sys_product.id = sys_userorder.catID)";
		$obj->fieldsLang="sys_userorder";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		//if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		//else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/hdmuachung/".$arr["img"];
		//if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		//else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/hdmuachung/".$arr["img1"];
		return $arr;
	}
	//
	//
	function deleteban(){
		global $db;
		
		$id=getParam("id");
		
		$sql="DELETE FROM  sys_userorder WHERE (id=$id)";
		$result=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=hdmuachung&f=hdban";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	
	//
	function deletehdmuachung(){
		global $db,$lable;
		$proID=getParamPost("id");
		loadClass("constructSql");		
		$obj=new constructSql();
		//Xoa file anh
		$obj->tableName="sys_userorder";
		$obj->where="id=$proID";
		$sql=$obj->sqlSelect();
		
		//xoa trong bang userorder
		$obj->tableName="sys_userorder";
		$obj->where="id=$proID";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);		
		
		if(!$return) echo _NO_DELETE_SUCCESSFU;
		hdmuachungList();
	}
	//
	function lockhdmuachung(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_userorder SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT * FROM sys_userorder WHERE id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
		/*
		if($rs->fields("ctrl")=='1' && $rs->fields("model")>0){
			include('../phpmailer/class.smtp.php');
			include "../phpmailer/class.phpmailer.php"; 
			include_once("../phpmailer/config.php");
			
			$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, user.email email, user.name username FROM sys_userorder,user WHERE sys_userorder.loai=0 AND sys_userorder.id=$id AND user.id=sys_userorder.userid";
			$rs=$db->Execute($sql);
			
			$username=$rs->fields("username");
			$date=$rs->fields("date_create");
			$namehd=$rs->fields("name");
			$giatri=$rs->fields("price_old");
			$giadvdt=$rs->fields("price");
			$soluong=$rs->fields("model");
			$email=$rs->fields("email");
			
			$contents='<p>Kính gửi Qúy khách hàng <b>'.$username.'</b><br>CTCP Đầu tư phát triển Thạch Sanh (TSI) trân trọng gửi tới Qúy khách hàng Thông tin kết quả đặt mua như sau: </p>';
			$contents.="<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" bordercolor=\"#f3f3f3\" style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">
				  
			  <tr>
				<td>Ngày giao dịch:</td>
				<td>".$date."</td>
			  </tr>
			  <tr>
				<td>Số Hợp đồng:</td>
				<td>".$namehd."</td>
			  </tr>
			  <tr>
				<td>Giá trị mua:</td>
				<td>".number_format($giatri, 0, '.', ',')." VNĐ</td>
			  </tr>
			   <tr>
				<td>Gía ĐVDT ngày giao dịch:</td>
				<td>".number_format($giadvdt, 0, '.', ',')." VNĐ</td>
			  </tr>
			   <tr>
				<td>Số lượng ĐVĐT đã mua:</td>
				<td>".number_format($soluong, 0, '.', ',')."</td>
			  </tr>
			</table>";
			$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
			$HTML.=$contents;
			$HTML.="</span>";			
			$emailFrom		="info@tsic.com.vn";
			//$emailFrom		="maingocduong.com@gmail.com";
			$nameFrom		="Thach Sanh Investment";
			$emailTo      	= $email;
			//$emailTo      	= "duongmn.ict@gmail.com";		
			$nameTo			= $username;		
			$subject 		= "Thông báo kết quả đặt mua";
			
			$send_mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
			if($send_mail==1){
				$send_mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			}else{
				echo "Có lỗi sảy ra, xin cấu hình lại mail trên sever";
			}	
		}
		*/
	}
	//	
	function daban(){
		global $db,$lang,$lable;		
		$id=getParam("id");	
		$hdban=getParam("hdban");	
		$soluongban=getParam("soluongban");	
		$sql="UPDATE sys_userorder SET trangthai=IF(trangthai=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		
		$sqlconlai="SELECT * FROM sys_userorder WHERE  id=$hdban";
		$rs=$db->Execute($sqlconlai);
		$conlai=$rs->fields("model");
		$price_old=$conlai*$rs->fields("price");
		if($conlai>0){
			$sqlhdban="UPDATE sys_userorder SET product_in='0', price_old='$price_old' WHERE id=$hdban";		
			$db->Execute($sqlhdban);
		}else{
			$sqlhdban="UPDATE sys_userorder SET trangthai=IF(trangthai=0,1,0), `product_in`=`product_in`-$soluongban WHERE id=$hdban";		
			$db->Execute($sqlhdban);
		}
	
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=hdmuachung&f=hdban";
	
		$a=new msgBox("Xac thuc thanh cong","OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();	
	}
	//
	function huy(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_userorder SET trangthai=2 WHERE id=$id";		
		$db->Execute($sql);
		
		$sqlhuy="SELECT * FROM sys_userorder WHERE id=$id";
		$rs=$db->Execute($sqlhuy);
		$luonghuy=$rs->fields("model");
		$hdban=$rs->fields("hdban");
		
		$sql="UPDATE sys_userorder SET model=model+'".$luonghuy."', product_in=product_in-'".$luonghuy."' WHERE id=$hdban";	
			
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="/admin80/?m=hdmuachung&f=hdban";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function addPhoto(){
		global $db;
		$id=getParamPost("id");
		foreach($_FILES['img_file']['name'] as $name => $value)
		{
			$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
			$source_img = $_FILES['img_file']['tmp_name'][$name];
			$path_img = _DOMAIN_ROOT_PATH."/images/hdmuachung/".$name_img;	
			
			move_uploaded_file($source_img, $path_img);
			
			$sql="INSERT INTO sys_userorder_photo(proid, img, img1) VALUES('$id','$name_img',NOW())";
			$return=$db->Execute($sql); 
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=hdmuachung&op=photo&id=$id";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=hdmuachung&op=photo&id=$id";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		
	}
	//
	function gethdmuachungListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_userorder_photo WHERE proid=$proID";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function getLop(){
		global $db;		
		$sql="SELECT * FROM sys_inveslist WHERE (ctrl&1=1) ORDER BY id DESC";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	//
	function getSale(){
		global $db;		
		$sql="SELECT * FROM sys_member WHERE (ctrl&1=1) ORDER BY id DESC";		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function deletePhoto(){
		global $db;
		$id=getParamPost("photoID");
		$sql="DELETE FROM sys_userorder_photo WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		hdmuachungListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_userorder_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/hdmuachung/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/hdmuachung/".$arr["img1"];
		return $arr;
	}
	//
	/**
	 * Hang san xuat
	 *
	 */	
	function manufacturers(){
		global $db;
		$sql="SELECT * FROM hang_san_xuat ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	function getarruser(){
		global $db;
		$sql="SELECT * FROM user WHERE (ctrl&1=1) ORDER BY id DESC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getarrproduct(){
		global $db;
		$sql="SELECT * FROM sys_product WHERE (ctrl&1=1) ORDER BY id DESC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function linhvuc(){
		global $db;
		$sql="SELECT * FROM linhvuc ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function loai(){
		global $db;
		$sql="SELECT * FROM loai ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function dongsp(){
		global $db;
		$sql="SELECT * FROM dongsp ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	/**
	 * Tinh trang hang
	 *
	 */	
	function tinh_trang(){
		global $db;
		$sql="SELECT * FROM tinh_trang ORDER BY sort ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function addFile(){
		global $db;
		$uploaddir = _DOMAIN_ROOT_PATH."/temp/";
		
		$id=getParamPost("id");
		$file=getParamPost("file");		
		$idFile=getParamPost("idFile");
		$name=getParamPost("name");
		$content=getParamPost("content");
		$date_create=date("Y-m-d");
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$file;		
		if(file_exists($sourcefile)){			
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/lib/".$file;
			moveFile($from,$to);	
		    $size=file_size($to);
		    if(!$size) $size="";		
		}	
		@unlink($sourcefile);		
	
		if(!$idFile) $sql="INSERT INTO sys_userorder_file(proid,file,content,name,date_create,size) VALUES ($id,'$file','$content','$name','$date_create','$size')";		
		else $sql="UPDATE sys_userorder_file SET file='$file',content='$content',name='$name',date_create='$date_create',size='$size' WHERE id=$idFile";		
		$db->Execute($sql);		

		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=hdmuachung&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function gethdmuachungListFile($proID){
		global $db;		
		$sql="SELECT * FROM sys_userorder_file WHERE proid=$proID";				
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	//
	function deleteFile(){
		global $db;
		$id=getParamPost("fileID");
		$sql="DELETE FROM sys_userorder_file WHERE id=$id";		
		$result=$db->Execute($sql);
		if($result){
			$message=_DELETE_SUCCESSFU;
		}else{
			$message=_NO_DELETE_SUCCESSFU;
		}
		echo "<lable class=messange>$message</lable>";
		hdmuachungListFile();
	}	
	//
	function getFileID($id){
		global $db;
		$sql="SELECT * FROM sys_userorder_file WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["file"]) $arr["file_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["file_view"]=_DOMAIN_ROOT_URL."/lib/".$arr["file"];	
		return $arr;
	}
	//
	//
	function lockFile(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_userorder_file SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_userorder_file WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function uniquenameadmin(){
		$d=getdate();
		$tem = ((int)$d["year"]-1900)*12*30*24*60*60;
		$tem += (int)$d["mon"]*30*24*60*60;
		$tem += ((int)$d["mday"])*24*60*60;
		$tem += ((int)$d["hours"])*60*60;
		$tem += ((int)$d["minutes"])*60;
		$tem += ((int)$d["seconds"]);
		$tem .= rand(1,100);
		$tem = base_convert($tem,10,32);
		$tem = strtoupper((string)$tem);
		return trim($tem);
	}
	//	
?>