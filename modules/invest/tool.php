<?php
// gui mail
//$From: email nguoi ngui
// $FromName: ten nguoi gui
//$To			: email nguoi nhan
//$ToName		: ten nguoi nhan
//$Subject		: Tieu de
//$Text			: noi dung la text
//$Html			: Noi dung la HTML
//$AttmFiles	: mamg danh sach cac file gui kem theo
	
function SendMail2($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles){
	$OB="----=_OuterBoundary_000";
	$IB="----=_InnerBoundery_001";
	$Html=$Html?$Html:preg_replace("/\n/","{br}",$Text) 
	 or die("neither text nor html part present.");
	$Text=$Text?$Text:"Sorry, but you need an html mailer to read this mail.";
	$From or die("sender address missing");
	$To or die("recipient address missing");
	
	$headers ="MIME-Version: 1.0\r\n"; 
	$headers.="From: ".$FromName." <".$From.">\n"; 
	$headers.="To: ".$ToName." <".$To.">\n"; 
	$headers.="Reply-To: ".$FromName." <".$From.">\n"; 
	$headers.="X-Priority: 1\n"; 
	$headers.="X-MSMail-Priority: High\n"; 
	$headers.="X-Mailer: My PHP Mailer\n"; 
	$headers.="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\n";
	//Messages start with text/html alternatives in OB
	$Msg ="This is a multi-part message in MIME format.\n";
	$Msg.="\n--".$OB."\n";
	$Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";
	//plaintext section 
	$Msg.="\n--".$IB."\n";
	$Msg.="Content-Type: text/plain;\n\tcharset=\"UTF-8\"\n";
	$Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
	// plaintext goes here
	$Msg.=$Text."\n\n";
	// html section 
	$Msg.="\n--".$IB."\n";
	$Msg.="Content-Type: text/html;\n\tcharset=\"UTF-8\"\n";
	$Msg.="Content-Transfer-Encoding: base64\n\n";
	// html goes here 
	$Msg.=chunk_split(base64_encode($Html))."\n\n";
	// end of IB
	$Msg.="\n--".$IB."--\n";
	// attachments file
	if($AttmFiles){
	 foreach($AttmFiles as $AttmFile){
	  $patharray = explode ("/", $AttmFile); 
	  $FileName=$patharray[count($patharray)-1];
	  $Msg.= "\n--".$OB."\n";
	  $Msg.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
	  $Msg.="Content-Transfer-Encoding: base64\n";
	  $Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";
	
	  //file goes here
	  $fd=fopen ($AttmFile, "r");
	  $FileContent=fread($fd,filesize($AttmFile));
	  fclose ($fd);
	  $FileContent=chunk_split(base64_encode($FileContent));
	  $Msg.=$FileContent;
	  $Msg.="\n\n";
	 }
	}
	
	//message ends
	$Msg.="\n--".$OB."--\n";
	mail($To,$Subject,$Msg,$headers); 
	return true;
	//syslog(LOG_INFO,"Mail: Message sent to $ToName <$To>");
}
?>