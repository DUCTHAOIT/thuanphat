{literal}
<script language="javascript" type="text/javascript">
function isValidEmail(str) {
	if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
		return true;
	}	
	else{
		return false;
	} 
}
//
function checkInput(){
	var obj;
	obj=document.frmForgetUser;
	if(!isValidEmail(obj.txtEmail.value)){
		alert("Email!");
		obj.txtEmail.focus();
		return;	
	}else{
		obj.submit();
	}
}
</script>
{/literal}
<div align="center">
    <div class="flogin" style="max-width:360px; margin-bottom: 20px;  padding-top:20px; padding-bottom:20px;
    border: 1px solid transparent;
    border-radius: 3px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);">
    	<form name="frmForgetUser" action="#" method="post" enctype="multipart/form-data">
			<input type="hidden" name="m" value="user" />
            <input type="hidden" name="op" value="randPasword" />
            	<div><h1 class="titleBlock">Lấy lại mật khẩu</h1></div>
                <div class="form-input"><input placeholder="Email của bạn" type="text" name="txtEmail" class="text" /></div>
                <div class="form-input"><input type="button" value="Xác nhận" class="btn-info" onclick="checkInput()" style="width:100%; height:30px; font-size:14px; font-weight:400" />	</div>
            </form>
    </div>
</div>

