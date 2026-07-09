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
		
		//$username=getSession("username");
		$name=getMemberNameID($username,"name");
		$mobile=getMemberNameID($username,"mobile");
		$userid=getMemberNameID($username,"id");
		$cmt=getMemberNameID($username,"cmt");
		$tknh=getMemberNameID($username,"tknh");
		
		$nganhangtknh=getMemberNameID($username,"nganhangtknh");
		$chinhanhtknh=getMemberNameID($username,"chinhanhtknh");
	
		$id=getParam("id");
		$idrut=getParam("idrut");
		
		$giadvdtchot=getParam("giadvdtchot");
		$soluongban=getParam("soluongban");
		$tongbanhopdong=getParam("tongbanhopdong");
		$tongban=getParam("tongban");
		$lailo=getParam("lailo");
		$phihoptac=getParam("phihoptac");
		$phantramphihoptac=getParam("phantramphihoptac");
		$tncn=getParam("tncn");
		$phantramtncn=getParam("phantramtncn");
		$phiruttruochan=getParam("phiruttruochan");
		$phirut=getParam("phirut");
		$phantramphiruttruochan=getParam("phantramphiruttruochan");
		$thucnhan=getParam("thucnhan");
		$hoahongck=getParam("hoahongck");
		$phantramhoahongck=getParam("phantramhoahongck");
		$hoahonggioithieu=getParam("hoahonggioithieu");
		$date_creategiadvdtchot=getParam("date_creategiadvdtchot");
		/*
		if(($lailo/$tongban)<0.1){
			$hoahongck=0;
		}
		if(0.1<= ($lailo/$tongban) && ($lailo/$tongban) <0.5){
			$hoahongck=$lailo*0.025;
			
		}
		if(0.5<=($lailo/$tongban) && ($lailo/$tongban)<1){
			$hoahongck=$lailo*0.03;
		}
		if(1<=($lailo/$tongban)){
			$hoahongck=$lailo*0.04;
		}
		
		$thucnhan=$thucnhan+$hoahongck;
		*/
		
		$today = date("F j, Y, g:i a");
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM sys_userorder";
		$sql.=" WHERE (sys_userorder.id='$idrut')";		
		$rs=$db->Execute($sql);
		
		
		$sqldate="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sqldate.=" FROM sys_userorder";
		$sqldate.=" WHERE (sys_userorder.id='$id')";		
		$rsdate=$db->Execute($sqldate);
		
		$ret_page2="../user_buy_sell/";	
		if($rsdate->fields("trangthai")==2){
			$a=new msgBox("Đã hết thời gian hiệu lực xác thực bán","OKOnly", "Message", array($ret_page2), 2);			
			$a->showMsg();	
		}
		
		if(($rs->fields("delivery")-$rs->fields("model"))>0){	
			$tonggiatri=($rs->fields("model")+$rs->fields("product_in"))*$rs->fields("price");
		}else{
			$tonggiatri=$rs->fields("promotion");
		}
            
    
		
		$contents="<p style=\"font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">XÁC NHẬN ĐẶT BÁN</p>";
		if($phirut){
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
			<td>".$tknh." ".$nganhangtknh." ".$chinhanhtknh."</td>
		  </tr>
		   <tr>
			<td colspan=\"2\"><strong>Thông tin giao dịch</strong></td>
		  </tr>	
		  <tr>
			<td>Hợp đồng muốn rút vốn:</td>
			<td>".$rs->fields("name")."</td>
		  </tr>
		   <tr>
			<td>Ngày mua theo HĐ (1):</td>
			<td>".$rs->fields("date_create")."</td>
		  </tr>
		   <tr>
			<td>Số lượng ĐVĐT (2):</td>
			<td>".number_format(($rs->fields("model")+$soluongban), 0, '.', ',')."</td>
		  </tr>
		   <tr>
			<td>Giá mua ĐVĐT (3):</td>
			<td>".number_format($rs->fields("price"), 0, '.', ',')." VNĐ</td>
		  </tr>
		  
		   <tr>
			<td>Tổng giá trị (4):</td>
			<td>".number_format($tonggiatri, 0, '.', ',')." VNĐ</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin rút vốn</strong></td>
		  </tr>	
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Ngày định giá (5):</strong></td>
			<td style=\"color:#FF0000\"><strong>".$date_creategiadvdtchot."</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Số lượng ĐVĐT đặt bán (6):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($soluongban, 0, '.', ',')."</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Giá bán 1 ĐVĐT (7):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($giadvdtchot, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Tổng giá trị bán (8):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tongbanhopdong, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Phí ứng trước tiền bán (9)=0.3%*(8):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phirut, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Tổng giá trị bán thực tế (10)=(8)-(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tongban, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Lãi/Lỗ (11)=(8)-(6)*(3):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($lailo, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí hợp tác đầu tư theo hợp đồng (12)=".$phantramphihoptac."%*(11):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phihoptac, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Hoa hồng chiết khấu (13)=".$phantramhoahongck."%*(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Hoa hồng giới thiệu (14)=".$phantramhoahongck."%*(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí hợp tác đầu tư TSI thực nhận (15)=(12)-(13)-(14):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phihoptac-$hoahongck-$hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		 
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí rút trước hạn (16)=".$phantramphiruttruochan."%*(8):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phiruttruochan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Lãi lỗ trước thuế (17)=(11)-(12)+(13)-(16):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($lailo+$hoahongck-$phihoptac-$phirut-$phiruttruochan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thuế thu nhập cá nhân (18)=".$phantramtncn."%*(17):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tncn, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thực nhận (=6*3+17-18):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($thucnhan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td colspan=\"2\" align=\"center\">TSI sẽ chuyển tiền vào tài khoản NĐT đã đăng ký vào ngày làm việc kế tiếp sau ngày đặt bán</td>
		  </tr>
		</table>";
		}else{		
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
			<td>".$tknh." ".$nganhangtknh." ".$chinhanhtknh."</td>
		  </tr>
		   <tr>
			<td colspan=\"2\"><strong>Thông tin giao dịch</strong></td>
		  </tr>	
		  <tr>
			<td>Hợp đồng muốn rút vốn:</td>
			<td>".$rs->fields("name")."</td>
		  </tr>
		   <tr>
			<td>Ngày mua theo HĐ (1):</td>
			<td>".$rs->fields("date_create")."</td>
		  </tr>
		   <tr>
			<td>Số lượng ĐVĐT (2):</td>
			<td>".number_format(($rs->fields("model")+$soluongban), 0, '.', ',')."</td>
		  </tr>
		   <tr>
			<td>Giá mua ĐVĐT (3):</td>
			<td>".number_format($rs->fields("price"), 0, '.', ',')." VNĐ</td>
		  </tr>
		   <tr>
			<td>Tổng giá trị (4):</td>
			<td>".number_format($tonggiatri, 0, '.', ',')." VNĐ</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin rút vốn</strong></td>
		  </tr>	
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Ngày định giá (5):</strong></td>
			<td style=\"color:#FF0000\"><strong>".$date_creategiadvdtchot."</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Số lượng ĐVĐT đặt bán (6):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($soluongban, 0, '.', ',')."</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Giá bán 1 ĐVĐT (7):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($giadvdtchot, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Tổng giá trị bán (8):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tongban, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Lãi/Lỗ (9)=(8)-(6)*(3):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($lailo, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí hợp tác đầu tư theo hợp đồng (10)=".$phantramphihoptac."%*(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phihoptac, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Hoa hồng chiết khấu (11)=".$phantramhoahongck."%*(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Hoa hồng giới thiệu (12)=".$phantramhoahongck."%*(9):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí hợp tác đầu tư TSI thực nhận (13)=(10)-(11)-(12):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phihoptac-$hoahongck-$hoahongck, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Phí rút trước hạn (14)=".$phantramphiruttruochan."%*(8):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($phiruttruochan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Lãi lỗ trước thuế (15)=(9)-(10)+(11)-(14):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($lailo-$phihoptac+$hoahongck-$phiruttruochan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thuế thu nhập cá nhân (16)=".$phantramtncn."%*(15):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($tncn, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td style=\"color:#FF0000\" ><strong>Thực nhận (=6*3+15-16):</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($thucnhan, 0, '.', ',')." VNĐ</strong></td>
		  </tr>
		  <tr>
			<td colspan=\"2\" align=\"center\">TSI sẽ chuyển tiền vào tài khoản NĐT đã đăng ký vào ngày thứ 6.</td>
		  </tr>
		</table>";
		
		}	
		
		$usergioithieu=getMemberNameID($username,"gioithieu");
		if($usergioithieu){
			
			$tncngioithieu=$hoahonggioithieu*0.1;
			$thucnhangioithieu=$hoahonggioithieu-$tncngioithieu;
			
			$contentsgioithieu="<p><strong>Kính gửi quý khách hàng ".$usergioithieu."</strong><br>
Cảm ơn Quý khách đã giới thiệu các Nhà đầu tư giao dịch tại Thach Sanh Investment (TSI).<br>
Thach Sanh Investment trân trọng gửi tới Quý khách hàng thông tin hoa hồng giới thiệu của quý khách như sau:</p><p style=\"font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">XÁC NHẬN TẤT TOÁN HỢP ĐỒNG ".$rs->fields("name")." CỦA ".$name."</p>";
			$contentsgioithieu.="<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" bordercolor=\"#f3f3f3\" style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">
			
			   <tr>
				<td colspan=\"2\"><strong>Nội dung</strong></td>
			  </tr>
				
			  <tr>
				<td>Hợp đồng rút vốn:</td>
				<td>".$rs->fields("name")."</td>
			  </tr>
			   <tr>
				<td>Ngày mua theo HĐ (1):</td>
				<td>".$rs->fields("date_create")."</td>
			  </tr>
			  
			   <tr>
				<td>Số lượng ĐVĐT (2):</td>
				<td>".number_format($rs->fields("model"), 0, '.', ',')."</td>
			  </tr>
			   <tr>
				<td>Giá mua ĐVĐT (3):</td>
				<td>".number_format($rs->fields("price"), 0, '.', ',')." VNĐ</td>
			  </tr>
			   <tr>
				<td>Tổng giá trị (4):</td>
				<td>".number_format($rs->fields("price_old"), 0, '.', ',')." VNĐ</td>
			  </tr>
			  <tr>
				<td colspan=\"2\"><strong>Thông tin rút vốn</strong></td>
			  </tr>	
			
			    <tr>
				<td>Ngày định giá (5):</td>
				<td><strong>".$date_creategiadvdtchot."</strong></td>
			  </tr>
			   <tr>
				<td >Số lượng ĐVĐT đặt bán (6):</td>
				<td ><strong>".number_format($soluongban, 0, '.', ',')."</strong></td>
			  </tr>
			  <tr>
				<td  >Giá bán 1 ĐVĐT (7)</td>
				<td ><strong>".number_format($giadvdtchot, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			  <tr>
				<td  >Tổng giá trị bán (8)</td>
				<td ><strong>".number_format($tongban, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			  <tr>
				<td  >Lãi/Lỗ (9)=(8)-(6)*(3)</td>
				<td ><strong>".number_format($lailo, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			  <tr>
				<td style=\"color:#FF0000\" ><strong>Hoa hồng giới thiệu (10)=".$phantramhoahongck."%*(9):</strong></td>
				<td style=\"color:#FF0000\"><strong>".number_format($hoahonggioithieu, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			  <tr>
				<td style=\"color:#FF0000\" ><strong>Thuế thu nhập cá nhân (11)=10%*(10)</strong></td>
				<td style=\"color:#FF0000\"><strong>".number_format($tncngioithieu, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			  <tr>
				<td style=\"color:#FF0000\" ><strong>Thực nhận (=10-11)</strong></td>
				<td style=\"color:#FF0000\"><strong>".number_format($thucnhangioithieu, 0, '.', ',')." VNĐ</strong></td>
			  </tr>
			</table>";
		}
			
		$emailFrom		=$username;
		$nameFrom		=$name;			
		//$emailTo      	= "duongmn.ict@gmail.com";
		$emailTo      	= getSession("email");			
		$nameTo			= getSession("email");		
		$subject 		= "XÁC NHẬN ĐẶT BÁN";	
		$subjectgioithieu 		= "Thông tin hoa hồng giới thiệu";	
						
		$content		=$contents;
		
		//luu data		
		$sql="UPDATE sys_userorder SET price='".$giadvdtchot."', dategiadvdt='".$date_creategiadvdtchot."' WHERE id=$id";
		//$sql="UPDATE sys_userorder SET price='".$giadvdtchot."' WHERE id=$id";		
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
		$emailTocc=$emailTo;
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			if($usergioithieu){
				$mail = sendMailer($subjectgioithieu, $contentsgioithieu, $usergioithieu, $usergioithieu, $emailTocc, $emailTo, $nameTo);
			}
			echo '<div style="padding-top:10px">'.$content.'</div><div style="padding-top:10px" class="title" align="center">Yêu cầu đặt bán của quý khách đã được thiết lập, cám ơn quý khách đã đồng hành cùng TSI.</div>';
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		
include_once("footer.php");
?>