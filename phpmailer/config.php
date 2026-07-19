<?php 
function sendMailer($title, $content, $nTo, $mTo, $diachicc='', $emailFrom, $nameFrom){
	$nFrom = "CTY CỔ PHẦN TM QUỐC TẾ THUẬN PHÁT";    //mail duoc gui tu dau, thuong de ten cong ty ban
	// Gmail (dang dung)
	$mFrom = 'thuanphatitcjsc@gmail.com';  //dia chi email cua ban
	$mPass = 'ueuhgdtfqrtvacjz';       //mat khau email cua ban
	// Webmail hosting (cu) - giu lai de sau can dung lai
	//$mFrom = 'support@thuanphatitc.vn';
	//$mPass = 'anhthao92a@A';
	$nTo = $nTo; //Ten nguoi nhan
	$mTo = $mTo;   //dia chi nhan mail
	
	$mail             = new PHPMailer();
	$body             = "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
  <tr>
    <td align=\"center\"><img src=\"https://thuanphatitc.vn/theme/default/images/header/logo.png\" width=\"30%\"></td>
  </tr>
  <tr>
    <td align=\"right\" style=\"color:#006e3d\"><a href=\"\" target=\"_blank\">www.thuanphatitc.vn</a><br>Hotline: 0867.764.931</td>
  </tr>
</table>";
	$body             .= $content;
	$body             .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
  <tr>
    <td style=\"padding-top:10px\">Thuận Phát cám ơn sự hợp tác của Quý vị!</td>
  </tr>
   <tr>
    <td>Mọi thông tin chi tiết xin truy cập website: www.thuanphatitc.vn hoặc liên hệ hotline: 0867.764.931</td>
  </tr>
</table>";
	$title = $title;   //Tieu de gui mail
	
	$mail->IsSMTP();             
	$mail->CharSet  = "utf-8";
	$mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;    // enable SMTP authentication
	$mail->SMTPSecure = "ssl";   // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";    // sever gui mail.
	$mail->Port       = 465;         // cong gui mail de nguyen
	//$mail->SMTPSecure = "tls";                 // Webmail hosting (cu) - giu lai de sau can dung lai
	//$mail->Host       = "mail.thuanphatitc.vn";
	//$mail->Port       = 587;
	
	$mail->Username   = $mFrom;  // GMAIL username
	$mail->Password   = $mPass;               // GMAIL password
	$mail->SetFrom($mFrom, $nFrom);
	//chuyen chuoi thanh mang
	$ccmail = explode(',', $diachicc);
	$ccmail = array_filter($ccmail);
	if(!empty($ccmail)){
		foreach ($ccmail as $k => $v) {
			$mail->AddCC($v);
		}
	}
	$mail->Subject    = $title;
	$mail->MsgHTML($body);
	$address = $mTo;
	$mail->AddAddress($address, $nTo);
	$mail->AddReplyTo($emailFrom, $nameFrom);
	if(!$mail->Send()) {
		return 0;
	} else {
		return 1;
	}
}