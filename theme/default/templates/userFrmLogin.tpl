{literal}
<style type="text/css">
	.modal-open .modal{
		margin-top: 160px;
	}
</style>
<script type="text/javascript">
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
</script>
{/literal}
<div class="container-fluid" align="center">
	
    <div class="flogin" style="max-width:360px; margin-bottom: 20px;  padding-top:20px; padding-bottom:20px;">
    <div class="account">
    	<form name="loginForm" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post">
			<input type="hidden" name="op" value="login" />
            <input type="hidden" name="ret_page" value="{$ret_page}" />
            <input  type="submit" name="update" value=" Apply " 
    style="position: absolute; height: 0px; width: 0px; border: none; padding: 0px;"
    hidefocus="true" tabindex="-1"/>
            	<div><h1 class="titleBlock">Đăng nhập</h1></div>
                <div class="form-input"><input placeholder="Email hoặc số điện thoại của bạn" type="text" name="email" style="width:100%" class="text"></div>
                <div class="form-input"><input placeholder="Mật khẩu" type="password" name="password" style="width:100%" class="text"></div>
                
                <div class="form-input"><input type="button" value="Đăng nhập" class="btn-info" onclick="checkInput();" style="width:100%; height:40px; font-size:14px; font-weight:400" />	</div>
                <div style="padding:5px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_forget/" class="content">Quên mật khẩu</a> &nbsp;|&nbsp; <a href="{$smarty.const._DOMAIN_ROOT_URL}/user/" class="content"> Đăng ký</a></div>
            </form>
         </div>   
    </div>
</div>
{literal}
<script language=javascript>
function checkInput(){
	var obj;
	obj=document.loginForm;
	if(!obj.password.value){
		alert("Password!");
		obj.password.focus();
		return;
	}		
	if(!obj.email.value){
		alert("email!");
		obj.email.focus();
		return;
	}else{		
		obj.submit();
	}
}
</script>
{/literal}