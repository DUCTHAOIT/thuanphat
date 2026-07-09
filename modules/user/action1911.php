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
		
		$sql = "SELECT * FROM user WHERE email = '$txtEmail'";
		$rs = $db->Execute($sql);
		if(!$rs->fields("email")){	
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
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>Email đã được đăng ký</strong>
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
		if($return){
		?>
        <script>
			exportHTML();
			
			function exportHTML(){
			
			var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
			
			"xmlns:w='urn:schemas-microsoft-com:office:word' "+
			
			"xmlns='http://www.w3.org/TR/REC-html40'>"+
			
			"<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
			
			var footer = "</body></html>";
			
			var sourceHTML = header+document.getElementById("source-html").innerHTML+footer;
			
			
			
			var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
			
			var fileDownload = document.createElement("a");
			
			document.body.appendChild(fileDownload);
			
			fileDownload.href = source;
			
			fileDownload.download = 'hopdongTSI.doc';
			
			fileDownload.click();
			
			document.body.removeChild(fileDownload);
			
			}
			
			</script>
            <div id="source-html" style="display:none">
                <html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
                    <body>
                        <p align="center"><strong>CỘNG HÒA XÃ HỘI  CHỦ NGHĨA VIỆT NAM</strong><br>
                  Độc lập - Tự do-  Hạnh phúc<br>
                  -------------------<br>
                  <strong>HỢP ĐỒNG HỢP TÁC  ĐẦU TƯ</strong><br>
                  Số: …./HTĐT<br>
                </p>
                <p>  
                  <em>-    Căn cứ   Bộ Luật dân sự  nước Cộng hoà xã  hội chủ nghĩa Việt Nam năm 2015;</em><br>
                  <em>-    Căn cứ  Luật doanh nghiệp số 68/2014/QH13 ban hành ngày 01/07/ 2015</em><br>
                  <em>-    Căn cứ Luật đầu tư số 67/2014/QH13 ban hành  năm ngày 26/11/2014</em><br>
                  <em>-    Căn cứ Luật Chứng khoán số 70/2006/QH11  được ban hành ngày 29/06/2006</em><br>
                  <em>-   Căn  cứ vào khả năng và nhu cầu của hai bên.</em><br>
                  <em>-   Hôm  nay,  ngày 22 tháng 01 năm 2018</em><br>
                  <em> Chúng  tôi gồm có:</em><br>
                   <strong>Bên A: </strong><br>
                  Họ tên: <?php echo $name;?> <br>
                  Sinh năm: <?php echo $sinhngay;?><br>
                  Số CMND/căn cước công dân: <?php echo $cmt;?><br>
                  Cấp ngày: <?php echo $ngaycmt;?> - Nơi cấp: <?php echo $noicapcmt;?><br>
                  Địa chỉ: <?php echo $address;?><br>
                  Điện thoại: <?php echo $mobile;?><br>
                  Email: <?php echo $txtEmail;?><br>
                  Số tài khoản ngân hàng bên A: <?php echo $tknh;?><br>
                  Chủ tài khoản: <?php echo $tenchutknh;?><br>
                  Ngân hàng: <?php echo $nganhangtknh;?> - <?php echo $chinhanhtknh;?><br>
                  <strong><em>(Sau đây gọi là Bên A)</em></strong><br>
                  <strong>Bên B: </strong><strong> </strong><br>
                  Địa chỉ          : Số 25D ngõ 38/24, Đường Xuân La, Phường Xuân La, Quận Tây Hồ, Thành Phố  Hà Nội, Việt Nam.<br>
                  Văn phòng     : Số 1, Đường Phạm Huy  Thông, Phường Ngọc Khánh, Quận Ba Đình, Thành Phố Hà Nội, Việt Nam.<br>
                  Mã số thuế    : 0107790791<br>
                  Đại diện        :  Đỗ Danh Thanh<br>
                  <strong><em>(Sau đây gọi là bên B)</em></strong><br>
                  <strong><em>Các bên cùng thoả thuận ký Hợp đồng  hợp tác này với các điều khoản và điều kiện sau đây:</em></strong><br>
                  <strong>Điều 1. Định nghĩa </strong><br>
                  <strong>“Vốn hợp tác đầu tư” </strong>là khoản tiền bên A  chuyển cho bên B để thực hiện hoạt động hợp tác đầu tư trên tài khoản đầu tư.<br>
                  <strong>“Tài khoản đầu tư”</strong> là  tài khoản chứng khoán do Bên B là chủ tài  khoản, được sử dụng để thực hiện việc đầu tư theo hợp đồng này.  <br>
                  <strong>“Đơn vị đầu tư&quot; </strong>là<strong> </strong>Vốn hợp tác  trên tài khoản đầu tư chia thành nhiều phần bằng nhau. Mệnh giá của Đơn vị đầu  tư tại ngày giao dịch đầu tiên là 10.000 đồng. Mỗi Đơn vị đầu tư đại diện cho  phần lợi nhuận và vốn như nhau của Tài khoản đầu tư.<br>
                  <strong>“Ngày định giá” </strong>là ngày xác định Gía trị  tài sản ròng của Tài khoản đầu tư cho mục đích ký hợp đồng hoặc thanh lý hợp  đồng với bên A hoặc làm báo cáo gửi bên A. <br>
                  <strong>“Ngày giao dịch”</strong> là ngày bên B nhận được  khoản Vốn góp của bên A.<br>
                  <strong>“Ngày đáo hạn”</strong> là ngày cuối cùng của thời hạn  hợp tác, nếu ngày đáo hạn không phải ngày làm việc, thì nó sẽ được tính vào  ngày làm việc kế tiếp.</p>
                <p><strong>Điều 2. MỤC TIÊU, THỜI HẠN HỢP TÁC</strong><br>
                    <strong>2.1 Mục tiêu</strong><br>
                  - Bên A góp Vốn hợp tác  đầu tư với mục đích kiếm lợi nhuận từ việc đầu tư vào thị trường chứng khoán. <br>
                  - Bên B toàn quyền sử  dụng Vốn hợp tác đầu tư để tiến hành các hoạt động đầu tư vào thị trường chứng  khoán trên Tài khoản đầu tư theo quy định của pháp luật.<br>
                  <strong>-</strong> Bên B được phép sử dụng  các dịch vụ được cung cấp bởi công ty chứng khoán nơi bên B mở tài khoản giao  dịch, bao gồm các hoạt động ứng trước tiền bán, giao dịch ký quỹ ( margin), và  các dịch vụ khác… <br>
                  <strong>2.3 Thời hạn hợp tác</strong><br>
                  Thời hạn hợp tác là 1 năm.  Bắt đầu từ ngày <strong>…</strong> tháng <strong>…</strong> năm <strong>…</strong> tới ngày <strong>….</strong> tháng <strong>… </strong>năm <strong>….</strong> .Sau khi kết thúc thời hạn hợp tác 1 năm, 2 bên có thể tiếp tục  thỏa thuận kéo dài thêm thời hạn hợp tác.<br>
                  Sau khi kết thúc thời hạn hợp tác, Bên A và  Bên B phải thực hiện đầy đủ các quyền và nghĩa vụ của 2 bên trong vòng 5 ngày  làm việc. <br>
                  <strong>Điều 3. NỘI DUNG HỢP TÁC ĐẦU TƯ</strong><br>
                  <strong>3.1 Tài khoản đầu tư</strong><br>
                  Toàn bộ vốn góp của bên A sẽ được chuyển vào  tài khoản đầu tư của bên B được mở tại: Công ty cổ phần chứng khoán Tân Việt<br>
                  - Số tài khoản: <br>
                  - Chủ tài khoản: <br>
                  <strong>3.2 Cách tính số lượng Đơn vị đầu tư</strong></p>
                <ul>
                  <li>Sau khi chuyển tiền vào Tài khoản đầu tư, Bên  A sẽ nhận được số lượng Đơn vị đầu tư được tính như sau:</li>
                </ul>
                <table border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="934" valign="top"><div align="center">
                      <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="187" valign="top"><p align="center">Số      lượng Đơn vị đầu tư</p></td>
                          <td width="65" valign="top"><p align="center">=</p></td>
                          <td width="156" valign="top"><p align="center">Vốn      hợp tác đầu tư</p></td>
                          <td width="57" valign="top"><p align="center">:</p></td>
                          <td width="469" valign="top"><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư (tại ngày      định giá gần nhất trước ngày giao dịch)</p></td>
                        </tr>
                      </table>
                    </div></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>- Số lượng Đơn vị đầu tư được làm tròn đến  hàng đơn vị.<br>
                  - <strong>Giá  trị Tài sản ròng của một Đơn vị đầu tư</strong> được xác định bằng Tổng giá trị tài  sản ròng của Tài khoản đầu tư chia cho Tổng số lượng Đơn vị đầu tư hiện có tại  ngày định giá.<br>
                  <strong>“Tổng giá trị tài sản ròng của tài khoản đầu  tư”</strong> được tính bằng  Tổng tài sản của tài khoản đầu tư trừ đi tổng nợ phải trả của tài khoản đầu tư  tại ngày định giá.<br>
                  <strong>“Tổng tài sản của tài khoản đầu tư</strong>” là tổng giá trị  thị trường của danh mục đầu tư có trong Tài khoản đầu tư và tổng giá trị tiền  tại ngày định giá bao gồm: <br>
                  + Tiền mặt <br>
                  + Cổ tức bằng tiền  chờ về<br>
                  + Tiền bán chứng  khoán chờ nhận về<br>
                  + Các khoản tiền  khác phát sinh trên tài khoản đầu tư<br>
                  + Danh mục đầu tư  bao gồm các cổ phiếu hiện có, các cổ phiếu đang chờ về trên tài khoản đầu tư. </p>
                <p><strong>“T</strong><strong>ổ</strong><strong>ng n</strong><strong>ợ</strong><strong> ph</strong><strong>ả</strong><strong>i tr</strong><strong>ả</strong><strong> c</strong><strong>ủ</strong><strong>a t</strong><strong>à</strong><strong>i kho</strong><strong>ả</strong><strong>n </strong><strong>đầ</strong><strong>u t</strong><strong>ư</strong><strong>”</strong> Là tổng các khoản nợ phát sinh trên tài khoản đầu tư tại ngày định giá bao gồm:<br>
                + Các khoản tiền vay của bên A để mua chứng khoán (margin)<br>
                + Tiền lãi vay  margin<br>
                + Phí lưu ký<br>
                + Phí chuyển khoản chứng khoán<br>
                Và các khoản phí,  lãi khác phát sinh trên tài khoản đầu tư <br>
                <strong>3.3. Vốn hợp tác đầu tư</strong> </p>
                <ul>
                  <li>Bên A góp vốn hợp tác đầu tư bằng tiền mặt  giá trị:……………………..</li>
                  <li>Bằng chữ: ………………………</li>
                  <li>Tại ngày 22 tháng 01 năm 2018 thời điểm hai  bên thống nhất về việc hợp tác đầu tư:</li>
                  <li>Gía trị tài sản ròng của một Đơn vị đầu tư là: <strong>………….</strong></li>
                  <li>Số lượng Đơn vị đầu tư bên A nhận được tương  ứng với số Vốn hợp tác kinh doanh là: <strong>……………</strong> đơn vị đầu tư (bằng chữ: …………………………….)      </li>
                  <li>Trong trường hợp Bên A góp thêm Vốn hợp tác  đầu tư sau hợp đồng này thì hai bên sẽ ký phụ lục hợp đồng bổ sung Vốn hợp tác  đầu tư. </li>
                </ul>
                <p><strong>Điều 4. PHÂN CHIA LỢI NHUẬN</strong> <br>
                    <em>4.1 Xác </em><em>đị</em><em>nh l</em><em>ợ</em><em>i nhu</em><em>ậ</em><em>n h</em><em>ợ</em><em>p tác </em><em>đầ</em><em>u t</em><em>ư</em><br>
                  Tại thời điểm chấm dứt  hợp đồng hoặc thời điểm bên A rút vốn đầu tư, tổng giá trị tài sản ròng của khoản Vốn hợp tác đầu tư của bên A được xác định theo công  thức sau:</p>
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="234"><br>
                      Tổng giá trị tài sản ròng của khoản Vốn hợp tác đầu tư </td>
                    <td width="57"><p align="center">=</p></td>
                    <td width="269"><p align="center">Tổng số lượng Đơn vị đầu tư của bên A </p></td>
                    <td width="71"><p align="center">x</p></td>
                    <td width="284"><p align="center">Giá trị tài sản ròng của một Đơn vị đầu tư tại ngày đáo hạn </p></td>
                  </tr>
                </table>
                <p>Lợi nhuận hợp tác đầu tư được xác định như sau:</p>
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="204"><br>
                      Lợi nhuận hợp tác đầu tư </td>
                    <td width="57"><p align="center">=</p></td>
                    <td width="326"><p align="center">Tổng giá trị tài sản ròng của khoản vốn hợp tác đầu tư của bên A tại ngày đáo hạn </p></td>
                    <td width="44"><p align="center">-</p></td>
                    <td width="284"><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
                  </tr>
                </table>
                <p><em>4.2 Tỷ lệ phân chia lợi nhuận hợp tác đầu tư</em></p>
                <table border="0" cellspacing="0" cellpadding="0" width="886">
                  <tr>
                    <td width="123"><br>
                      Tỷ suất lợi nhuận     hợp    tác đầu tư </td>
                    <td width="26"><p align="center">=</p></td>
                    <td width="156"><p align="center">Lợi nhuận hợp tác đầu tư </p></td>
                    <td width="57"><p align="center">:</p></td>
                    <td width="255"><p align="center">Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu </p></td>
                    <td width="99"><p align="center">x</p></td>
                    <td width="170"><p align="center">100 </p></td>
                  </tr>
                </table>
                <p>- Trường hợp 1: Tỷ  suất lợi nhuận hợp tác đầu tư &lt; 10% hoặc Tỷ suất lợi nhuận hợp tác đầu tư &lt; 0%:  Bên A nhận về vốn hợp tác đầu tư còn lại được xác định bằng Tổng giá trị tài  sản ròng của khoản vốn hợp tác đầu tư của bên A tại ngày đáo hạn.<br>
                  - Trường hợp 2: 10% =&lt; Tỷ suất lợi nhuận hợp  tác đầu tư &lt; 50%: <br>
                  + Lợi nhuận bên A nhận được bằng 85% của Lợi nhuận hợp tác đầu tư. <br>
                  + Bên B  được nhận 15% của Lợi nhuận hợp tác đầu tư.<br>
                  - Trường hợp 3: 50% =&lt; Tỷ suất lợi nhuận  hợp tác đầu tư &lt; 100%:<br>
                  + Lợi nhuận bên A nhận được bằng 80% của Lợi nhuận hợp tác đầu tư. <br>
                  + Bên B  được nhận 20% của Lợi nhuận hợp tác đầu tư.<br>
                  - Trường hợp 4: 100% =&lt; Tỷ suất lợi nhuận  hợp tác đầu tư: <br>
                  + Lợi nhuận bên A nhận được bằng 75% của Lợi nhuận hợp tác đầu tư. <br>
                  + Bên B  được nhận 25% của Lợi nhuận hợp tác đầu tư.<br>
                  <em>4.3 Nghĩa vụ thuế</em><br>
                  - Bên A có nghĩa  vụ đóng thuế thu nhập cá nhân 5% cho phần lợi nhuận được chia từ Lợi nhuận hợp  tác đầu tư (theo thông tư 111/2013/TT-BTC ngày 15/08/2013).<br>
                  - Bên B sẽ khấu  trừ phần thuế 5% này trước khi trả lợi nhuận đầu tư cho bên A và có nghĩa vụ  đóng thuế cho cơ quan thuế giúp bên A.<br>
                  - Phần lợi nhuận  hợp tác đầu tư của bên B sẽ do bên B chủ động đóng thuế thu nhập doanh nghiệp  với cơ quan thuế. <br>
                  <strong>Điều 5. Hoàn trả Vốn góp </strong><br>
                  5.1 Bên A chỉ được rút vốn vào ngày làm việc  thứ 6 hàng tuần (nếu thứ 6 là ngày nghỉ lễ thì Bên A được rút vào ngày làm việc  thứ 6 tiếp theo) và bên A phải thông báo về Giá trị vốn rút với bên B muộn nhất  là 1 ngày làm việc trước đó. Giá trị 1 đơn vị đầu tư là giá trị tài sản ròng của một Đơn vị đầu tư tại ngày rút vốn. <br>
                  5.2 Trường hợp bên A rút vốn khi hết hạn hợp  đồng<br>
                  Tổng giá trị tài sản ròng của khoản vốn hợp tác đầu tư của bên A sẽ được tính theo công  thức nêu tại khoản 4.1 Điều 4 Hợp đồng này. </p>
                <ul>
                  <li>Nếu tổng giá trị tài sản ròng của khoản vốn hợp  tác đầu tư của Bên A cao hơn Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu (Tức là hoạt động đầu tư có lãi),  Bên A được nhận lợi nhuận theo quy định tại điều 4.2 Hợp đồng này cộng thêm  khoản tiền Vốn hợp tác đầu tư ban đầu. </li>
                  <li>Nếu tổng giá trị tài sản ròng của khoản vốn hợp  tác đầu tư của Bên A nhỏ hơn hoặc bằng Vốn hợp tác đầu tư của bên A tại thời điểm ban đầu (tức là hoạt động đầu tư không  có lãi hoặc lỗ) bên A được hoàn trả vốn tương ứng với Tổng giá trị tài sản ròng của khoản vốn hợp tác  đầu tư còn lại của Bên A tại ngày đáo hạn. </li>
                  <li>Số tiền bên B trả cho bên A sẽ được chuyển  vào tài khoản ngân hàng được bên A cung cấp trong vòng 5 ngày làm việc kể từ  khi tất toán hợp đồng. </li>
                </ul>
                <p>5.3 Trường hợp bên  A rút vốn trước khi hết hạn hợp đồng<br>
                  - Bên A được hoàn  trả vốn góp theo quy định tại Điều 4 sau khi trừ phí rút trước hạn hợp đồng.<br>
                  - Phí được rút trước hạn hợp đồng bên B quy định như sau:</p>
                <div align="center">
                  <table border="1" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <td width="60%"><br>
                        Thời hạn hợp tác đầu tư (Tính từ ngày giao    dịch đến ngày đáo hạn) </td>
                      <td width="40%"><p align="center">Phí rút trước hạn (% tính trên tổng giá trị    rút vốn)</p></td>
                    </tr>
                    <tr>
                      <td ><p align="center">Thời hạn &lt; 90 ngày</p></td>
                      <td ><p align="center">2% </p></td>
                    </tr>
                    <tr>
                      <td ><p align="center">90 ngày =&lt; Thời hạn &lt; 180 ngày</p></td>
                      <td ><p align="center">1% </p></td>
                    </tr>
                    <tr>
                      <td ><p align="center">180 ngày =&lt; Thời hạn</p></td>
                      <td ><p align="center">0% </p></td>
                    </tr>
                  </table>
                </div>
                <p><strong>Điều 6.   Các nguyên tắc tài chính</strong></p>
                <ul>
                  <li>Hai bên phải tuân thủ các nguyên tắc tài  chính kế toán theo qui định của pháp luật về kế toán của nước Cộng hoà xã hội  chủ nghĩa Việt Nam.</li>
                  <li>Các khoản thu, chi trên tài khoản đầu tư cần  được ghi chép đầy đủ, minh bạch.</li>
                </ul>
                <p><strong>Điều 7.   Quyền và nghĩa vụ của Bên A</strong><br>
                    <strong>7.1 Bên A có quyền: </strong></p>
                <ul>
                  <li>Yêu cầu Bên B báo cáo tình hình hoạt động đầu tư  theo định kỳ.</li>
                  <li>Hưởng lợi nhuận đầu tư theo kết quả hoạt động đầu  tư.</li>
                  <li>Được hoàn trả Vốn hợp tác đầu tư theo quy định tại  Điều 5 của Hợp đồng này.</li>
                </ul>
                <p><strong>7.2 Bên A có nghĩa vụ:</strong></p>
                <ul>
                  <li>Góp vốn đủ theo cam kết.</li>
                  <li>Đảm bảo nguồn vốn góp hợp pháp và thuộc quyền  sở hữu của Bên A.</li>
                  <li>Chấp nhận toàn bộ kết quả đầu tư do bên B  thực hiện trên tài khoản đầu tư  trong  thời hạn hợp tác.</li>
                  <li>Chịu các khoản phí: phí lưu ký chứng khoán,  Phí chuyển khoản chứng khoán và các khoản phí, lãi  khác phát sinh trên tài khoản đầu tư.</li>
                </ul>
                <p><strong>Điều 8.   Quyền và nghĩa vụ của bên B</strong><br>
                    <strong>8.1 Bên B có quyền </strong></p>
                <ul>
                  <li>Nhận và sử dụng Vốn hợp tác đầu tư theo đúng  phạm vi và mục tiêu hợp tác;</li>
                  <li>Hưởng lợi nhuận theo quy định tại Điều 4 Hợp  đồng này.</li>
                </ul>
                <p><strong>8.2 Bên B có nghĩa vụ</strong></p>
                <ul>
                  <li>Báo cáo tình hình sử dụng nguồn vốn góp; báo  cáo danh mục đầu tư;</li>
                  <li>Thanh toán Lợi nhuận cho bên B đúng thời hạn  theo thỏa thuận trong hợp đồng này;</li>
                  <li>Thực hiện đúng các cam kết trong hợp đồng  này.</li>
                </ul>
                <p><strong>Điều 9. Cam kết của các hai bên</strong><br>
                  Bên A và Bên B chịu trách nhiệm trước pháp  luật về những lời cam đoan sau đây:</p>
                <ul>
                  <li>Những  thông tin về nhân thân, chủ thể ghi trong hợp đồng này là đúng sự thật;<strong></strong></li>
                  <li>Việc  giao kết Hợp đồng này là hoàn toàn tự nguyện, không bị lừa dối, ép buộc.</li>
                  <li>Bên A  hiểu và chấp nhận việc tham gia góp vốn hợp tác đầu tư trên Tài khoản quy định  tại khoản 3.1 Điều 3 Hợp đồng này sẽ gồm việc hợp tác đầu tư của bên B và nhiều  bên khác.</li>
                  <li>Bên A  đã hiểu và nhận thức rõ về những rủi ro có thể xảy ra trong quá trình hợp tác  đầu tư. </li>
                  <li>Bên A  cam kết thực hiện đúng những thỏa thuận về điều kiện sử dụng vốn được nêu trong  Hợp đồng này.</li>
                  <li>Bên A  cam kết Vốn góp đã ghi trong hợp đồng này là đúng sự thật, thuộc quyền sở hữu  riêng, hợp pháp của bên A, không chứa đựng yếu tố nào dẫn tới việc bị cơ quan  nhà nước có thẩm quyền xem xét, xử lý theo quy định của pháp luật.</li>
                  <li>Bên B  thực hiện việc quản lý và đầu tư vốn hợp tác đầu tư theo đúng quy định tại hợp  đồng này. </li>
                </ul>
                <p><strong>Điều 10.   Điều khoản chung           </strong></p>
                <ul>
                  <li>Hợp đồng này được hiểu và chịu sự điều chỉnh  của Pháp luật nước Cộng hoà xã hội chủ nghĩa Việt Nam.</li>
                  <li>Mọi sửa đổi, bổ sung hợp đồng này đều phải  được lập phụ lục kèm theo và có chữ ký của hai bên. Các phụ lục là phần không  tách rời của hợp đồng.</li>
                  <li>Mọi  tranh chấp phát sinh trong quá trình thực hiện hợp đồng được giải quyết trước  hết qua thương lượng, hoà giải, nếu hoà giải không thành việc tranh chấp sẽ  được giải quyết tại Toà án có thẩm quyền.<strong><u></u></strong></li>
                </ul>
                <p><strong>Điều 11.   Hiệu lực Hợp đồng</strong><br>
                  - Hợp đồng này có hiệu lực từ ngày ký. Khi  kết thúc Hợp đồng, hoặc theo yêu cầu của bên A về việc rút vốn hợp tác đầu tư,  hai bên sẽ làm biên bản thanh lý hợp đồng và phân chia lợi nhuận được quy định  tại Điều 4 của Hợp đồng này. <br>
                  - Khi hết thời hạn hợp tác, nếu hai bên không  có yêu cầu thanh lý Hợp đồng thì Hợp đồng này sẽ tiếp tục được gia hạn cho tới  khi có yêu cầu thanh lý hợp đồng của một trong hai bên và khoản 5.2 Điều 5 của  Hợp đồng này không còn hiệu lực. <br>
                  - Hợp đồng này gồm 08 trang không thể tách  rời nhau, được lập thành 02 (hai) bản bằng tiếng Việt, mỗi Bên giữ 01 (một) bản  có giá trị pháp lý như nhau và có hiệu lực kể từ ngày ký.</p>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td width="50%" valign="top" align="center">
                        <strong>Đại diện bên A</strong> </td>
                    <td width="50%" valign="top" align="center"><strong>Đại diện bên B</strong></td>
                  </tr>
                </table>
                </div>
                </body>
                </html>
        <?php
			echo "<div style=\"padding-top:100px; padding-bottom:100px; font-weight:bold\">
			<li>Hợp đồng đã được tạo: <button id=\"btn-export\" onClick=\"exportHTML();\">Quý khách bấm vào đây để tải hợp đồng về</button></li>
			<li>Hợp đồng sẽ được gửi vào Email của Quý khách sau khi TSI xác thực lại thông tin. Quý khách vui lòng đọc các điều khoản dịch vụ trong hợp đồng.</li>
			<li>Khi quý khách ĐẶT MUA và ĐỒNG Ý với các điều khoản dịch vụ trong hợp đồng, đồng nghĩa với việc Hợp Đồng điện tử đã được xác lập giữa hai bên.</li>
			<li>Hợp đồng điện tử này có giá trị pháp lý tương đương hợp đồng bằng văn bản.</li><br>
			</div>";			
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; text-align:center; font-weight:bold\">False!</div>";	
		}		
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