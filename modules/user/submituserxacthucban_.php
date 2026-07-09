<?php 
	include_once("header.php");	
		global $lable,$db,$lang;
		
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		$username=getSession("username");
		$name=getMemberNameID($username,"name");
		$mobile=getMemberNameID($username,"mobile");
		$userid=getMemberNameID($username,"id");
		$cmt=getMemberNameID($username,"cmt");
		$tknh=getMemberNameID($username,"tknh");
	
		$id=getParam("id");
		$idrut=getParam("idrut");
		
		$giadvdtchot=getParam("giadvdtchot");
		$soluongban=getParam("soluongban");
		$tongban=getParam("tongban");
		$lailo=getParam("lailo");
		$phihoptac=getParam("phihoptac");
		$tncn=getParam("tncn");
		$phiruttruochan=getParam("phiruttruochan");
		$thucnhan=getParam("thucnhan");
		
				
		$today = date("F j, Y, g:i a");
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM sys_userorder";
		$sql.=" WHERE (sys_userorder.id='$idrut')";		
		$rs=$db->Execute($sql);
		
		$contents="<p style=\"font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">XÁC NHẬN ĐẶT BÁN</p>";
		$contents.="<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" bordercolor=\"#f3f3f3\" style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">
		  <tr>
			<td colspan=\"2\">".$today."</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin người bán</strong></td>
		  </tr>		  
		  <tr>
			<td>Họ tên:</td>
			<td>".$name."</td>
		  </tr>
		  <tr>
			<td>Điện thoại:</td>
			<td>".$mobile."</td>
		  </tr>
		  <tr>
			<td>Email:</td>
			<td>".$username."</td>
		  </tr>
		  <tr>
			<td>CMND/CCCD/Hộ Chiếu:</td>
			<td>".$cmt."</td>
		  </tr>
		  <tr>
			<td>Tài khoản:</td>
			<td>".$tknh."</td>
		  </tr>
		   <tr>
			<td colspan=\"2\"><strong>Thông tin giao dịch</strong></td>
		  </tr>	
		  <tr>
			<td>Hợp đồng muốn rút vốn:</td>
			<td>".$rs->fields("name")."</td>
		  </tr>
		   <tr>
			<td>Ngày HĐ:</td>
			<td>".$rs->fields("date_create")."</td>
		  </tr>
		   <tr>
			<td>Số lượng ĐVĐT:</td>
			<td>".number_format($rs->fields("model"), 0, '.', ',')."</td>
		  </tr>
		   <tr>
			<td>Giá ĐVĐT:</td>
			<td>".number_format($rs->fields("price"), 0, '.', ',')." VNĐ</td>
		  </tr>
		   <tr>
			<td>Tổng giá trị:</td>
			<td>".number_format($rs->fields("price_old"), 0, '.', ',')." VNĐ</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin rút vốn</strong></td>
		  </tr>	
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Số lượng ĐVĐT muốn bán:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($soluongban, 0, '.', ',')."</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Giá bán 1 ĐVĐT:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($giadvdtchot, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Tổng giá trị bán:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tongban, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Lãi/Lỗ:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($lailo, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí hợp tác đầu tư:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phihoptac, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Chi phí rút trước hạn:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phiruttruochan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thuế thu nhập cá nhân:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tncn, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thực nhận:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($thucnhan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td colspan=\"2\" align=\"center\">TSI sẽ chuyển tiền vào tài khoản NĐT đã đăng ký vào ngày thứ 6.</td>
		  </tr>
		</table>";	
					
		$emailFrom		=$username;
		$nameFrom		=$name;			
		//$emailTo      	= "duongmn.ict@gmail.com";
		$emailTo      	= getSession("email");			
		$nameTo			= getSession("email");		
		$subject 		= "XÁC NHẬN ĐẶT BÁN";					
		$content		=$contents;
		
		//luu data		
		
		$sql="UPDATE sys_userorder SET price='".$giadvdtchot."' WHERE id=$id";		
		$db->Execute($sql);
		//
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML.=$content;
		$HTML.="</span>";	
		
		$HTML2="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML2.="Thưa quí khách,<br>TSI xin cảm ơn quí khách đã quan hợp tác với chúng tôi. Chúng tôi đã nhận được yêu cầu của quí khách và sẽ liên hệ lại với quí khách trong thời gian sớm nhất.<br />
--------------------------------<br />";
		$HTML2.="</span>";
		$HTML2.=$HTML;	
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo '<div style="padding-top:10px">'.$content.'</div><div style="padding-top:10px" class="title" align="center">Yêu cầu đặt bán của quý khách đã được thiết lập, cám ơn quý khách đã đồng hành cùng TSI.</div>';
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		
include_once("footer.php");
?>