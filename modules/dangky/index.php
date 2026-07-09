<?php
	switch($op){		
		case "dangky"		: addDangky();break;
		case "combo"		: addCombo();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;
		$idF=getparamFID(getParam(idF),false);	
		$topicName=getFunctionNameID($idF);
		
		//$des=getFunctionNameID($fid,"des");
		//$img1=getFunctionNameID($fid,"img1");
		$topicName=getFunctionNameID($fid);
		$smarty->assign('des',getFunctionNameID($idF,"des"));
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		
		$sql="SELECT * FROM sys_config WHERE (name='des') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$address=$rs->fields('value');
		
		$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$support=$rs->fields('value');
	
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$smarty->assign('theme',$themeName);
		$smarty->assign('topicName',$topicName);
		$smarty->assign('address',$address);
		$smarty->assign('support',$support);
		
		
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Mobile',$lable->_("Mobile"));
		$smarty->assign('Subject',$lable->_("Subject"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('Sendmail',$lable->_("Send mail"));
		$smarty->assign('Contact',$lable->_("Contact"));
		$smarty->assign('Address',$lable->_("Address"));
		$smarty->assign('Security_code',$lable->_("Security code"));		
		$smarty->assign('NoteContact',$lable->_("To contact the company please please fill out the contact form below"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/contact.tpl','contact_'.$themeName);	
		
		include_once("footer.php");
	}
	//
	function addDangky(){
		include_once("header.php");	
			
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		
		global $lable,$db,$lang;
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");
		$loaidt=getParamPost("loaidt");
		$mobile=trim(getParamPost("mobile"));
		$email=trim(getParamPost("email"));
		$cosohoc=getParamPost("cosohoc");
		$tenkhoahoc=getParamPost("tenkhoahoc");
		$content=getParamPost("content");	
		
		$datekhaigiang=getParamPost("datekhaigiang");
		$diadiemhoc=getParamPost("diadiemhoc");
		$sogio=getParamPost("sogio");
		$price=getParamPost("price");
		$price1=getParamPost("price1");
		$price2=getParamPost("price2");
		
		$khuyenmai=getParamPost("khuyenmai");
		$voucher=getParamPost("voucher");
		$tongtien=getParamPost("tong");
		if(!$tongtien){$tongtien=$price;}
		
		$nguoigioithieu=trim(getParamPost("nguoigioithieu"));
		$idpro=getParamPost("idpro");
		
		// tao user neu chua ton tai
		$sql = "SELECT * FROM user WHERE email = '$email'";
		$rs = $db->Execute($sql);
		if(!$rs->fields("email")){	
			$password=uniquename();
			$record=array();
			$record["username"]=$email;
			$record["email"]=$email;
			$record["password"]=md5($password);
			$record["name"]=$name;		
			$record["mobile"]=$mobile;
			$record["address"]=$address;
			$record["gioithieu"]=$nguoigioithieu;
						
			$sql = "SELECT * FROM user WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);		
			
			$return=$db->Execute($sql);	
			$userid=$db->Insert_ID();
		}else{
			$userid=$rs->fields("id");
		}
		
		///update voucher//////
		if($voucher){
			$sql="UPDATE sys_voucher SET trangthai='1', userid='".$userid."', dateuser='".date("Y-m-d")."' WHERE name='$voucher'";
			$db->Execute($sql);
		}
		///////
		$record=array();
		$record["name"]=$name;
		$record["mobile"]=$mobile;
		$record["email"]=$email;
		$record["tenkhoahoc"]=$tenkhoahoc;
		$record["cosohoc"]=$cosohoc;
		$record["content"]=$content;
		
		$record["datekhaigiang"]=$datekhaigiang;
		$record["diadiemhoc"]=$diadiemhoc;
		$record["sogio"]=$sogio;
		
		$record["price"]=$price;
		$record["khuyenmai"]=$khuyenmai;
		$record["voucher"]=$voucher;
		$record["tongtien"]=$tongtien;
		$record["nguoigioithieu"]=$nguoigioithieu;
		$record["catID"]=$idpro;
		$record["loaidt"]=$loaidt;
		$record["userid"]=$userid;
		$record["lang"]=$lang;	
		
		
		$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);
		$return=$db->Execute($sql);
		
		
		$emailFrom		=$email;
		$nameFrom		=$name;			
		$emailTo      	= getSession("email");			
		$nameTo			= "ViewGolf";			
		$subject 		= "Đăng ký khóa học ".$tenkhoahoc;		
		
		$contents = "".$subject."<br>";
		$contents .= "Họ tên học viên: ".$name."<br>";
		$contents .= "Điện thoại: ".$mobile."<br>";
		$contents .= "Email: ".$email."<br>";
		$contents .="Lời nhắn: ".$content."<br>";
		
		$TEXT="";
		$HTML=$contents;
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo "<div style=\"padding-top:100px; padding-bottom:200px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>Cám ơn bạn đã đăng ký tham gia khóa học. Chúng tôi sẽ liên hệ lại với bạn sớm nhất</strong>
		</div>";	
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		include_once("footer.php");
	}
	
	//
	function addCombo(){
		include_once("header.php");	
		
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		global $lable,$db,$lang;
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");
		$mobile=trim(getParamPost("mobile"));
		$email=trim(getParamPost("email"));
		$cosohoc=getParamPost("cosohoc");
		$tenkhoahoc=getParamPost("tenkhoahoc");
		$content=getParamPost("content");	
		
		$datekhaigiang=getParamPost("datekhaigiang");
		$diadiemhoc=getParamPost("diadiemhoc");
		
		$price=getParamPost("price");
		$khuyenmai=getParamPost("khuyenmai");
		$voucher=getParamPost("voucher");
		$tongtien=$price-$khuyenmai;
		
		$nguoigioithieu=trim(getParamPost("nguoigioithieu"));
		$idpro=getParamPost("idpro");
		
		// tao user neu chua ton tai
		$sql = "SELECT * FROM user WHERE email = '$email'";
		$rs = $db->Execute($sql);
		if(!$rs->fields("email")){	
			$password=uniquename();
			$record=array();
			$record["username"]=$email;
			$record["email"]=$email;
			$record["password"]=md5($password);
			$record["name"]=$name;		
			$record["mobile"]=$mobile;
			$record["address"]=$address;
			$record["gioithieu"]=$nguoigioithieu;
						
			$sql = "SELECT * FROM user WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);		
			
			$return=$db->Execute($sql);	
			$userid=$db->Insert_ID();
		}else{
			$userid=$rs->fields("id");
		}
		
		/////////
		
		
		$record=array();
		$record["name"]=$name;
		$record["mobile"]=$mobile;
		$record["email"]=$email;
		$record["tenkhoahoc"]=$tenkhoahoc;
		$record["cosohoc"]=$cosohoc;
		$record["content"]=$content;
		
		$record["datekhaigiang"]=$datekhaigiang;
		$record["diadiemhoc"]=$diadiemhoc;
		
		$record["price"]=$price;
		$record["khuyenmai"]=$khuyenmai;
		$record["voucher"]=$voucher;
		$record["tongtien"]=$tongtien;
		$record["nguoigioithieu"]=$nguoigioithieu;
		$record["catID"]=$idpro;
		$record["userid"]=$userid;
				
		$record["lang"]=$lang;	
		
		
		$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);
		$return=$db->Execute($sql);
		
		
		$contents = "".$name."<br>";
		$contents .= "".$mobile."<br>";
		$contents .= "".$email."<br>";
		$contents .=$content;		
		
		
		$emailFrom		=$email;
		$nameFrom		=$name;			
		$emailTo      	= getSession("email");			
		$nameTo			= "ViewGolf";			
		$subject 		= "Đăng ký Combo ".$subject;					
		$noidung		=$contents;
		
		$TEXT="";
		$HTML="<span>";
		$HTML.=$noidung;
		$HTML.="</span>";
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo "<div style=\"padding-top:100px; padding-bottom:200px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>Cám ơn bạn đã đăng ký tham gia khóa học. Chúng tôi sẽ liên hệ lại với bạn sớm nhất</strong>
		</div>";	
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
	include_once("footer.php");
}
?>