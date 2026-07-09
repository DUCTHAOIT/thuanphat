<?php 
	include_once("header.php");	
		global $lable,$db,$lang;
		$username=getSession("username");
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		if(!$username){
			
			$ret_page="../../";	
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}
		
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		$name=getMemberNameID($username,"name");
		$mobile=getMemberNameID($username,"mobile");
		$userid=getMemberNameID($username,"id");	
		$loaitv=getParam("loaitv");
		$catID=getParam("catID");
		$giatri=getParam("giatri");
		$giadvdt=getParam("giadvdt");
		$sotienmotxuat=getParam("sotienmotxuat");
		$giaidoan=getParam("giaidoan");
		
		$chietkhau=$sotienmotxuat-$giadvdt;
		$tong=$giadvdt*$giatri;
	
		
		$arr=array(".","!","~","@","#","$","%","^","&","*","(",")","-","=","+","|","\\","/","?",",","'");
		$giatri=str_replace($arr, "", $giatri);
		
		//$tong=getParam("tong");				
		$today = date("F j, Y, g:i a");
		//if(!$tong){$tong=$giatri/$giadvdt;}
		$ret_page="..".$_SERVER["REQUEST_URI"];
		if($giatri<1){
			$a=new msgBox("Giá trị mua tối thiểu phải là 1 suất!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		
		
				
		$emailFrom		=$username;
		$nameFrom		=$name;			
		//$emailTo      	= "vnhomestay.com.vn@gmail.com";
		$emailTo      	= getSession("email");		
		$nameTo			= getSession("email");		
		$subject 		= "MUA CHUNG - Muachung.land";					
		$content		=$contents;
		
		//luu data
		$record=array();
		$record["catID"]=$catID;
		$record["userid"]=$userid;
		$record["name"]=$name;
		$record["email"]=$username;
		$record["mobile"]=$mobile;
		$record["loaitv"]=$loaitv;
		
		$record["soxuatdautu"]=$giatri;
		$record["sotienmotxuat"]=$sotienmotxuat;
		
		$record["chietkhau"]=$chietkhau;
		$record["tongtien"]=$tong;
		$record["ctrl"]='0';
		$record["giaidoan"]=$giaidoan;		
		
		$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);
		$idNew=$db->Insert_ID();
		
		
		// khong gui mail
		/*$ret_page=_DOMAIN_ROOT_URL;	
		$a=new msgBox("Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách thực hiện chuyển khoản theo thông tin hiển thị.","OKOnly", "Message", array($ret_page), 3);			
		$a->showMsg();
		*/
		////////
		
		$contents="<p class=\"topic\">THÔNG TIN ĐẶT MUA</p>";
		$contents.="<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" bordercolor=\"#f3f3f3\" >
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
			<td>Số suất đăng ký mua:</td>
			<td>".$giatri."</td>
		  </tr>
		   <tr>
			<td>Số tiền / 1 suất:</td>
			<td>".number_format($sotienmotxuat, 0, '.', ',')."đ</td>
		  </tr>
		   <tr>
			<td>Chiết khấu:</td>
			<td>".number_format($chietkhau, 0, '.', ',')."đ</td>
		  </tr>
		   <tr>
			<td>Tổng giá trị thanh toán:</td>
			<td>".number_format($tong, 0, '.', ',')."đ</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Quý khách chuyển khoản cho chúng tôi theo thông tin dưới để hoàn tất việc đặt mua</strong></td>
		  </tr>	
		  <tr>
			<td>Tên chủ tài khoản:</td>
			<td>No One</td>
		  </tr>
		  <tr>
			<td>Nội dung:</td>
			<td>".vn_to_str($name)." nop tien hop dong MC-Muachung.land".$idNew."</td>
		  </tr>
		  <tr>
			<td colspan=\"2\" align=\"center\">
			<li>Quý khách chuyển khoản (hoặc cung cấp sao kê đã chuyển khoản thành công) trước 2 ngày làm việc từ thời điểm đăng ký mua.</li>
			<li>Sau thời điểm này, các hợp đồng mà Muachung.land chưa nhận được tiền (hoặc nhận được sao kê đã chuyển khoản thành công) sẽ hủy hợp đồng đặt mua của quý khách.</li>
			</td>
		  </tr>
		</table>";	
	
		
		$TEXT="";
		$HTML.=$contents;	
		
		$HTML2="<div class=\"container\" style=\"padding:10px\" >";
		$HTML2.="Thưa quí khách,<br>Muachung.land xin cảm ơn quí khách đã quan tâm đến dịch vụ của chúng tôi. Chúng tôi đã nhận được yêu cầu đặt mua của quí khách và sẽ liên hệ lại với quí khách trong thời gian sớm nhất.<br />
--------------------------------<br />";
		$HTML2.=$HTML;	
		$HTML2.="</div>";
			
		$ret_page=_DOMAIN_ROOT_URL;
		if($return){
			//echo '<div style="padding-top:100px">'.$contents.'</div><div style="padding-top:10px;" class="title" align="center">Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"></div>';
		}
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);			
			//$a=new msgBox("Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.","OKOnly", "Message", array($ret_page), 5);			
			//$a->showMsg();
			//echo $contents;
			//echo '<div style="padding-top:10px">'.$contents.'</div><div style="padding-top:10px;" class="title" align="center">Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"><a href="'.$ret_page.'" class="title">Click vào đây để theo dõi trạng thái của lệnh</a></div>';
			echo '<div class=\"container\" style=\"padding:10px\" >
<div class="container" align="center">'.$contents.'<div style="padding-top:10px;" class="title" align="center">Yêu cầu đặt mua của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện chuyển khoản theo thông tin trong mail.</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"></div></div></div></div>';
		}else{
			$a=new msgBox("Có lỗi sảy ra, xin cấu hình lại mail trên sever","OKOnly", "Message", array($ret_page), 5);			
			$a->showMsg();
			//echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		//<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		//</div>";
		}
		
include_once("footer.php");
?>