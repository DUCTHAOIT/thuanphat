<?php
/* Smarty version 3.1.36, created on 2025-08-28 16:55:55
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/userChangePassword.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b027abc48ef3_12844898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64bba59cd1cc48edd883592fc37569a3bc8067ec' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/userChangePassword.tpl',
      1 => 1754188631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b027abc48ef3_12844898 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style type="text/css">
	.modal-open .modal{
		margin-top: 160px;
	}
</style>
<?php echo '<script'; ?>
 type="text/javascript">
// Using jQuery.
$(document).ready(function() {

  $('.btn-info').keydown(function(event) {
    // enter has keyCode = 13, change it if you want to use another button
    if (event.keyCode == 13) {
      this.form.submit();
      return false;
    }
  });

});
<?php echo '</script'; ?>
>

<div class="container-fluid" align="center">
	
    <div class="flogin" style="max-width:360px; margin-bottom: 20px;  padding-top:20px; padding-bottom:20px;">
    <div class="account">
    	<form name="changepassForm" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/?m=user" method="post">
			<input type="hidden" name="f" value="changepasswordfrm" />
            <input type="hidden" name="op" value="changepassword" />
            <input  type="submit" name="update" value=" Apply " 
    style="position: absolute; height: 0px; width: 0px; border: none; padding: 0px;"
    hidefocus="true" tabindex="-1"/>
            	<div><h1 class="titleBlock">Thay đổi mật khẩu</h1></div>
                <div class="form-input"><input placeholder="Nhập mật khẩu cũ" type="password" name="txtPasswordOld" style="width:100%" class="text"></div>
                <div class="form-input"><input placeholder="Nhập mật khẩu mới" type="password" name="txtPassword" class="text" /></div>
                <div class="form-input"><input placeholder="Nhập lại mật khẩu mới" type="password" name="txtEnterPassword" class="text" /></div>
                
                <div class="form-input"><input type="button" value="Đổi mật khẩu" class="btn btn-primary" onclick="checkInputchangepassForm();"/>	</div>
            </form>
         </div>   
    </div>
</div>

<?php echo '<script'; ?>
 language=javascript>
function checkInputchangepassForm(){
	var obj;
	obj=document.changepassForm;
	if(!obj.txtPasswordOld.value){
		alert("Bạn cần nhập mật khẩu cũ");
		obj.txtPasswordOld.focus();
		return;
	}
	if(obj.txtPassword.value.length < 6 ){	
		//alert(obj.txtPassword.value.length);
		alert("Mật khẩu phải từ 6 ký tự trở lên");
		obj.txtPassword.focus();		
		return;	
	}
	if(obj.txtPassword.value != obj.txtEnterPassword.value){	
		//alert(obj.txtPassword.value.length);
		alert("Mật khẩu không giống nhau");
		obj.txtPassword.focus();		
		return;	
	}else{		
		obj.submit();
	}
}
<?php echo '</script'; ?>
>
<?php }
}
