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
		$cmt=getMemberNameID($username,"cmt");
		$tknh=getMemberNameID($username,"tknh");
	
		$id=getParam("id");
		$soluongban=getParam("soluongban");
		$arr=array(".","!","~","@","#","$","%","^","&","*","(",")","-","=","+","|","\\","/","?",",","'");
		$soluongban=str_replace($arr, "", $soluongban);
		
		//$soluongban = str_replace(".", "", $soluongban);
		
		$soluong=getParam("soluong");
		$conlai=$soluong-$soluongban;
		$ret_page="..".$_SERVER["REQUEST_URI"];
		if($conlai<0){
			$a=new msgBox("Số lượng ĐVĐT muốn bán phải nhỏ hơn số lượng ĐVĐT của hợp đồng!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
		$loai=getParam("loai");
						
		$today = date("F j, Y, g:i a");
		
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sql.=" FROM sys_userorder";
		$sql.=" WHERE (sys_userorder.id='$id')";		
		$rs=$db->Execute($sql);
		
		$contents="<p style=\"font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">THÔNG TIN ĐẶT BÁN</p>";
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
			<td>".number_format($rs->fields("price"), 0, '.', ',')."</td>
		  </tr>
		   <tr>
			<td>Tổng giá trị:</td>
			<td>".number_format($rs->fields("price_old"), 0, '.', ',')."</td>
		  </tr>
		  <tr>
			<td colspan=\"2\"><strong>Thông tin rút vốn</strong></td>
		  </tr>	
		   <tr>
			<td style=\"color:#FF0000\" ><strong>Số lượng ĐVĐT muốn bán:</strong></td>
			<td style=\"color:#FF0000\"><strong>".number_format($soluongban, 0, '.', ',')."</strong></td>
		  </tr>
		  <tr>
			<td colspan=\"2\">
					<li>Giá ĐVĐT rút vốn là giá đóng cửa (sau 15h30) ngày thứ 5 hàng tuần</li>
					<li>Sau khi lệnh bán được xác nhận, TSI sẽ chuyển tiền vào tài khoản NĐT đã đăng ký vào ngày thứ 6 của tuần đó</li>
			</td>
		  </tr>	
		   <tr>
			<td colspan=\"2\">
				<strong>
					Sau 15h30 ngày thứ 5 TSI sẽ cập nhật giá ĐVĐT, NĐT hãy truy cập vào tài khoản để xác nhận lệnh bán trước 10h ngày thứ 6 (Sau thời gian đó nếu lệnh bán chưa được xác nhận thì sẽ tự hủy).
				</strong>
			</td>
		  </tr>	
		  
		</table>";	
					
		$emailFrom		=$username;
		$nameFrom		=$name;			
		//$emailTo      	= "duongmn.ict@gmail.com";
		$emailTo      	= getSession("email");			
		$nameTo			= getSession("email");		
		$subject 		= "Đặt bán";					
		$content		=$contents;
		
		//luu data
		$record=array();
		$record["name"]="HĐ".$idNew;
		$record["model"]=$soluongban;
		$record["userid"]=$userid;
		$record["lang"]=$lang;
		$record["ctrl"]='0';
		$record["tinh_trang"]='1';
		$record["loai"]=$loai;
		$record["hdban"]=$rs->fields("id");	
		
		
		$sql = "SELECT * FROM sys_userorder WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);		
		$return=$db->Execute($sql);
		$idNew=$db->Insert_ID();
		if($loai==0){
		$sql="UPDATE sys_userorder SET name='RUTVON-TSTT-".$id."' WHERE  id=$idNew";		
		$db->Execute($sql);		
		}else{
		$sql="UPDATE sys_userorder SET name='RUTVON-TSBV-".$id."' WHERE  id=$idNew";		
		$db->Execute($sql);		
		}
		//cap nhat lai so luong hop dong ban
		$sql="UPDATE sys_userorder SET model='$conlai', `product_in`=`product_in`+$soluongban WHERE id=$id";
			
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
		
		if($loai==0){
				
			$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
			if($mail==1){
				$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
				echo '<div style="padding-top:10px">'.$content.'</div><div style="padding-top:10px" class="title" align="center">Yêu cầu đặt bán của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện xác nhận yêu cầu.</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"><a href="'.$ret_page.'" class="title">Click vào đây để theo dõi trạng thái của lệnh</a></div>';
			}else{
				echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
			<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
			</div>";
			}
		}else{
			echo '<div style="padding-top:10px" class="title" align="center">Sau khi đặt bán, NĐT hãy xác nhận lệnh bán trong khoảng thời gian kể từ khi đặt bán đến 10h sáng ngày làm việc kế tiếp (Sau thời gian đó nếu lệnh bán chưa được xác nhận thì sẽ tự hủy).</div><div style="padding-top:10px; padding-bottom:10px" class="title" align="center"><a href="'.$ret_page.'" class="title">Click vào đây để theo dõi trạng thái của lệnh</a></div>';
		}
		
include_once("footer.php");
?>