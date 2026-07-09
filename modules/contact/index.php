<?php
	switch($op){		
		case "sendMail"		: getInfoContact();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");

		global $themeName, $smarty, $lable, $db;
		$idF=getparamFID(getParam(idF),false);

		//$des=getFunctionNameID($fid,"des");
		//$img1=getFunctionNameID($fid,"img1");
		$topicName=getFunctionNameID($fid);
		$smarty->assign('des',getFunctionNameID($idF,"des"));

		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$sql="SELECT * FROM sys_config WHERE (name='des') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$address=$rs->fields('value');
		
		$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$support=$rs->fields('value');
	
		$smarty->assign('name',getFunctionNameID($idF,"name"));
		$smarty->assign('theme',$themeName);
		$smarty->assign('topicName',$topicName);
		$smarty->assign('address',$address);
		$smarty->assign('support',$support);

		
		$smarty->assign('Name',$lable->_("Name"));
		$smarty->assign('Mobile',$lable->_("Mobile"));
		$smarty->assign('Subject',$lable->_("Subject"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('Sendmail',$lable->_("Send mail"));
		$smarty->assign('Contact',$lable->_("Contact"));
		$smarty->assign('Address',$lable->_("Address"));
		$smarty->assign('Security_code',$lable->_("Security code"));		
		$smarty->assign('NoteContact',$lable->_("To contact the company please please fill out the contact form below"));


		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/contact.tpl','contact_'.$themeName);	
		
		include_once("footer.php");
	}
	//
	function getInfoContact(){
		include_once("header.php");		
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		
		global $lable,$db,$lang;
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");
		$mobile=getParamPost("mobile");
		$email=getParamPost("email");
		$subject=getParamPost("subject");
		$content=getParamPost("content");	
		$filePDF=getParam("filePDF");
		
		
		
		$record=array();
		$record["name"]=$name;
		$record["mobile"]=$mobile;
		$record["email"]=$email;
		$record["subject"]=$subject;
		$record["question"]=$content;
		$record["lang"]=$lang;		
		
		$sql = "SELECT * FROM sys_faq WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);
		$return=$db->Execute($sql);
		
		
		$contents = "".$name."<br>";
		$contents .= "".$mobile."<br>";
		$contents .= "".$email."<br>";
		$contents .=$content;		
		
		
		$emailFrom		=$email;
		$nameFrom		=$name;			
		$emailTo      	= getSession("email");			
		$nameTo			= "Muachung.land";			
		$subject 		= $subject;					
		$content		=$contents;
		
		$TEXT="";
		$HTML="<span>";
		$HTML.=$content;
		$HTML.="</span>";
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo "<div style=\"padding-top:100px; padding-bottom:200px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>Cám ơn bạn đã đăng ký tham gia. Chúng tôi sẽ liên hệ lại với bạn sớm nhất</strong>
		</div>";	
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
	include_once("footer.php");
}
?>