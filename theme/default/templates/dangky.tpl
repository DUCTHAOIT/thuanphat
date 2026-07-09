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
  <tr height="34">
    <td  nowrap="nowrap" align="left" class="titleBlock" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/bgtitle.png); background-repeat:repeat-x; background-position:bottom; padding-bottom:20px" >Đăng ký đầu tư</td>          
  </tr>
</table>
<br />
<form name="frmContact" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="invest" />
<input type="hidden" name="op" value="sendMail" />
<input type="hidden" name="filePDF" value="" />	
<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">{$Name}<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><input type="text" name="name" class="text" style="width:100%" /></div>

<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">{$Mobile}<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><input type="text" name="mobile" class="text" style="width:100%" /></div>
<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">E-Mail<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><input type="text" name="email" class="text" style="width:100%" /></div>

<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">Hình thức đầu tư<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px">
	<select name="select" >
          <option value="Chia sẻ lợi nhuận" class="textarea">Chia sẻ lợi nhuận</option>
          <option value="Chia sẻ rủi ro" class="textarea">Chia sẻ rủi ro</option>
        </select>
</div>
<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">Số tiền đầu tư<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><input type="text" name="subject" class="text" style="width:100%" /></div>

<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px;">Ghi chú:</div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><textarea name="content" class="textarea" style="height:200px"></textarea></div>

<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">Mã bảo vệ<span style="color:#FF0000">*</span></div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px">
	<table width="100%" cellpadding="0" cellspacing="0" border="0"> 						
            <tr>							
                <td align="left"  width="100%" style="padding-right:5px">
                    <input type="text" name="txtCaptcha" class="text" onchange="isValidCaptcha(document.frmContact.txtCaptcha.value)" style="width:95%" />
                    
                </td>
                <td align="left" valign="top" style="padding-left:10px" >
                    <img id="imgCaptcha" src="{$smarty.const._DOMAIN_ROOT_URL}/js/captcha/create_image.php" height="31px" style="background-color:#000000" />
                </td>	
                <td align="left" width="100%" valign="top"  style="padding-left:10px" >
                    <a href=""><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/f5.png" border="0" /></a>
                </td>													
            </tr>
        </table>
</div>

<div class="col-xs-12 col-sm-3 col-md-3" style="padding:5px">&nbsp;</div>
<div class="col-xs-12 col-sm-9 col-md-9" style="padding:5px"><input type="button" class="btn-success" value="Đăng ký" onclick="checkSendMail(document.frmContact);"  /> </div>  
<label id="lbl_email" style="padding-left:10px; color:#FF0000"></label>
<label id="lblCheckMail" style="font-size:11px; color:#FF0000; float:left"><input type="hidden" name="checkMail" id="checkMail" value="0" /></label>
<div id="result" style="float:right">&nbsp;</div>
<div class="title" style="font-size:14px">
	<i>Qúy khách vui lòng liên hệ theo Hotline: <font color="#FF0000" style="font-size:16px">0904 148 386</font> để được đăng ký ngay</i>
</div>
</form>	