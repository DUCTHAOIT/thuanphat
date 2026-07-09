<?php
/* Smarty version 3.1.36, created on 2026-07-08 08:56:03
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\userRegister.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a4df483d4dd88_76302888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7d928dd5d2428f31247e52e687ab83376d2dd20d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\userRegister.tpl',
      1 => 1783309160,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a4df483d4dd88_76302888 (Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php echo '<script'; ?>
 language="javascript" type="text/javascript">

		var isReferralValid = true; // Mặc định cho phép submit nếu không nhập mã



		function checkReferralCode(code) {

			var submitBtnReg = document.getElementById('submitBtnDK');

			if (code.trim() === '') {

				document.getElementById('lblReferral').innerHTML = '';

				isReferralValid = true; // Không nhập mã thì coi như hợp lệ

				submitBtnReg.disabled = false;

				return;

			}



			var url = "../../?m=user&f=checkreferral&code=" + encodeURIComponent(code);



			AjaxRequest.get({

				'url': url,

				'onSuccess': function (req) {

					var res = JSON.parse(req.responseText);

					if (res.status === 'ok') {

						document.getElementById('lblReferral').innerHTML = '<span style="color:green">Người giới thiệu: ' + res.name + '</span>';

						isReferralValid = true;

						submitBtnReg.disabled = false;

					} else {

						document.getElementById('lblReferral').innerHTML = '<span style="color:red">Mã giới thiệu không tồn tại!</span>';

						isReferralValid = false;

						submitBtnReg.disabled = true;

					}

				},

				'onError': function () {

					document.getElementById('lblReferral').innerHTML = '<span style="color:red">Lỗi kết nối!</span>';

					isReferralValid = false;

					submitBtnReg.disabled = true;

				}

			});

		}



		function getvalpage(sel) {

			if(sel.value == 1){

				$('#doanhnghiep').hide();

			} else {

				$('#doanhnghiep').show();

			}

		}



		function isValidEmailpage(str) {

			if(str.indexOf("@") > 0){

				var url = "../../?m=user&f=checkMail&mail=" + str;

				AjaxRequest.get({

					'url': url,

					'onSuccess': function(req){

						document.getElementById('lblCheckMailpage').innerHTML = req.responseText;

					},

					'onError': function(req){}

				})

				return true;

			} else {

				return false;

			}

		}



		function isValidmobilepage(str) {

			var url = "../../?m=user&f=checkmobile&mobile=" + str;

			AjaxRequest.get({

				'url': url,

				'onSuccess': function(req){

					document.getElementById('lblCheckmobilepage').innerHTML = req.responseText;

				},

				'onError': function(req){}

			})

			return true;

		}



		function checkInputpage(){

			var obj = document.frmRegisterUserpage;



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

				alert("Mật khẩu phải từ 6 ký tự trở lên");

				obj.txtPassword.focus();

				return;

			}



			// ✅ Kiểm tra mã giới thiệu

			if (!isReferralValid) {

				alert("Mã giới thiệu không hợp lệ!");

				obj.gioithieu.focus();

				return;

			}



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

	<?php echo '</script'; ?>
>





<div class="news">

	<div class="container">

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-8" style="font-size:18px; line-height:30px;">

				<h1 class="titleBlock">Chính sách & quyền lợi Affiliate (tiếp thị liên kết)</h1>

				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['chinhsach'][0], array( array(),$_smarty_tpl ) );?>


			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 first-xs">

				<div class="account">

					<form name="frmRegisterUserpage" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/?m=user" method="post" enctype="multipart/form-data">

						<input type="hidden" name="op" value="register" />

						<input type="hidden" name="ret_page" value="<?php echo $_smarty_tpl->tpl_vars['ret_page']->value;?>
" />



						<div><h1 class="titleBlock">Đăng Ký Thành Viên</h1></div>

						<div class="form-input"><input placeholder="Họ và tên theo CMND có dấu" type="text" name="name" class="text" /></div>

						<div class="form-input"><input placeholder="Email của bạn" type="text" name="txtEmail" class="text" onchange="isValidEmailpage(document.frmRegisterUserpage.txtEmail.value)" /><label id="lblCheckMailpage" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkMailpage" id="checkMailpage" value="0" /></label></div>



						<div class="form-input"><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text"  onchange="isValidmobilepage(document.frmRegisterUserpage.mobile.value)" /><label id="lblCheckmobilepage" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkmobilepage" id="checkmobilepage" value="0" /></label></div>

						<div class="form-input"><input placeholder="Mật khẩu" type="password" name="txtPassword" class="text" /></div>

						<div class="form-input"><input placeholder="Nhập lại mật khẩu" type="password" name="txtEnterPassword" class="text" /></div>

						<?php if ($_smarty_tpl->tpl_vars['gioithieu']->value) {?>

							<input type="hidden" name="gioithieu" value="<?php echo $_smarty_tpl->tpl_vars['gioithieu']->value;?>
" />

							<div class="form-input"><input placeholder="Mã giới thiệu" readonly value="Người giới thiệu: <?php echo $_smarty_tpl->tpl_vars['tennguoigiothieu']->value;?>
" type="text" name="nguoigioithieu" class="text" /></div>

						<?php } else { ?>

							<div class="form-input">

								<input placeholder="Mã giới thiệu" type="text" name="gioithieu" class="text"

									   onchange="checkReferralCode(this.value)" />

								<label id="lblReferral" style="font-size:11px;"></label>

							</div>

						<?php }?>

						<!--





                          <div class="form-input"><input placeholder="Địa chỉ" type="text" name="address" class="text" /></div>

                          <div class="form-input"><input placeholder="CMND" type="text" name="cmnd" id="cmnd" class="text" /></div>

                         -->

						<div class="form-input"><input type="checkbox" id="myCheck2" name="option" onclick="myFunctionpage(document.frmRegisterUserpage.option.value)" value="false">

							<label for="myCheck2" style="cursor:pointer" >Đồng ý với <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/lib/dieukhoan-hopdong.pdf" target="_blank">Điều khoản và điều kiện hợp đồng đại lý</a></label></div>

						<div class="form-input"><input type="button" value="Đăng ký" class="btn-info" id="submitBtnDK" onclick="checkInputpage()"/>	</div>

						<div style="padding:5px"><a href="#" class="content" data-toggle="modal" data-target="#exampleModalPass" data-dismiss="modal" >Quên mật khẩu</a> &nbsp;|&nbsp;<a class="" href="#" data-toggle="modal" data-target="#exampleModalIn"> Đăng nhập</a></div>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>



	<?php echo '<script'; ?>
>

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

	<?php echo '</script'; ?>
>

<?php }
}
