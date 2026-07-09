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
	obj=document.frmmain;	
	if(!obj.name.value){
		alert("Bạn cần nhập họ tên!");
		obj.name.focus();
		return;
	}else if(!obj.mobile.value){
	alert("Bạn cần nhập số điện thoại!");
	obj.mobile.focus();
		return;
	}else{		
		obj.submit();
	}
}
</script>
{/literal}
<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-3 col-md-3">
    	<div class="room-sidebar">
        	 <div style="padding-bottom:20px;">{usermenu2}</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9" style="padding-bottom:30px; padding-top:30px;">
    	<form name="frmmain" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post" enctype="multipart/form-data">
        <input type="hidden" name="imgsmall" value="{$arr.img}" />
        <input type="hidden" name="imgbig" value="{$arr.img1}" />
        <input type="hidden" name="filePDF" value="{$arr.img}" />
        <input type="hidden" name="op" value="changeInfo" />
            	<div><h1 style="text-transform:uppercase; font-weight:700">Thông tin tài khoản</h1></div>
                
                
                <div class="row">
                
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Họ và tên:</div>
                        <div class="form-input"><input placeholder="Họ và tên" type="text" name="name" class="text" value="{$arr.name}" readonly=""/></div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="content" style="padding-left:5px">Ngày tháng năm sinh:</div>
                        <div class="form-input"><input placeholder="ngày/tháng/năm" type="text" name="sinhngay" class="text" value="{$arr.sinhngay}"/></div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
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
                
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Email:</div>
                        <div class="form-input"><input type="text" name="txtEmail" class="text" value="{$arr.email}" readonly=""  /></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Điện thoại:</div>
                        <div class="form-input"><input placeholder="Điện thoại" type="text" name="mobile" class="text" value="{$arr.mobile}" readonly=""/></div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-6 col-md-6">
                    	<div class="content" style="padding-left:5px">Địa chỉ:</div>
                    	<div class="form-input"><input placeholder="Địa chỉ" type="text" name="address" class="text" value="{$arr.address}"/></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                    	<div class="content" style="padding-left:5px">Số CMND/CCCD/Hộ Chiếu:</div>
                    	<div class="form-input"><input placeholder="Số CMND/CCCD/Hộ Chiếu" type="text" name="cmt" class="text" value="{$arr.cmt}"/></div>
                     </div>   
                </div>
                <div class="content" style="padding-left:5px">Tài khoản ngân hàng:</div>
                <div class="row"  style="padding-left:5px">
                		
                			<div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Tên chủ tk" type="text" name="tenchutknh" class="text" value="{$arr.name}" readonly="" /></div>
                    		<div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Số TK Ngân Hàng" type="text" name="tknh" class="text" value="{$arr.tknh}" /></div>
                            <div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Ngân Hàng" type="text" name="nganhangtknh" class="text" value="{$arr.nganhangtknh}" /></div>
                </div>
                
                <div class="content" style="padding-left:5px">Ảnh CMND/CCCD cả 2 mặt</div>
                <div class="row" style="padding:5px;">
                     <div class="col-xs-12 col-sm-6 col-md-6">  
                        <div><strong>Mặt trước</strong></div>
                        <div id="imgsmallv"><a href="#" onclick="windowUploadFile('imgsmall')" ><img src="{$arr.imgs_view}" border="0" style="text-align:center" width="80%" /></a></div>
                        <div id="imgsmallv" style="padding-top:10px; padding-bottom:10px;"><a href="#" onclick="windowUploadFile('imgsmall')" class="btn_viewmore" style="padding:10px;"><i class="fa fa-camera" aria-hidden="true"></i> Chụp CCCD mặt trước</a></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div><strong>Mặt sau</strong></div>
                        <div id="imgbigv"><a href="#" onclick="windowUploadFile('imgbig')"  style="text-align:center"><img src="{$arr.imgb_view}" border="0" width="80%" /></a></div>
                        <div id="imgbigv" style="padding-top:10px; padding-bottom:10px;"><a href="#" onclick="windowUploadFile('imgbig')" class="btn_viewmore" style="padding:10px;"><i class="fa fa-camera" aria-hidden="true"></i> Chụp CCCD mặt sau</a></div>
                    </div>
                </div>
                <div class="form-input"><input type="button" value="Cập nhật" class="btn btn-primary"  onclick="checkInput()" />	</div>
    </div>
    </form>
	</div>
</div>
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