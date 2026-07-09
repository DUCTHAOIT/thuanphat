<?php
/* Smarty version 3.1.36, created on 2025-08-28 16:03:48
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/contact.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b01b74180e83_84246689',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bad9d47b43ccb4e3a4af54e3d89bcbe030249723' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/contact.tpl',
      1 => 1754195723,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b01b74180e83_84246689 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="../../js/captcha/ajax_captcha.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript" type="text/javascript">
function isValidCaptcha(str) {	
		var url;		
		url="../../?m=contact&f=captcha&img="+str;
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
<?php echo '</script'; ?>
>


<section class="text-center">
<div class="container-fluid" align="center">
	<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
	<div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <div><?php echo $_smarty_tpl->tpl_vars['address']->value;?>
<br><br><img src="/images/zalotp.jpg" style="width: 200px"></div>
    <div class="dangky">
    	<div>
    	<form name="frmContact" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="m" value="contact" />
        <input type="hidden" name="op" value="sendMail" />
        <input type="hidden" name="subject" value="Đăng ký tham gia CLB đầu tư chung" />
          <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-6" >
            	<div><input  name="name" class="text" style="width:100%" placeholder="Họ tên" /></div>
                <div><input  name="mobile" class="text" style="width:100%" placeholder="Điện thoại" /></div>
                <div><input placeholder="Email của bạn"  name="email" style="width:100%" class="text"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6" >
            	<div>
                	<textarea name="content" class="text" style="width:100%; height:140px" placeholder="Lời nhắn"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" ><input type="button" class="btn btn-primary-dangky" value="Gửi liên hệ" onclick="checkSendMail(document.frmContact);"  /></div>
          </div>  
        </form>	
    	</div>
    </div>
</div>
</section><?php }
}
