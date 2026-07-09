<?php
	switch ($op){		
		
		default 			:	mainShow(); break;
	}
	//
function mainShow(){
	include_once "header.php";
	include('phpmailer/class.smtp.php');
	include "phpmailer/class.phpmailer.php"; 
	include("phpmailer/config.php");
	
	include_once(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		
	
	if(valid_email($_POST['email']) && checkUnique($_POST['email']))
	{
		
		global $lable,$db;
		
		$random_key = random_string('alnum', 32);
		$email=$_POST['email'];
		
		$sql = "INSERT INTO subscribers (email,rand_key) VALUES ('$email','$random_key')";				
		$return=$db->Execute($sql);
		$idNew=$db->Insert_ID();
		$message = "Cảm ơn bạn đã đăng ký nhận mail tại"._DOMAIN_ROOT_URL.". Để hoàn tất việc đăng ký hãy kiểm tra lại Email và click vào link:"._DOMAIN_ROOT_URL."/?m=newsletter&f=confirm&ID=".$idNew."&key=".$random_key."<br><br>";
		
		//
		$emailFrom		=getSession("email");
		$nameFrom		=_DOMAIN_ROOT_URL;
		$emailTo      	= $email;		
		$nameTo			= _DOMAIN_ROOT_URL.": Đăng ký nhận mail";			
		$subject 		= _DOMAIN_ROOT_URL.": Đăng ký nhận mail";				
		$content		=$message;
	
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
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
		//sendMail($email,$subject,getSession("email"),$name,$subject,$content,$fileAttachment="");
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1)
		//if(sendMail($emailFrom,$subject,emailTo,$nameTo,$subject,$HTML,$ATTM))
		{
			//echo "Cảm ơn bạn đã đăng ký nhận mail tại '"._DOMAIN_ROOT_URL."'. Để hoàn tất việc đăng ký hãy kiểm tra lại Email và click vào link mà chúng tôi vừa gửi.";
			$ret_page="/";
			$a=new msgBox("Cảm ơn bạn đã đăng ký nhận mail","OKOnly", "Message", array($ret_page), 5);			
			$a->showMsg();
		}
		else {
			//echo "Email xac nhan chua duoc goi di. Co the server cua ban chua cho phep goi mail. Hay lien he nguoi quan ly hosting de khac phuc su co ham mail()";
			$ret_page="/";
			$a=new msgBox("error","OKOnly", "Message", array($ret_page), 5);			
			$a->showMsg();
		}
	}
	elseif (!checkUnique($_POST['email']))
	{
	//	echo 'Email đã được đăng ký rồi.';
		$ret_page="/";
		$a=new msgBox("Email đã được đăng ký rồi","OKOnly", "Message", array($ret_page), 5);			
		$a->showMsg();
		
	}
	else {
		//echo 'Email bạn nhập vào chưa chính xác';
		$ret_page="/";
		$a=new msgBox("Email bạn nhập vào chưa chính xác!","OKOnly", "Message", array($ret_page), 5);			
		$a->showMsg();
	}
	
	
	include_once "footer.php";	
}	

// dang ky nhan mail
function checkUnique($compared){
	global $db;				
	$sql="SELECT * FROM subscribers WHERE email='$compared'";
	$rs=$db->Execute($sql);
	$email=$rs->fields("email");
	if(!$email){
		return TRUE;
	}else{
		return FALSE;
	}	
}

function valid_email($str)
{
	return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
function random_string($type = 'alnum', $len = 8)
{
	switch($type)
	{
		case 'alnum'	:
		case 'numeric'	:
		case 'nozero'	:

				switch ($type)
				{
					case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric'	:	$pool = '0123456789';
						break;
					case 'nozero'	:	$pool = '123456789';
						break;
				}

				$str = '';
				for ($i=0; $i < $len; $i++)
				{
					$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
				return $str;
		  break;
		case 'unique' : return md5(uniqid(mt_rand()));
		  break;
	}
}

function numeric($str)
{
	return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
}

function alpha_numeric($str)
{
	return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
}
?>