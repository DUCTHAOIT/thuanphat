<?php	
	include_once("../../modules/contact/tool.php");
	require_once('../../modules/newsletter/db.php');
	require('../../modules/newsletter/functions.php');
	
	if(!empty($_POST['email']) && valid_email($_POST['email']) && checkUnique('email', $_POST['email']))
	{
		
		$random_key = random_string('alnum', 32);
		$insert = mysql_query('INSERT INTO `subscribers` (`email`, `rand_key`)
					VALUES ("'.mysql_real_escape_string($_POST['email']).'",
					"'.$random_key.'")') or die(mysql_error());

		$to = $_POST['email'];
		$headers = 	'From: "'.getSession("email").'"'. "\r\n" .
				'Reply-To: "'.getSession("email").'"' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
		$subject = "Xác nhận đăng ký nhận mail";
		$message = "Xin chào! cảm ơn bạn đã đăng ký nhận mail từ website "._DOMAIN_ROOT_URL.". Bạn hãy click vào link bên dưới để xác nhận việc đăng ký:"._DOMAIN_ROOT_URL."/modules/newsletter/confirm.php?ID=".mysql_insert_id()."&key=".$random_key.".<br>";
		
		
		//
		$emailFrom		=getSession("email");
		$nameFrom		="Forcia";			
		$emailTo      	= $to;		
		$nameTo			= "Đăng ký nhận tin";			
		$subject 		= $subject;					
		$content		=$message;
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #154491;\">";
		$HTML.=$content;
		$HTML.="</span>";
		//danh sach các file kem theo
		//$ATTM=array("docs/analyse.doc",
		//		    "docs/database.xls");
		//khong can gui file kem theo
		$ATTM=array();
		//
		
		
	//	SendMail("dpfamily.net@gmail.com","duong@company.vn","Details of Booking Form","Content Testing");	
		
		
		//if(mail($to, $subject, $message, $headers))
		if(SendMail2($emailFrom,$nameFrom, $emailTo,$nameTo, $subject, $TEXT,$HTML,$ATTM))
		{
			echo "Cảm ơn bạn đã đăng ký nhận mail tại '"._DOMAIN_ROOT_URL."'. Để hoàn tất việc đăng ký hãy kiểm tra lại Email và click vào link mà chúng tôi vừa gửi.";
		}
		else {
			echo "Email xac nhan chua duoc goi di. Co the server cua ban chua cho phep goi mail. Hay lien he nguoi quan ly hosting de khac phuc su co ham mail()";
		}
	}
	elseif (!checkUnique('email', $_POST['email']))
	{
		echo 'Email đã được đăng ký rồi.';
	}
	else {
		echo 'Email bạn nhập vào chưa chính xác';
	}
?>