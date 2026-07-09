{literal}
<script language="javascript" type="text/javascript">
function getvalpage(sel)
{
    //alert(sel.value);
	if(sel.value == 1){
		$('#doanhnghiep').hide();
	}else{
		$('#doanhnghiep').show();
	}
}
function isValidEmailpage(str) {
	if(str.indexOf("@") > 0){
		//document.getElementById('lbl_email').innerHTML = "<img src=\"images/check.gif\" />";
		//
		var url;		
		url="../../?m=user&f=checkMail&mail="+str;
		//alert(url);		
		AjaxRequest.get(
				{
				'url':url				
				,'onSuccess':function(req){document.getElementById('lblCheckMailpage').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		return true;	
	}	
	else{
		//document.getElementById('lbl_email').innerHTML = "<img src=\"images/not_check.gif\" />";
		return false;
	} 
}
///
function isValidmobilepage(str) {
	var url;		
	url="../../?m=user&f=checkmobile&mobile="+str;
	//alert(url);		
	AjaxRequest.get(
			{
			'url':url				
			,'onSuccess':function(req){document.getElementById('lblCheckmobilepage').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)
	return true;	
}
///
function checkInputpage(){
	var obj;
	obj=document.frmRegisterUserpage;	
	//alert(obj.name.value);
	if(!obj.name.value){
		alert("Bạn cần nhập họ tên!");
		obj.name.focus();
		return;
	}	
	if(!isValidEmailpage(obj.txtEmail.value)){
		alert("Bạn cần nhập Email!");
		obj.txtEmail.focus();
		return;
	}	
	if(obj.checkMail.value==1){
		alert("Địa chỉ Email này đã được đăng ký!");
		obj.txtEmail.focus();
		return;
	}
	if(!obj.mobile.value){
		alert("Bạn cần nhập số điện thoại!");
		obj.mobile.focus();
		return;
	}
	if(!isValidmobile(obj.mobile.value)){
		alert("Bạn cần nhập số điện thoại đúng định dạng!");
		obj.mobile.focus();
		return;
	}	
	if(obj.checkmobile.value==1){
		alert("Số điện thoại này đã được đăng ký!");
		obj.mobile.focus();
		return;
	}	
	if(obj.txtPassword.value != obj.txtEnterPassword.value || obj.txtPassword.value.length < 6 ){	
		//alert(obj.txtPassword.value.length);
		alert("Mật khẩu phải từ 6 ký tự trở lên");
		obj.txtPassword.focus();		
		return;	
	}
	
	
	// if (validatePhone2(obj.mobile.value,"Bạn cần nhập số điện thoại đúng!")==false) {
    //        obj.mobile.focus();
    //        return;
     //   }
		
	
	
	if(obj.option.value=='false'){
		alert("Bạn cần Đồng ý với Chính sách & Bảo mật!");
		obj.option.focus();
		return;
	}
	else{
		document.getElementById('waitingOverlay').style.display = 'flex';
		const btn = document.getElementById('submitBtnDK');
		btn.disabled = true;
		btn.value = 'Đang xử lý...';

		obj.submit();
	}
}
</script>
{/literal}
<div class="news">
<div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-8" style="font-size:18px; line-height:30px;">
         <h1 class="titleBlock">Chính sách & quyền lợi Affiliate (tiếp thị liên kết)</h1>
         {chinhsach}
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 first-xs">
        <div class="account">
    	<form name="frmRegisterUserpage" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post" enctype="multipart/form-data">
            <input type="hidden" name="op" value="register" />
            <input type="hidden" name="ret_page" value="{$ret_page}" />

            	<div><h1 class="titleBlock">Đăng Ký Thành Viên</h1></div>
                <div class="form-input"><input placeholder="Họ và tên theo CMND có dấu" type="text" name="name" class="text" /></div>
                <div class="form-input"><input placeholder="Email của bạn" type="text" name="txtEmail" class="text" onchange="isValidEmailpage(document.frmRegisterUserpage.txtEmail.value)" /><label id="lblCheckMailpage" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkMailpage" id="checkMailpage" value="0" /></label></div>
                
                <div class="form-input"><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text"  onchange="isValidmobilepage(document.frmRegisterUserpage.mobile.value)" /><label id="lblCheckmobilepage" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkmobilepage" id="checkmobilepage" value="0" /></label></div>
                <div class="form-input"><input placeholder="Mật khẩu" type="password" name="txtPassword" class="text" /></div>
                <div class="form-input"><input placeholder="Nhập lại mật khẩu" type="password" name="txtEnterPassword" class="text" /></div>
			{if $gioithieu}
			<input type="hidden" name="gioithieu" value="{$gioithieu}" />
			<div class="form-input"><input placeholder="Mã giới thiệu" readonly value="Người giới thiệu: {$tennguoigiothieu}" type="text" name="nguoigioithieu" class="text" /></div>
            {else}
				<div class="form-input"><input placeholder="Mã giới thiệu" type="text" name="gioithieu" class="text" /></div>
			{/if}
              <!--
                
               
                <div class="form-input"><input placeholder="Địa chỉ" type="text" name="address" class="text" /></div>
                <div class="form-input"><input placeholder="CMND" type="text" name="cmnd" id="cmnd" class="text" /></div>
               -->
                <div class="form-input"><input type="checkbox" id="myCheck2" name="option" onclick="myFunctionpage(document.frmRegisterUserpage.option.value)" value="false">
 <label for="myCheck2" style="cursor:pointer" >Đồng ý với Chính sách & Bảo mật</label></div>
                <div class="form-input"><input type="button" value="Đăng ký" class="btn-info" id="submitBtnDK" onclick="checkInputpage()"/>	</div>
                <div style="padding:5px"><a href="#" class="content" data-toggle="modal" data-target="#exampleModalPass" data-dismiss="modal" >Quên mật khẩu</a> &nbsp;|&nbsp;<a class="" href="#" data-toggle="modal" data-target="#exampleModalIn"> Đăng nhập</a></div>
            </form>
    		 </div>  
            </div>
        </div>
    </div>
</div>
{literal}
<script>
function validatePhone2page(field, alerttext) {
    if (field.match(/^\d{10}/)) {
         return true;
    } 
    alert(alerttext);
    return false;
}
function validatePhonepage(field) {
		
        if(field.value.length > 10) {
            //alert(alerttext);
            return false;
        }
        for(i = 0; i < field.value.length; i++) {
            if(parseInt(field.value[i]) == NaN) {
                //alert(alerttxt);
                return false;
            }
        }
        return true;
}

function myFunctionpage(str) {
  // Get the checkbox
  
  var myCheckv = document.getElementById("myCheck2");
  //alert(myCheckv.value);
  // Get the output text
  // If the checkbox is checked, display the output text
  if (myCheckv.checked == true){
  	
    $("#myCheck2").attr('value', 'true');
  } else {
  
    $("#myCheck2").attr('value', 'false');
  }
}	
</script>
{/literal}