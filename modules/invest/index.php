<?php
	switch($op){		
		case "sendMail"		: getInfoinvest();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");		
		global $themeName, $smarty, $lable, $db;
		$idF=getparamFID(getParam(idF),false);	
		$topicName=getFunctionNameID($idF);
		
		//$des=getFunctionNameID($fid,"des");
		//$img1=getFunctionNameID($fid,"img1");
		$topicName=getFunctionNameID($fid);
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		
		$sql="SELECT * FROM sys_config WHERE (name='des') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$address=$rs->fields('value');
		
		$sql="SELECT * FROM sys_config WHERE (name='support') AND (lang='$lang')";
		$rs=$db->Execute($sql);		
		$support=$rs->fields('value');
		
		$smarty->assign('img1',$topicName["img1"]);
		$smarty->assign('des',$topicName["des"]);	
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
		$smarty->assign('invest',$lable->_("invest"));
		$smarty->assign('Address',$lable->_("Address"));
		$smarty->assign('Security_code',$lable->_("Security code"));		
		$smarty->assign('Noteinvest',$lable->_("To invest the company please please fill out the invest form below"));
		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/invest.tpl','invest_'.$themeName);	
		
		include_once("footer.php");
	}
	//
	function getInfoinvest(){
		include_once("header.php");		
		include_once("modules/invest/tool.php");
		
		global $lable,$db,$lang;
		if(!$lang) $lang="vn";
		
		$txtCaptcha=getParamPost("txtCaptcha");
		if($txtCaptcha<>$_SESSION["security_code"]){
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
				<strong>".$lable->_("Mã an toàn sai")." </strong></div>";	
			
		}else{
		$name=getParamPost("name");
		$mobile=getParamPost("mobile");
		$email=getParamPost("email");
		$subject=getParamPost("subject");
		$select=getParamPost("select");
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
		$contents .= "".$select."<br>";
		$contents .= "".$subject."<br>";
		$contents .=$content;		
		
		
		$emailFrom		=$email;
		$nameFrom		=$name;			
		$emailTo      	= getSession("email");		
		$nameTo			= getSession("email");			
		$subject 		= $subject;					
		$content		=$contents;
		
		$TEXT="";
		$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #154491;\">";
		$HTML.=$content;
		$HTML.="</span>";
		//danh sach các file kem theo
		//$ATTM=array("docs/analyse.doc",
		//		    "docs/database.xls");
		//khong can gui file kem theo
		$ATTM=array("temp/".$filePDF."");
		
		
		if(SendMail2($emailFrom,$nameFrom, $emailTo,$nameTo, $subject, $TEXT,$HTML,$ATTM)){
		
		SendMail2($emailTo,$nameTo, $emailFrom,$nameFrom, $subject, $TEXT,$HTML,$ATTM);
		//$resurn=sendMail($email,$subject,getSession("email"),$name,$subject,$content,$fileAttachment="");
		//$resurn=sendMail(getSession("email"),$subject,$email,$name,$subject,$content,$fileAttachment="");
		
		echo "<div style=\"padding-top:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Thank you for contacting us.  We will study your email and revert.")." </strong> <a href=\"/\" class=\"title\">".$lable->_("Click here to return to home page.")."</a>.
		</div>";		
		}else{
		echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";	
		}
		}
		include_once("footer.php");
	}
?>