{literal}
<script language="JavaScript" type="text/javascript" src="../../js/captcha/ajax_captcha.js"></script>
<script language="javascript" type="text/javascript">
function isValidCaptcha(str) {	
		var url;		
		url="../../?m=invest&f=captcha&img="+str;
		//alert(url);		
		AjaxRequest.get(
				{
				'url':url				
				,'onSuccess':function(req){document.getElementById('lblCheckMail').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		return true;		
}
function checkSendMail(f){
	var obj;
	obj=document.frmContact;
	if(obj.name.value==""){
		alert("Xin nhập họ và tên");
		obj.name.focus();
		return;	
	}else if(obj.mobile.value==""){
		alert("Xin nhập điện thoại");
		obj.mobile.focus();
		return;		
	}else if(isNaN(obj.mobile.value)){
		alert("Điện thoại chỉ được nhập số");
		obj.mobile.focus();
		return;	
	}else if(!isValidEmail(obj.email.value)){
		alert("Xin nhập địa chỉ Email");
		obj.email.focus();
		return;	
	}else if(obj.subject.value==""){
		alert("Xin nhập tiêu đề");
		obj.subject.focus();
		return;
	}else{	
		obj.submit();		
		//var status = AjaxRequest.submit(
		//	f
		//	,{
		//	  'url':window.location.search
		//	  ,'onSuccess':function(req){ document.getElementById('infoContact').innerHTML=req.responseText;}
		//	  ,'onError':function(req){}
		//	}
		//  );
		//  progress('infoContact');		  
		//  return status;
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
function ValidateInput(evt)
  {
  var valRegExp = new RegExp("^[0-9]");
  if (valRegExp.test(String.fromCharCode(evt.which)))
  {
  return true;
  }
  else
 {
  return false;
  }
  }  
</script>
<style>
input[type=text] {
   border: 1px solid #CCCCCC;
   border-radius: 4px;
   height:25px;
}

.textarea {
   border: 1px solid #CCCCCC;
    border-radius: 4px;
}
.td {
   padding-top:5px;
}
.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
	border: 1px solid #CCCCCC;
   	border-radius: 4px;
   	height:40px;
	font-size:12px;
	font-weight:bold;
	padding-left:20px;
	padding-right:20px;
}
</style>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="contentFun"><div>{$nameFun}</div>	</td>
  </tr> 
</table>
<form name="frmContact" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="invest" />
<input type="hidden" name="op" value="sendMail" />
<input type="hidden" name="filePDF" value="" />			
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">             	
  <tr>
    <td class="content" nowrap="nowrap">{$Name}<span style="color:#FF0000">*</span></td>
    <td class="td"><input type="text" name="name" class="text" style="width:100%" /></td>
  </tr>
   <tr>
    <td  class="content">{$Mobile}<span style="color:#FF0000">*</span></td>
    <td class="td"><input type="text" name="mobile" class="text" style="width:100%" /></td>
  </tr>			  
  <tr>
    <td  class="content">E-Mail<span style="color:#FF0000">*</span></td>
    <td class="td"><input type="text" name="email" class="text" style="width:100%" /></td>
  </tr>
  <tr>
    <td  class="content" nowrap="nowrap">Hình thức đầu tư<span style="color:#FF0000">*</span></td>
    <td class="td">
    	<select name="select" >
          <option value="Chia sẻ lợi nhuận" class="textarea">Chia sẻ lợi nhuận</option>
          <option value="Chia sẻ rủi ro" class="textarea">Chia sẻ rủi ro</option>
        </select>
    </td>
  </tr>
  
  <tr>
    <td  class="content" nowrap="nowrap">Số tiền đầu tư<span style="color:#FF0000">*</span></td>
    <td class="td"><input type="text" name="subject" class="text" style="width:100%" /></td>
  </tr>			  
    <td  class="content">Ghi chú:</td>
    <td class="td"><textarea name="content" class="textarea" style="width:100%; height:115px"></textarea></td>
  </tr>	
  <tr>
    <td nowrap="nowrap" valign="top" style="padding-top:10px">Mã bảo vệ<span style="color:#FF0000">*</span></td>
    <td width="100%">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"> 						
            <tr>							
                <td align="left" class="td">
                    <input type="text" name="txtCaptcha" class="text" onchange="isValidCaptcha(document.frmContact.txtCaptcha.value)" style="width:100px" />
                    
                </td>
                <td align="left" valign="top" style="padding-left:3px" class="td">
                    <img id="imgCaptcha" src="{$smarty.const._DOMAIN_ROOT_URL}/js/captcha/create_image.php" height="30px" style="background-color:#000000" />
                </td>	
                <td align="left" width="100%" valign="top"  style="padding-left:3px" class="td">
                    <a href=""><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/f5.png" border="0" /></a>
                </td>													
            </tr>
        </table>
    </td>
  </tr>		 
  <tr>
    <td></td>
    <td align="left" valign="top" class="td"><input type="button" class="btn-success" value="Đăng ký" onclick="checkSendMail(document.frmContact);"  />
    </td>
  </tr>
</table>	
<label id="lbl_email" style="padding-left:10px; color:#FF0000"></label>
<label id="lblCheckMail" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkMail" id="checkMail" value="0" /></label>
<div id="result">&nbsp;</div>
</form>	