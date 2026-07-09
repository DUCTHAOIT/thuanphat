<?php 
	include_once("header.php");	
		global $lable,$db,$lang;
		$username=getSession("username");
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="../";	
		if(!$username){
			$a=new msgBox("false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();	
		}
				
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		?>
        <script>
			if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
			}
		</script>
        <?php
		
		$id=getParam("id");
		$phihoancoc=getParam("phihoancoc");
		$conlai=getParam("conlai");
		
		//$soluongban = str_replace(".", "", $soluongban);
		
		if(!$id) return;	
		$username=getSession("username");
		$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, sys_gopvon.name as nameproduct, sys_gopvon.id as proid";
		$sql.=" FROM user, sys_userorder, sys_gopvon";
		$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id='$id') AND (sys_gopvon.id = sys_userorder.catID)";
		$rs=$db->Execute($sql);
		
		$datcoc=$rs->fields("cklan1")+$rs->fields("cklan2");
		$conlai=$datcoc*(100-$rs->fields("phihoancoc"))/100;
		

		$contents="<p class=\"title\">THÔNG TIN HOÀN CỌC</p>";
		$contents.='<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Số HĐ: </td>
						<td align="left" style="padding-left:10px;" width="50%">GV-'.$rs->fields("id").'</td>
					  </tr>
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Ngày HĐ: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.$rs->fields("date_create").'</td>
					  </tr>
					  
					   <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Dự án: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.$rs->fields("nameproduct").'</td>
					  </tr>
					
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Số cổ phần: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.number_format($rs->fields("soxuatdautu"), 0, '.', ',').'</td>
					  </tr>
					   <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Số tiền / 1 cổ phần: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.number_format($rs->fields("sotienmotxuat"), 0, '.', ',').'đ</td>
					  </tr>
					 
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Tổng giá trị vốn góp: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.number_format($rs->fields("tongtien"), 0, '.', ',').'</td>
					  </tr>
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Đã đặt cọc: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.number_format($datcoc, 0, '.', ',').'</td>
					  </tr>
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Phí hoàn cọc: </td>
						<td align="left" style="padding-left:10px;" width="50%">'.number_format($rs->fields("phihoancoc"), 0, '.', ',').'%</td>
					  </tr>
					  <tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap" class="title">Số tiền thực nhận: </td>
						<td  class="title" align="left" style="padding-left:10px;" width="50%">'.number_format($conlai, 0, '.', ',').'</td>
					  </tr>
					  <tr>
						<td colspan="2">
						<p>Quý khách hãy nhắn tin SMS tới từ số điện thoại đăng ký tài khoản tới hotline của chúng tôi với nội dung sau để xác thực yêu cầu hoàn cọc:<br><strong>Hoan coc GV-'.$rs->fields("id").'</strong> <br> Sau  1 ngày làm việc nếu yêu cầu hoàn cọc chưa được xác thực thì sẽ tự hủy.</p>
						</td>
					  </tr>
				</table>';	
							
				$emailFrom		=$username;
				$nameFrom		=$name;			
				//$emailTo      	= "duongmn.ict@gmail.com";
				$emailTo      	= getSession("email");			
				$nameTo			= getSession("email");		
				$subject 		= "Yêu cầu hoàn cọc";					
				$content		=$contents;
				
				//luu data
				
				//cap nhat lai so luong hop dong ban
				$sql="UPDATE sys_userorder SET tienhoancoc='$conlai', `phihoancocxacthuc`=`phihoancoc` WHERE id=$id";
					
				$db->Execute($sql);	
		
		//		
		$TEXT="";
		$HTML="<span>";
		$HTML.=$content;
		$HTML.="</span>";	
		
		$HTML2="<span>";
		$HTML2.="Thưa quí khách,<br>Chúng tôi đã nhận được yêu cầu của quí khách và sẽ liên hệ lại với quí khách trong thời gian sớm nhất.<br />
--------------------------------<br />";
		$HTML2.="</span>";
		$HTML2.=$HTML;	
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			$mail = sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo '<div class="container" style="padding:10px" ><div style="padding-top:10px"  class="text-center">'.$content.'</div><div style="padding-top:10px" class="title" align="center">Yêu cầu hoàn cọc của quý khách đã được thiết lập, xin quý khách kiểm tra mail và thực hiện xác nhận yêu cầu.</div></div>';
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		
include_once("footer.php");
?>