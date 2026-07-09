<?php	
	function getTopichdgopvon($proID=""){
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
	function addhdgopvon(){
		global $db, $lable,$lang;
		

		$vowels = array(".",",");
				
		loadClass("convertString");
		$converString=new convertString();
		$id=getParamPost("id");	
		$giaidoan=getParamPost("giaidoan");
		$proid=getParamPost("proid");
		$soxuatdautu=getParamPost("soxuatdautu");
		$cklan1=str_replace($vowels, "", getParamPost("cklan1"));	
		$cklan2=str_replace($vowels, "", getParamPost("cklan2"));
		$ngaycklan1=getParamPost("ngaycklan1");	
		$ngaycklan2=getParamPost("ngaycklan2");	
		
		$phihoancoc=str_replace($vowels, "", getParamPost("phihoancoc"));
		$ngayhoancoc=getParamPost("ngayhoancoc");	
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
			$sql = "INSERT INTO sys_userorder (cklan1, cklan2, ngaycklan1, ngaycklan2, content, pdf) VALUES ( '$cklan1', '$cklan2', '$ngaycklan1', '$ngaycklan2', '$content', '$filePDF')";	
					
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
			
			$sql = "UPDATE sys_userorder SET cklan1 = '$cklan1', cklan2 = '$cklan2', ngaycklan1 = '$ngaycklan1', phihoancoc = '$phihoancoc', content = '$content', pdf = '$filePDF', ctrl='1'";
			if($ngaycklan2) $sql.=", ngaycklan2 = '$ngaycklan2'";
			if($ngayhoancoc) $sql.=", ngayhoancoc = '$ngayhoancoc'";
			$sql.=" WHERE id=$id";
			$return=$db->Execute($sql);
			// upload file
			if($return){
				$id_function=trim(getParamPost("id"));
				$technical=getParamPost("technical");				
				$order_number=getParamPost("order_number");
				if($technical)
				{
					foreach($technical as $key=>$value)
					{
						 if ($value) {
						 	$name_img = date('YmdHis')."_".$_FILES['img_file']['name'][$key];
							$name_img = convert_vi_to_en($name_img);
							$source_img = $_FILES['img_file']['tmp_name'][$key];
							
							$path_img = _DOMAIN_ROOT_PATH."/lib/".$name_img;	
							move_uploaded_file($source_img, $path_img);
							
							//nghi du lieu con
							$sqlfile="INSERT INTO sys_product_search (catID,name,order_number,logo) VALUES ('$id_function','$value','".$order_number[$key]."','".$name_img."')";		
						
							$returnfile=$db->Execute($sqlfile);
						
						}

							
						
					}
				
				}
			}	
			//end upload file	
							
		}		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=hdgopvon&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			if($rs->fields("cklan1")=='0'){
				$sql="UPDATE `sys_gopvon` SET `soxuatdakeugoi".$giaidoan."`=`soxuatdakeugoi".$giaidoan."`+".$soxuatdautu." WHERE (`id`='$proid')";	
			}
			$db->Execute($sql);
		
			$ret_page="?m=hdgopvon";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}		
	}
	//
	function gethdgopvonList_($all,$pageID,$limit=20){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, TO_DAYS(sys_userorder.date_create) as today FROM sys_userorder WHERE loai=0 AND hdban=0 ORDER BY today DESC";
		//echo $sql."<br>";
		//return;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;			
		return $arr;
	}
	//
	function gethdgopvonList($all,$pageID,$limit=20){
		global $db;
		$uid=getSession("uid");			
		if(!$uid) header("Location: login.php");
		
		loadClass("constructSql");		
		$obj=new constructSql();
		$userid=getParam("userid");
		$proid=getParam("proid");
		$keyword=getParamPost("keyword");
		
		$loaihd=getParam("loaihd");
		
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2, user.name username, sys_gopvon.name as nameproduct, sys_gopvon.id as proid";
		$obj->tableName="sys_userorder ,user, sys_gopvon, sys_gopvon_admin_cat";
		$obj->where="(user.id=sys_userorder.userid) AND (sys_gopvon.id = sys_userorder.catID) AND (sys_userorder.loaidt=1)";	
		if($userid) $obj->where.=" AND (sys_userorder.userid='".$userid."')";	
		if($proid) $obj->where.=" AND (sys_gopvon.id='".$proid."')";
		//hd dat mua
		if($loaihd=='1') $obj->where.=" AND (sys_userorder.ctrl=0) AND (sys_userorder.hoancoc=0)";
		//hd chua tt het
		if($loaihd=='2') $obj->where.=" AND (sys_userorder.ctrl=1) AND (sys_userorder.hoancoc=0) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)>0)";
		//hd đã tt het
		if($loaihd=='3') $obj->where.=" AND (sys_userorder.ctrl=1) AND ((sys_userorder.tongtien-sys_userorder.cklan1-sys_userorder.cklan2)=0)";
		// dh hoan coc
		if($loaihd=='4') $obj->where.=" AND (sys_userorder.ctrl=0) AND (sys_userorder.hoancoc=1)";
		// dh chuyen nhuong
		if($loaihd=='5') $obj->where.=" AND (sys_userorder.ctrl=1) AND (sys_userorder.hdban>0)";
			
		if($keyword){
			$obj->where.=" AND ((sys_gopvon.name LIKE '%".$keyword."%') OR (sys_userorder.name LIKE '%".$keyword."%'))";
		}
		
		$obj->where.=" AND sys_gopvon_admin_cat.catID=$uid AND sys_gopvon.id =  sys_gopvon_admin_cat.artID";
		
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
	function gethdgopvonListBan($all,$pageID,$limit=20){
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
	function gethdgopvonID($proID){
		global $db;
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, sys_gopvon.name as nameproduct, sys_gopvon.id as proid";
		$obj->tableName="sys_userorder, sys_gopvon";		
		$obj->where="(sys_userorder.id=$proID) AND (sys_gopvon.id = sys_userorder.catID)";
		$obj->fieldsLang="sys_userorder";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		//if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		//else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/hdgopvon/".$arr["img"];
		//if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		//else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/hdgopvon/".$arr["img1"];
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
		$ret_page="/admin80/?m=hdgopvon&f=hdban";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	
	//
	function deletehdgopvon(){
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
		hdgopvonList();
	}
	//
	function lockhdgopvon(){
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
	function hoancochdgopvon(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_userorder SET hoancoc=IF(hoancoc=0,1,0), ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT * FROM sys_userorder WHERE id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/daban".$rs->fields("hoancoc").".gif\" style=\"cursor:pointer\" />";
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
		$ret_page="/admin80/?m=hdgopvon&f=hdban";
	
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
		$ret_page="/admin80/?m=hdgopvon&f=hdban";
	
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
			$path_img = _DOMAIN_ROOT_PATH."/images/hdgopvon/".$name_img;	
			
			move_uploaded_file($source_img, $path_img);
			
			$sql="INSERT INTO sys_userorder_photo(proid, img, img1) VALUES('$id','$name_img',NOW())";
			$return=$db->Execute($sql); 
		}
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=hdgopvon&op=photo&id=$id";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=hdgopvon&op=photo&id=$id";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		
	}
	//
	function gethdgopvonListPhoto($proID){
		global $db;		
		$sql="SELECT * FROM sys_userorder_photo WHERE proid=$proID";		
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
		hdgopvonListPhoto();
	}	
	//
	function getPhotoID($id){
		global $db;
		$sql="SELECT * FROM sys_userorder_photo WHERE id=$id";		
		$rs=$db->Execute($sql);
		
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/hdgopvon/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/hdgopvon/".$arr["img1"];
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
	function getarrgopvon(){
		global $db;
		$sql="SELECT * FROM sys_gopvon WHERE (ctrl&1=1) ORDER BY id DESC";
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
		$ret_page="?m=hdgopvon&op=file&id=$id";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}
	//
	//
	function gethdgopvonListFile($proID){
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
		hdgopvonListFile();
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
?>