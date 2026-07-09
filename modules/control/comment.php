<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print</title>
<link rel="stylesheet" type="text/css" href="../../theme/default/style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body>
<?php
	$op = getParam("op");
	switch ($op){		
		case "add"			:   insertFaqProduct();break;
		default 			:	mainShow(); break;
	}
	function mainShow(){
	global $db,$lable;
	$id = getParam("id");
	if(!$id) return;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
   <tr>
  	<td bgcolor="#EFEDE1" style="border-left:1px solid #E2E2E2; border-right:1px dotted #D7D7D7; border-bottom:1px dotted #D7D7D7; padding-left:10px; padding-right:20px">
	<form name="frmFaqProduct" action="#" method="post" enctype="multipart/form-data">
	<input type="hidden" name="op" value="add" />
	<input type="hidden" name="proid" value="<?php echo $id;?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="title"><?php echo $lable->_("Name");?></td>
	  </tr>
	  <tr>
		<td><input type="text" class="text" name="name" style="width:100%"  /></td>
	  </tr>
	  <tr>
		<td class="title"><?php echo $lable->_("Address");?></td>
	  </tr>
	  <tr>
		<td><input type="text" class="text" name="address" style="width:100%"  /></td>
	  </tr>
	  <tr>
		<td class="title">Email</td>
	  </tr>
	  <tr>
		<td><input type="text" class="text" name="email" style="width:100%"  /></td>
	  </tr>
	  <tr>
		<td class="title"><?php echo $lable->_("Content");?></td>
	  </tr>
	  <tr>
		<td><textarea name="question" class="textarea" style="height:150px"></textarea></td>
	  </tr>
	  <tr>
		<td align="right" style="padding-top:5px"><input type="button" onclick="checkSendMail(document.frmFaqProduct);" value="<?php echo $lable->_("Comment");?>" class="button" /></td>
	  </tr>
	</table>
	</form>	</td>   
  </tr>
</table>
<script language="javascript" type="text/javascript">
function checkSendMail(f){
	var obj;
	obj=document.frmFaqProduct;
	if(obj.name.value==""){
		alert("Bạn cần nhập Tên");
		obj.name.focus();
		return;
	}else if(!isValidEmail(obj.email.value)){
		alert("Bạn cần nhập địa chỉ Email đúng quy các!");
		obj.email.focus();
		return;	
	}else if(obj.question.value==""){
		alert("Bạn cần nhập ý kiến đánh giá");
		obj.question.focus();
		return;	
	}else{	
		obj.submit();					
	  }
}
//
function isValidEmail(str) {
	if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
		return true;
	}	
	else{
		return false;
	} 
}
</script>
<?php 
	}
?>
<?php 
	function insertFaqProduct(){
		global $db,$lang;	
		if(!$lang) $lang="vn";
		
		$name=getParamPost("name");	
		$email=getParamPost("email");	
		$address=getParamPost("address");
		$question=getParamPost("question");	
		$proid=getParamPost("proid");		
		
		
		$record=array();
		$record["name"]=$name;
		$record["email"]=$email;
		$record["address"]=$address;
		$record["question"]=$question;
		$record["proid"]=$proid;
		$record["lang"]=$lang;		
		
		$sql = "SELECT * FROM sys_faq WHERE 0 = -1";
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $record);
		$return=$db->Execute($sql);
			
		if(!$return){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"color:#016434; padding:40px; padding-top:80px\" align=\"center\">Có lỗi sảy ra!</td>
				  </tr>
				  <tr>
					<td align=\"center\"><a onclick=\"javascript:window.close();\" style=\"cursor:pointer; color:#FF0000\" class=\"content\">Thoát</a></td>
				  </tr>
				</table>";
		}else{
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td class=\"title\" style=\"color:#016434; padding:40px; padding-top:80px\" align=\"center\">Cảm ơn bạn đã gửi đánh giá cho chúng tôi!</td>
				  </tr>
				  <tr>
					<td align=\"center\"><a onclick=\"javascript:window.close();\" style=\"cursor:pointer; color:#FF0000\" class=\"content\">Thoát</a></td>
				  </tr>
				</table>";
		}	
	}
	//
?>
</body>
</html>
