<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:34:40
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/userInfoMember.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b014a07f49d4_24704777',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6f132e58445d4892dd46319c0266b0fbdf1b9eb2' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/userInfoMember.tpl',
      1 => 1754188632,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b014a07f49d4_24704777 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
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
<?php echo '</script'; ?>
>

<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-3 col-md-3">
    	<div class="room-sidebar">
        	 <div style="padding-bottom:20px;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['usermenu2'][0], array( array(),$_smarty_tpl ) );?>
</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9" style="padding-bottom:30px; padding-top:30px;">
    	<form name="frmmain" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/?m=user" method="post" enctype="multipart/form-data">
        <input type="hidden" name="imgsmall" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
        <input type="hidden" name="imgbig" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img1'];?>
" />
        <input type="hidden" name="filePDF" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
        <input type="hidden" name="op" value="changeInfo" />
            	<div><h1 style="text-transform:uppercase; font-weight:700">Thông tin tài khoản</h1></div>
                
                
                <div class="row">
                
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Họ và tên:</div>
                        <div class="form-input"><input placeholder="Họ và tên" type="text" name="name" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" readonly=""/></div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="content" style="padding-left:5px">Ngày tháng năm sinh:</div>
                        <div class="form-input"><input placeholder="ngày/tháng/năm" type="text" name="sinhngay" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['sinhngay'];?>
"/></div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
                        <div class="content" style="padding-left:5px">Giới tính:</div>
                        <div class="form-input">
                            <select name="sex" id="sex" class="text">
                              <option value="Nam" <?php if ($_smarty_tpl->tpl_vars['arr']->value['sex'] == 'Nam') {?> selected="selected" <?php }?>>Nam</option>
                              <option value="Nữ" <?php if ($_smarty_tpl->tpl_vars['arr']->value['sex'] == 'Nữ') {?> selected="selected" <?php }?>>Nữ</option>
                              <option value="Khác" <?php if ($_smarty_tpl->tpl_vars['arr']->value['sex'] == 'Khác') {?> selected="selected" <?php }?>>Khác</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Email:</div>
                        <div class="form-input"><input type="text" name="txtEmail" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['email'];?>
" readonly=""  /></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="content" style="padding-left:5px">Điện thoại:</div>
                        <div class="form-input"><input placeholder="Điện thoại" type="text" name="mobile" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['mobile'];?>
" readonly=""/></div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-6 col-md-6">
                    	<div class="content" style="padding-left:5px">Địa chỉ:</div>
                    	<div class="form-input"><input placeholder="Địa chỉ" type="text" name="address" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
"/></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                    	<div class="content" style="padding-left:5px">Số CMND/CCCD/Hộ Chiếu:</div>
                    	<div class="form-input"><input placeholder="Số CMND/CCCD/Hộ Chiếu" type="text" name="cmt" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['cmt'];?>
"/></div>
                     </div>   
                </div>
                <div class="content" style="padding-left:5px">Tài khoản ngân hàng:</div>
                <div class="row"  style="padding-left:5px">
                		
                			<div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Tên chủ tk" type="text" name="tenchutknh" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" readonly="" /></div>
                    		<div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Số TK Ngân Hàng" type="text" name="tknh" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['tknh'];?>
" /></div>
                            <div class="col-xs-12 col-sm-4 col-md-4"><input placeholder="Ngân Hàng" type="text" name="nganhangtknh" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['nganhangtknh'];?>
" /></div>
                </div>
                
                <div class="content" style="padding-left:5px">Ảnh CMND/CCCD cả 2 mặt</div>
                <div class="row" style="padding:5px;">
                     <div class="col-xs-12 col-sm-6 col-md-6">  
                        <div><strong>Mặt trước</strong></div>
                        <div id="imgsmallv"><a href="#" onclick="windowUploadFile('imgsmall')" ><img src="<?php echo $_smarty_tpl->tpl_vars['arr']->value['imgs_view'];?>
" border="0" style="text-align:center" width="80%" /></a></div>
                        <div id="imgsmallv" style="padding-top:10px; padding-bottom:10px;"><a href="#" onclick="windowUploadFile('imgsmall')" class="btn_viewmore" style="padding:10px;"><i class="fa fa-camera" aria-hidden="true"></i> Chụp CCCD mặt trước</a></div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div><strong>Mặt sau</strong></div>
                        <div id="imgbigv"><a href="#" onclick="windowUploadFile('imgbig')"  style="text-align:center"><img src="<?php echo $_smarty_tpl->tpl_vars['arr']->value['imgb_view'];?>
" border="0" width="80%" /></a></div>
                        <div id="imgbigv" style="padding-top:10px; padding-bottom:10px;"><a href="#" onclick="windowUploadFile('imgbig')" class="btn_viewmore" style="padding:10px;"><i class="fa fa-camera" aria-hidden="true"></i> Chụp CCCD mặt sau</a></div>
                    </div>
                </div>
                <div class="form-input"><input type="button" value="Cập nhật" class="btn btn-primary"  onclick="checkInput()" />	</div>
    </div>
    </form>
	</div>
</div>

<?php echo '<script'; ?>
 language="Javascript1.2">
function removeImg(){
		document.getElementById('imgsmallv').innerHTML="";
		document.frmmain.imgsmall.value="";
	}	
	//	
	function removeImg2(){
		document.getElementById('imgbigv').innerHTML="";
		document.frmmain.imgbig.value="";
	}
<?php echo '</script'; ?>
>
<?php }
}
