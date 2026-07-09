<?php
	function arrList(){
		global $db,$lang;
		$sql="SELECT * FROM subscribers";
		$arr=$db->GetAssoc($sql);				
		return $arr;
	}
	//
	function sendNewsletter(){
		
		@include_once("classes/constructSql.class.php");	
		
		global $db;
		
		$content=getParamPost("content");
		$chkdelete=getParamPost("chkdelete");		
		//$id=getParamPost("id");
			$headers = 	'Content-type: text/html; charset=utf-8'. "\r\n" .
			'From: "khuyenmai365ngay@gmail.com"'. "\r\n" .
			'Reply-To: "khuyenmai365ngay@gmail.com"' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
			
			$TEXT="";
			$HTML="<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #154491;\">";
			$HTML.=$content;
			$HTML.="</span>";
			//danh sach các file kem theo
			//$ATTM=array("docs/analyse.doc",
			//		    "docs/database.xls");
			//khong can gui file kem theo
			$ATTM=array();
								
		
			$subject = "khuyenmai365ngay.com";		
			$emailFrom		="khuyenmai365ngay@gmail.com";
			$nameFrom		="khuyenmai365ngay.com";	
			
		if(!$chkdelete){			
			messange("Không gửi được!");
			listNewsletter();
			return;
		}		
						
		foreach($chkdelete as $key=>$value){
					
			$sql="SELECT * FROM subscribers WHERE id = '$value'";
			$rs=$db->Execute($sql);	
			$to=$rs->fields("email");
			$ID=$rs->fields("ID");
			$rand_key=$rs->fields("rand_key");			
			
			if(SendMail2($emailFrom,$nameFrom, $to,$to, $subject, $TEXT,$HTML."<br>Tu choi nhan mail click link:"._DOMAIN_ROOT_URL."/?m=newsletter&f=confirmoff&ID=".$ID."&key=".$rand_key."",$ATTM))
			{
				//echo "Email đã được gửi.";
			}
			else {
				echo "Email xac nhan chua duoc goi di. Co the server cua ban chua cho phep goi mail. Hay lien he nguoi quan ly hosting de khac phuc su co ham mail()";
			}
					
		}				
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
				
		$ret_page="/admin80/";
		
		$a=new msgBox('Toàn bộ Email đã được gửi thành công',"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();		
	}
	//
	function getNewsletterID($id){
		if(!$id) return;
		global $db;
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="subscribers";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);		
		return $rs->fields;
	}
	//
	//
	function deleteNewsletter(){
		global $db;
		$id=getParam("id");
		@include_once("classes/constructSql.class.php");	
		$obj=new constructSql();						
		$obj->tableName="subscribers";
		$obj->where="id = $id";
		$obj->limit="all";		
		$sql=$obj->sqlDelete();	
		$db->Execute($sql);			
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=email";
		$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();		
	}	
	//
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