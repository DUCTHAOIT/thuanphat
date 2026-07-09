<?php 
	include_once("header.php");	
		global $lable,$db,$lang;
		$username=getSession("username");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="../user_login/";	
		if(!$username){
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}
		
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		$name=getMemberNameID($username,"name");
		$mobile=getMemberNameID($username,"mobile");
		$userid=getMemberNameID($username,"id");	
		
		$giadvdt=getParam("giadvdt");
		$loai=getParam("loai");
		$giatri=getParam("giatri");
	
		
		$arr=array(".","!","~","@","#","$","%","^","&","*","(",")","-","=","+","|","\\","/","?",",","'");
		$giatri=str_replace($arr, "", $giatri);
		
		//$tong=getParam("tong");				
		$today = date("F j, Y, g:i a");
		//if(!$tong){$tong=$giatri/$giadvdt;}
		$ret_page="..".$_SERVER["REQUEST_URI"];
		if($giatri<10000000){
			$a=new msgBox("Giá trị mua tối thiểu phải là 10 triệu!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		
		$tong=$giatri/$giadvdt;
				
		$emailFrom		=$username;
		$nameFrom		=$name;			
		//$emailTo      	= "vnhomestay.com.vn@gmail.com";
		$emailTo      	= getSession("email");		
		$nameTo			= getSession("email");		
		$subject 		= "Đặt mua";					
		$content		=$contents;
		
		//luu data
		$record=array();
		$record["price_old"]=$giatri;
		$record["price"]=$giadvdt;
		$record["model"]=$tong;
		$record["promotion"]=$giatri;
		$record["delivery"]=$tong;
		$record["userid"]=$userid;
		$record["lang"]=$lang;
		$record["ctrl"]='0';
		$record["loai"]=$loai;		
		
		$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);
		$idNew=$db->Insert_ID();
		if($loai==0){
		$mahd="TSTT-".$idNew;
		$sql="UPDATE sys_userorder SET name='".$mahd."' WHERE id=$idNew";	
		$db->Execute($sql);	
		$sotktt="8883686";	
		}else{
		$mahd="TSBV-".$idNew;
		$sql="UPDATE sys_userorder SET name='".$mahd."' WHERE id=$idNew";		
		$db->Execute($sql);	
		$sotktt="8883681";	
		}
		$contents="<p style=\"font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">THÔNG TIN ĐẶT MUA</p>";
		$contents.="<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" bordercolor=\"#f3f3f3\" style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">
		  <tr>
			<td colspan=\"2\">".$today."</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin người mua</strong></td>
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
			<td colspan=\"2\"><strong>Thông tin giao dịch</strong></td>
		  </tr>	
		  <tr>
			<td>Giá trị đăng ký mua:</td>
			<td>".number_format($giatri, 0, '.', ',')." VNĐ</td>
		  </tr>
		   <tr>
			<td>Gía ĐVDT ngày giao dịch:</td>
			<td>".number_format($giadvdt, 0, '.', ',')." VNĐ</td>
		  </tr>
		   <tr>
			<td>Số lượng ĐVĐT đăng ký mua:</td>
			<td>".number_format($tong, 0, '.', ',')."</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Quý khách chuyển khoản cho chúng tôi theo thông tin dưới để hoàn tất việc đặt mua</strong></td>
		  </tr>	
		  <tr>
			<td>Tổng giá trị thanh toán:</td>
			<td>".number_format($giatri, 0, '.', ',')." VNĐ</td>
		  </tr>
		  <tr>
			<td>Tên chủ tài khoản:</td>
			<td>Công ty cổ phần chứng khoán Tân Việt</td>
		  </tr>
		  <tr>
			<td>Tại Ngân hàng:</td>
			<td>Vietcombank - Hội sở chính - STK: 0011001954698</td>
		  </tr>
		  <tr>
			<td></td>
			<td>BIDV - Chi nhánh Ba Đình - STK: 12610000161365</td>
		  </tr>
		  <tr>
			<td></td>
			<td>MBB - Chi nhánh Hoàn Kiếm - STK: 0571102713009</td>
		  </tr>
		  
		  <tr>
			<td>Nội dung:</td>
			<td>".$name." ".$mahd." nop tien vao tai khoan ".$sotktt." cua CTCP Dau tu phat trien Thach Sanh</td>
		  </tr>
		  <tr>
			<td colspan=\"2\" align=\"center\">Quý khách vui lòng chuyển tiền trước 15h00 hàng ngày. Sau 15h00, giá ĐVĐT sẽ được tính theo giá cập nhật của phiên giao dịch ngày hôm đó. Số lượng ĐVĐT được điều chỉnh tương ứng với mức giá cập nhật.</td>
		  </tr>
		</table>";	
	
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML.=$contents;
		$HTML.="</span>";	
		
		$HTML2="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
		$HTML2.="Thưa quí khách,<br>TSI xin cảm ơn quí khách đã quan tâm đến dịch vụ của chúng tôi. Chúng tôi đã nhận được yêu cầu đặt mua của quí khách và sẽ liên hệ lại với quí khách trong thời gian sớm nhất.<br />
--------------------------------<br />";
		$HTML2.="</span>";
		$HTML2.=$HTML;	
		
		$loai=getParam("loai");
		if($loai=='0'){
			$ret_page=_DOMAIN_ROOT_URL."/user_buy_sell/";	
		}else{
			$ret_page=_DOMAIN_ROOT_URL."/user_buy_sell456/";	
		}		
		//$ret_page="..".$_SERVER["REQUEST_URI"];
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);			
			$a=new msgBox("Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.","OKOnly", "Message", array($ret_page), 5);			
			$a->showMsg();
			//echo '<div style="padding-top:10px">'.$contents.'</div><div style="padding-top:10px;" class="title" align="center">Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"><a href="'.$ret_page.'" class="title">Click vào đây để theo dõi trạng thái của lệnh</a></div>';
		}else{
			$a=new msgBox("Có lỗi sảy ra, xin cấu hình lại mail trên sever","OKOnly", "Message", array($ret_page), 5);			
			$a->showMsg();
			//echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		//<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		//</div>";
		}
		
include_once("footer.php");
?>