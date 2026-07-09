{literal}
<script src="https://cdn.ckeditor.com/4.11.3/standard-all/ckeditor.js"></script>
<script language="javascript" type="text/javascript">
function isValidEmail(str) {
	if(str.indexOf("@") > 0){
		return true;
	}	
	else{
		return false;
	} 
}
//
function checkInput(){
	var obj;	

	obj=document.frmmain;		
		
	
	if(!obj.txtPassword.value){
		alert("Bạn cần nhập mật khẩu mới!");
		obj.txtPassword.focus();
		return;
	}
	
	if(!obj.txtEnterPassword.value){
	alert("Bạn cần nhập mật khẩu mới!");
	obj.txtEnterPassword.focus();
		return;
	}	
	else{		
		obj.submit();
	}
}
function copyToClipboard(elementId) {

  // Create a "hidden" input
  var aux = document.createElement("input");

  // Assign it the value of the specified element
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);

  // Append it to the body
  document.body.appendChild(aux);

  // Highlight its content
  aux.select();

  // Copy the highlighted text
  document.execCommand("copy");

  // Remove it from the body
  document.body.removeChild(aux);

}
</script>
{/literal}
<div style="padding:10px">
<form name="frmmain" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post" enctype="multipart/form-data">
    <input type="hidden" name="imgsmall" value="{$arr.img}" />
    <input type="hidden" name="imgbig" value="{$arr.img1}" />
    <input type="hidden" name="filePDF" value="{$arr.img}" />
    <input type="hidden" name="op" value="changeInfo" />
	<div style="display:none">
    	<div class="content" style="padding-left:5px">Họ và tên:</div>
                <div class="form-input"><input placeholder="Họ và tên" type="text" name="name" class="text" value="{$arr.name}" readonly=""/></div>
                <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8">
                	<div class="content" style="padding-left:5px">Ngày tháng năm sinh:</div>
                	<div class="form-input"><input placeholder="ngày/tháng/năm" type="text" name="sinhngay" class="text" value="{$arr.sinhngay}"/></div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                	<div class="content" style="padding-left:5px">Giới tính:</div>
                    <div class="form-input">
                        <select name="sex" id="sex" class="text">
                          <option value="Nam" {if $arr.sex=='Nam'} selected="selected" {/if}>Nam</option>
                          <option value="Nữ" {if $arr.sex=='Nữ'} selected="selected" {/if}>Nữ</option>
                          <option value="Khác" {if $arr.sex=='Khác'} selected="selected" {/if}>Khác</option>
                        </select>
                    </div>
                </div>
                </div>
                
                <div class="content" style="padding-left:5px">Email:</div>
                <div class="form-input"><input type="text" name="txtEmail" class="text" value="{$arr.email}" readonly=""  /></div>
                <div class="content" style="padding-left:5px">Điện thoại:</div>
                <div class="form-input"><input placeholder="Điện thoại" type="text" name="mobile" class="text" value="{$arr.mobile}" readonly=""/></div>
                <div class="content" style="padding-left:5px">Địa chỉ:</div>
                <div class="form-input"><input placeholder="Địa chỉ" type="text" name="address" class="text" value="{$arr.address}"/></div>
                
                <div class="content" style="padding-left:5px">Số CMND/CCCD/Hộ Chiếu:</div>
                <div class="form-input"><input placeholder="Số CMND/CCCD/Hộ Chiếu" type="text" name="cmt" class="text" value="{$arr.cmt}"/></div>
                
                <div class="content" style="padding-left:5px">Ngày cấp:</div>
                <div class="form-input"><input placeholder="ngày/tháng/năm" type="text" name="ngaycmt" class="text" value="{$arr.ngaycmt}"   style="width:50%"/><input placeholder="Nơi cấp" type="text" name="noicapcmt" class="text" value="{$arr.noicapcmt}"   style="width:50%"/></div>
                
                
                <div class="content" style="padding-left:5px">Tài khoản ngân hàng:</div>
                <div class="form-input"><input placeholder="Tên chủ tk" type="text" name="tenchutknh" class="text" value="{$arr.name}" readonly="" style="width:50%"/><input placeholder="Số TK Ngân Hàng" type="text" name="tknh" class="text" value="{$arr.tknh}"  style="width:50%"/></div>
                <div class="form-input"><input placeholder="Ngân Hàng" type="text" name="nganhangtknh" class="text" value="{$arr.nganhangtknh}" style="width:50%"/><input placeholder="Chi nhánh" type="text" name="chinhanhtknh" class="text" value="{$arr.chinhanhtknh}"  style="width:50%"/></div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-4 img-thumbnail"  style="height:260px;">
            	<div class="title" ><h2  style="text-transform:uppercase">GIỚI THIỆU TÀI KHOẢN </h2></div>
                {if $arr.tknh}
                <div class="content" style="padding-left:5px;">Bạn hãy copy link sau giới thiệu cho bạn bè tạo tài khoản trên TSI:</div>
                
                <div class="content" style="padding-left:5px;">
                
                <p id="p1" style="display:none">{$smarty.const._DOMAIN_ROOT_URL}/user/{$arr.email}</p>
                <p ><button><a href="#" onclick="copyToClipboard('p1')" title="Click để copy" style="cursor:pointer;">Click vào đây để copy link giới thiệu:</a></button></p> {$smarty.const._DOMAIN_ROOT_URL}/user/{$arr.email}
                </div>
                {else}
                <div class="content" style="padding-left:5px; padding-top:20px"><button class="button2"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" class="content" style="color:#FF0000">Cập nhật thông tin tài khoản</a></button></div>
                {/if}
                <div class="content" style="padding-left:5px; font-size:12px; padding-top:20px" align="center">Quyền lợi người giới thiệu và người được giới thiệu <button> <a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/quyenloigioithieu.pdf" target="_blank"  style="color:#FF0000">Xem </a></button></div>
          
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 img-thumbnail" style="height:260px;">
            	<div class="title" ><h2 style="text-transform:uppercase">Thông tin tài khoản</h2></div>
                <div class="content" style="padding-left:5px; text-transform:uppercase">Họ và tên: <strong>{$arr.name}</strong></div>
                <div class="content" style="padding-left:5px; ">Sinh ngày: <strong>{$arr.sinhngay}</strong> - Giới tính: <strong>{$arr.sex}</strong></div>
                <div class="content" style="padding-left:5px">Email: <strong>{$arr.email}</strong></div>
                <div class="content" style="padding-left:5px">Điện thoại: <strong>{$arr.mobile}</strong></div>
                <div class="content" style="padding-left:5px">Địa chỉ: <strong>{$arr.address}</strong></div>
                <div class="content" style="padding-left:5px">Số CMND: <strong>{$arr.cmt}</strong></div>
                <div class="content" style="padding-left:5px">Ngày cấp: <strong>{$arr.ngaycmt}</strong> - Nơi cấp: <strong>{$arr.noicapcmt}</strong></div>
                <div class="content" style="padding-left:5px">Chủ tài khoản: <strong>{$arr.tenchutknh}</strong></div>
                <div class="content" style="padding-left:5px">Số TK Ngân Hàng: <strong>{$arr.tknh}</strong></div>
                <div class="content" style="padding-left:5px">Ngân Hàng: <strong>{$arr.nganhangtknh}</strong></div>
                <div class="content" style="padding-left:5px">Chi nhánh: <strong>{$arr.chinhanhtknh}</strong></div>
                
          
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 img-thumbnail" align="center"  style="height:260px;">
        <div><h2>Thay đổi mật khẩu</h2></div>
         <div class="form-input" style="padding-top:0px"><input placeholder="Mật khẩu" type="password" name="txtPassword" class="text" /></div>
        <div class="form-input"><input placeholder="Nhập lại mật khẩu" type="password" name="txtEnterPassword" class="text" /></div>
        
        <div class="form-input"><input type="button" value="Cập nhật" class="btn-info"  onclick="checkInput()" style="width:100%; height:30px; font-size:14px; font-weight:400" />	</div>
      
    </div>
</div>
</form>
{literal}
<script language="Javascript1.2">
function removeImg(){
		document.getElementById('imgsmallv').innerHTML="";
		document.frmmain.imgsmall.value="";
	}	
	//	
	function removeImg2(){
		document.getElementById('imgbigv').innerHTML="";
		document.frmmain.imgbig.value="";
	}
</script>
{/literal}