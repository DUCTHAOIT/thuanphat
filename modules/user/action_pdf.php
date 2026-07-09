<?php
function createRegister_(){
		include_once("header.php");
		global $db, $lable;
		include_once(_DOMAIN_ROOT_PATH . "/phpmailer/class.smtp.php");
		include_once(_DOMAIN_ROOT_PATH . "/phpmailer/class.phpmailer.php");
		include_once(_DOMAIN_ROOT_PATH . "/phpmailer/config.php");
		require(_DOMAIN_ROOT_PATH . "/modules/newsletter/functions.php");
		
		//$txtUsername=getParamPost("txtUsername");
		$txtUsername=getParamPost("txtEmail");
		$txtEmail=getParamPost("txtEmail");
		$txtPassword=md5(getParamPost("txtPassword"));
		$name=getParamPost("name");
		$mobile=getParamPost("mobile");
		$random_key = random_string('alnum', 32);
		$gioithieu=getParamPost("gioithieu");
		
		
		$record=array();
		$record["username"]=$txtUsername;
		$record["email"]=$txtEmail;
		$record["password"]=$txtPassword;
		$record["name"]=$name;
		$record["mobile"]=$mobile;
		$record["gioithieu"]=$gioithieu;
		$record["random_key"]=$random_key;
			
		$sql = "SELECT * FROM user WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);	
		$idNew=$db->Insert_ID();
		
		$to = $txtEmail;
	
		$subject = "Xác nhận đăng ký tài khoản trên "._DOMAIN_ROOT_URL.".<br><br>";
		//$message = "Xin chào! cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". Bạn hãy click vào link bên dưới để xác nhận việc đăng ký:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".mysql_insert_id()."&key=".$random_key."<br><br>";
		$message= "<b>Kính gửi quý khách hàng ".$name."</b><br><br>";
		$message.= "Cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". <br><br>";
		$message.= "Tên đăng nhập: ".$txtEmail." hoặc ".$mobile." <br><br>";
		$message.= "Mật khẩu: quý khách đã đăng ký online <br><br>";
		
		$message.= "Để kích hoạt tài khoản, quý khách vui lòng click vào link:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".$idNew."&key=".$random_key."<br><br>";	
		
		//
		$emailFrom		=getSession("email");
		$nameFrom		=_DOMAIN_ROOT_URL;
		$emailTo      	= $to;		
		$nameTo			= $name;			
		$subject 		= $subject;					
		$content		=$message;
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #154491;\">";
		$HTML.=$content;
		$HTML.="</span>";
		
		$mail = sendMailer($subject, $message, $name, $txtEmail, $diachicc='', $emailFrom, $nameFrom);
			if($mail==1){
			echo "<div style=\"padding-top:60px; padding-bottom:160px; padding-left:20px; padding-right:20px\" align=\"center\">
			<strong>Đăng ký thành công! mời bạn kiểm tra mail để kích hoạt tài khoản</a>.
			</div>";
			}else{	
			echo "<div style=\"padding-top:60px; padding-bottom:160px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
			<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
			</div>";
			}
	include_once("footer.php");
	}
	function createRegister(){
		include_once("header.php");
	
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		global $db, $lable;
		require(_DOMAIN_ROOT_PATH . "/modules/newsletter/functions.php");
		$txtUsername=getParamPost("txtEmail");
		$txtEmail=getParamPost("txtEmail");
		$txtPassword=md5(getParamPost("txtPassword"));
		$name=getParamPost("name");
		$mobile=getParamPost("mobile");
		$address=getParamPost("address");
		$cmnd=getParamPost("cmnd");
		$gioithieu=getParamPost("gioithieu");
		$random_key = random_string('alnum', 32);
				
		$record=array();
		$record["username"]=$txtUsername;
		$record["email"]=$txtEmail;
		$record["password"]=$txtPassword;
		$record["name"]=$name;		
		$record["mobile"]=$mobile;
		$record["address"]=$address;
		$record["cmnd"]=$cmnd;
		$record["gioithieu"]=$gioithieu;
		$record["img"]=$img;
		$record["rand_key"]=$random_key;
			
		$sql = "SELECT * FROM user WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		
		$return=$db->Execute($sql);	
		$idNew=$db->Insert_ID();
	
		$subject = "Xác nhận đăng ký tài khoản trên "._DOMAIN_ROOT_URL.".<br><br>";
		$message= "<b>Kính gửi quý khách hàng ".$name."</b><br><br>";
		$message.= "Cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". <br><br>";
		$message.= "Tên đăng nhập: ".$txtEmail." hoặc ".$mobile." <br><br>";
		$message.= "Mật khẩu: quý khách đã đăng ký online <br><br>";
		$message.= "Để kích hoạt tài khoản, quý khách vui lòng click vào link:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".$idNew."&key=".$random_key."<br><br>";
	
		
		//
		$emailFrom		= getSession("email");
		$nameFrom		= getSession("email");		
		//$emailTo      	= "vnhomestay.com.vn@gmail.com";
		$emailTo      	= $txtEmail;		
		$nameTo			= $name;
		$subject 		= "Xác nhận đăng ký tài khoản";					
		$content		= $message;
		
		
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML.=$message;
		$HTML.="</span>";
		
		$HTML2="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML2.="Có tài khoản tạo mới trên TSI.<br />--------------------------------<br />";
		$HTML2.="</span>";
		$HTML2.=$HTML;	
		
	
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML2, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo '<div style="padding-top:60px; padding-bottom:160px; line-height:30px" class="title" align="center">					
					Quý khách đã đăng ký thành viên thành công, xin kiểm tra mail và kích hoạt tài khoản.</div>';
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		include_once("footer.php");
	}
	//
	function randPasword(){
		include_once("header.php");
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		global $db, $lable;
		//$username=getParamPost("txtUsername");
		$email=getParamPost("txtEmail");		
		$sql="SELECT * FROM user WHERE ((email='$email') OR (mobile='$email'))";
		$rs = $db->Execute($sql);
		
		if($rs->fields("email")){
			$password=uniquename();
			$sql="UPDATE user SET password='".md5($password)."' WHERE email='$email'";						
			$db->Execute($sql);	

			$emailFrom		=getSession("email");
			$nameFrom		=getSession("site_name");			
			$emailTo      	= $rs->fields("email");
			$nameTo			= $rs->fields("name");	
			
			$subject = "Lấy lại mật khẩu trên "._DOMAIN_ROOT_URL."";
			//$message = "Xin chào! cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". Bạn hãy click vào link bên dưới để kích hoạt tài khoản:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".$idNew."&key=".$random_key."<br><br>";
		
			//$content 		= $lable->_("Hello")." <b>". $rs->fields("username")."</b><p> ".$lable->_("Account on website") . "<a href=\""._DOMAIN_ROOT_URL."\">"._DOMAIN_ROOT_URL."</a></br>".$lable->_("Choose a password").": ". $password ."<p>";
		//	$content 		.= ;
			//$content 		.= $lable->_("User name").": ". $rs->fields("username")."<p>";
			$content 		= "<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\">
							  <tr>							
								<td align=\"left\">Xin chào ".$rs->fields("name")."</td>
							  </tr>
							 <tr>							
								<td align=\"left\">Thông tin tài khoản của bạn:</td>
							  </tr>
							  <tr>								
								<td align=\"left\">Tên đăng nhập: ".$rs->fields("username")." hoặc ".$rs->fields("mobile")."</td>
							  </tr>
							  <tr>								
								<td align=\"left\">Mật khẩu mới: ". $password ."</td>
							  </tr>
							</table>" ;	
					
			$resurn = sendMailer($subject, $content, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom); 
			if($resurn)	$note="Mật khẩu mới đã được gửi về địa chỉ mail của bạn, vui lòng kiểm tra mail để lấy thông tin";			
			else $note=$lable->_("Có lỗi sảy ra");
		}else{
			$note=$lable->_("Email này chưa đăng ký tài khoản");			
		}
		
	
		echo "<div style=\"padding-top:100px; padding-bottom:130px;  text-align:center; font-weight:bold\">".$note."</div>";		
		include_once("footer.php");
	}
	//
	function godetele(){
		global $db;
		$username=getSession("username");
		if(!$username) return;
		
		$id=getParam("id");
		
		$userid=getMemberNameID($username,"id");
		$sql="DELETE FROM  sys_userorder WHERE (id=$id) AND (userid=$userid)";	
		$result=$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="../user_buy_sell/";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		
	}	
	//
	function userLogin(){
		global $db;
		$email=getParamPost("email");
		$password=getParamPost("password");
		$ret_page=getParamPost("ret_page");
		
		$sql="SELECT * FROM user WHERE ((email='$email') OR (mobile='$email')) AND password=md5('$password') AND (ctrl&1=1)";
				
		$rs=$db->Execute($sql);	
			
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		
		$ret_page=getParamPost("ret_page");
			
		if(!$ret_page){
			$ret_page=getSession("ret_page");
			if(!$ret_page) $ret_page=_DOMAIN_ROOT_URL."/user_buy_sell/";
		}	
		
		if($rs->fields("email")){
			setSession("username",$rs->fields("username"));
			setSession("login_time_stamp",time());
			$MemberName=$rs->fields("name");											
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();			
		}		
		$a=new msgBox("Login false!","OKOnly", "Message", "../user_login/", 1);			
		$a->showMsg();
		setSession("ret_page","");
	}	
	//
	function uniquename(){
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
	function getMemberID($username){
		global $db;
		if(!$username) return;
		$sql="SELECT * FROM user WHERE (username='$username') AND (ctrl&1=1)";		
		$rs=$db->Execute($sql);
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		if(!$arr["img"]) $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/user/".$arr["img"];
		if(!$arr["img1"]) $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		else $arr["imgb_view"]=_DOMAIN_ROOT_URL."/images/user/".$arr["img1"];
		return $arr;
	}
	//
	function changeInfo(){
		global $db, $lable;
		$username=getSession("username");
		if(!$username) return;
		
		$txtUsername=getParamPost("txtEmail");
		$txtEmail=getParamPost("txtEmail");
		$txtPassword=getParamPost("txtPassword");
		$name=getParamPost("name");		
		$address=getParamPost("address");		
		$mobile=getParamPost("mobile");	
		$cmt=getParamPost("cmt");
		$tknh=getParamPost("tknh");
			
		$imgsmall=getParamPost("imgsmall");
		$imgbig=getParamPost("imgbig");
		
		$filePDF=getParamPost("filePDF");
		
		$sinhngay=getParamPost("sinhngay");	
		$sex=getParamPost("sex");	
		$ngaycmt=getParamPost("ngaycmt");	
		$noicapcmt=getParamPost("noicapcmt");	
		$tenchutknh=getParamPost("tenchutknh");	
		$nganhangtknh=getParamPost("nganhangtknh");	
		$chinhanhtknh=getParamPost("chinhanhtknh");	
		
		//if($filePDF){
		//	$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
		//	$to=_DOMAIN_ROOT_PATH."/images/user/$filePDF";
		//	moveFile($from,$to);
		//}
			
		
		//$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;		
		if($imgsmall){			
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;
			$to=_DOMAIN_ROOT_PATH."/images/user/".$imgsmall;
			moveFile($from,$to);			
		}
		//$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;		
		if($imgbig){		
			$from=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
			$to=_DOMAIN_ROOT_PATH."/images/user/".$imgbig;
			moveFile($from,$to);
			
		}	
		
		
		
		$record=array();
		$record["username"]=$txtUsername;
		$record["email"]=$txtEmail;
		if($txtPassword) $record["password"]= md5($txtPassword);
		
		$record["name"]=$name;
		$record["address"]=$address;
		$record["mobile"]=$mobile;
		$record["img"]=$imgsmall;
		$record["img1"]=$imgbig;
		
		$record["cmt"]=$cmt;
		$record["tknh"]=$tknh;		
		
		$record["sinhngay"]=$sinhngay;
		$record["sex"]=$sex;
		$record["ngaycmt"]=$ngaycmt;
		$record["noicapcmt"]=$noicapcmt;
		$record["tenchutknh"]=$tenchutknh;
		$record["nganhangtknh"]=$nganhangtknh;
		$record["chinhanhtknh"]=$chinhanhtknh;
		
		
		$sql = "SELECT * FROM user WHERE email='$username'";
		$rs = $db->Execute($sql);						
		$sql = $db->GetUpdateSQL($rs, $record);
		$return=$db->Execute($sql);		
		include_once("header.php");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="../?m=dompdf/";
	
		if($return){
			$a=new msgBox("Quý khách đã cập nhật thành công","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		
		//if($return){
		//
		
		//
		//	echo "<div style=\"padding-top:100px; padding-bottom:100px; font-weight:bold\">
		//	<li>Hợp đồng đã được tạo: <a href=\"../?m=dompdf&f=test\" target=\"_blank\"><button>Quý khách bấm vào đây để tải hợp đồng về</button></a></li>
		//	<li>Hợp đồng đã được gửi vào Email của Quý khách. Quý khách vui lòng đọc các điều khoản dịch vụ trong hợp đồng.</li>
		//	<li>Khi quý khách ĐẶT MUA và ĐỒNG Ý với các điều khoản dịch vụ trong hợp đồng, đồng nghĩa với việc Hợp Đồng điện tử đã được xác lập giữa hai bên.</li>
		//	<li>Hợp đồng điện tử này có giá trị pháp lý tương đương hợp đồng bằng văn bản.</li><br>
		//	</div>";			
		//}else{
		//	echo "<div style=\"padding-top:100px; padding-bottom:100px; text-align:center; font-weight:bold\">False!</div>";	
		//}		
		include_once("footer.php");
	}
		
	function productListUser($username){
		global $db,$lang;			
		$sql="SELECT sys_product.*";
		$sql.=" FROM add_list , sys_product";
		$sql.=" WHERE add_list.username =  '$username' AND add_list.idpro =  sys_product.id AND (sys_product.ctrl&1=1)";
		$sql.=" ORDER BY sys_product.date_create DESC";
		$arr=$db->GetAssoc($sql);	
		//echo $sql;	
		//print_r($arr);
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
	function getUserorder($username){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=0)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getUserSohuu(){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=0)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getUserorder2($username){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=1)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function getUserSohuu2(){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=1)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function getxacthucdatban($username){
		global $db;
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM user, sys_userorder";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&0=0) AND (sys_userorder.tinh_trang=1)";
		$sql.=" ORDER BY sys_userorder.date_create ASC";
		$arr=$db->GetAssoc($sql);
		return $arr;
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
		
		$sql="UPDATE sys_userorder SET model=model+'".$luonghuy."' WHERE id=$hdban";		
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="../user_buy_sell/";
	
		if($result){
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}else{
			$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
?>