<?php
/* Smarty version 3.1.36, created on 2026-07-03 14:51:44
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/basket_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a476a10123859_23073893',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '566a4a4a890339c2db081ed71039d8444230d8a3' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/basket_list.tpl',
      1 => 1782805146,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a476a10123859_23073893 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<link rel="stylesheet" type="text/css" href="../assets/css/user.css"/>
	<style>
		.ico-copy {
			background: url(../images/ico-copy.png) no-repeat;
			height: 14px;
			width: 12px;
			display: inline-block;
			vertical-align: -2px;
		}
		.visuallyhidden{position:absolute;clip:rect(1px,1px,1px,1px)}
		.copybutton{background-color:#fff;border:0;outline:0;cursor:pointer;opacity:1;position:absolute;width:40px;height:40px;z-index:9;border-radius:24px}
		.button-tooltip-container {
			display: flex;
			align-items: center;
			margin-top: 16px;
			min-height: 30px;

		}
		#custom-tooltip {
			display: none;
			margin-left: 40px;
			padding: 5px 12px;
			background-color: #000000df;
			border-radius: 4px;
			color: #fff;
		}
	</style>

	<?php echo '<script'; ?>
 language="javascript">
		function checkSendMail(f){
			var obj;
			obj=document.frmbasket;
			if(obj.name.value==""){
				alert("Vui lòng nhập Họ và tên");
				obj.name.focus();
				return;
			}else if(!isValidEmail(obj.email.value)){
				alert("Vui lòng nhập Email");
				obj.email.focus();
				return;

			}else if(obj.mobile.value==""){
				alert("Vui lòng nhập số điện thoại");
				obj.mobile.focus();
				return;
				//}else if(isNaN(obj.mobile.value)){
//		alert("Điện thoại chỉ được nhập số");
//		obj.mobile.focus();
//		return;
			}else if(obj.address.value==""){
				alert("Vui lòng nhập địa chỉ nhận hàng");
				obj.address.focus();
				return;

			}else{
				// 1. Hiển thị overlay
				document.getElementById('waitingOverlay').style.display = 'flex';

				// 2. Vô hiệu hóa nút
				const btn = document.getElementById('submitBtn');
				btn.disabled = true;
				btn.value = 'Đang xử lý...';

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

		function txtSymbolEnterKey(evt)
		{
			var e=(window.event)?event:evt;
			if(e.keyCode==13){
				//document.getElementById('update').click();
				document.frmbasket.product_id.value=evt;
				document.frmbasket.op.value='edit_basket';

				document.frmbasket.submit();
				return false;
			}
		}
	<?php echo '</script'; ?>
>
	<style>
		.wt-bg-denim-tint {
			background-color: #d7e6f5 !important;
		}
		.wt-rounded-02 {
			border-radius: 12px !important;
			overflow: hidden !important;
		}
		@media only screen and (min-width: 0)
			.wt-p-xs-2 {
				padding: 12px !important;
			}
			.wt-width-full {
				width: 100% !important;
			}
			.wt-align-items-center {
				align-items: center !important;
			}
			@media only screen and (min-width: 0)
				.wt-display-flex-xs {
					display: flex !important;
				}
				.wt-bg-denim-tint {
					background-color: #d7e6f5 !important;
				}

				.is-in-view #e0NMFoeIPOT2_to {animation: e0NMFoeIPOT2_to__to 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT2_to__to {0% {transform: translate(44.162561px,5.846695px)} 8% {transform: translate(44.162561px,5.846695px); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: translate(42.257336px,6.69656px); animation-timing-function: cubic-bezier(0.25,0,0.75,1)} 28% {transform: translate(46.27px,7.700005px)} 36.5% {transform: translate(42.752561px,5.5px)} 48% {transform: translate(44.150002px,6.297191px)} 100% {transform: translate(44.150002px,6.297191px)}}
				.is-in-view #e0NMFoeIPOT2_tr {animation: e0NMFoeIPOT2_tr__tr 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT2_tr__tr {0% {transform: rotate(-5deg)} 8% {transform: rotate(-5deg); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: rotate(-7deg); animation-timing-function: cubic-bezier(0.25,0,0.75,1)} 28% {transform: rotate(7deg)} 36.5% {transform: rotate(-5deg)} 48% {transform: rotate(0deg)} 100% {transform: rotate(0deg)}}
				.is-in-view #e0NMFoeIPOT5_to {animation: e0NMFoeIPOT5_to__to 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT5_to__to {0% {transform: translate(4.2px,5.697011px)} 8% {transform: translate(4.2px,5.697011px); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: translate(5.826704px,6.546839px); animation-timing-function: cubic-bezier(0.25,0,0.75,1)} 28% {transform: translate(1.52px,7.701463px)} 36.5% {transform: translate(5.294274px,5.6px)} 48% {transform: translate(3.85px,6.297191px)} 100% {transform: translate(3.85px,6.297191px)}}
				.is-in-view #e0NMFoeIPOT5_tr {animation: e0NMFoeIPOT5_tr__tr 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT5_tr__tr {0% {transform: rotate(5deg)} 8% {transform: rotate(5deg); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: rotate(7deg); animation-timing-function: cubic-bezier(0.25,0,0.75,1)} 28% {transform: rotate(-7deg)} 36.5% {transform: rotate(5deg)} 48% {transform: rotate(0deg)} 100% {transform: rotate(0deg)}}
				.is-in-view #e0NMFoeIPOT8_to {animation: e0NMFoeIPOT8_to__to 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT8_to__to {0% {transform: translate(28.52px,15.1px)} 8% {transform: translate(28.52px,15.1px); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: translate(26.96px,16.52px); animation-timing-function: cubic-bezier(0.284467,0,0.625227,0.383992)} 18.5% {transform: translate(27.14px,16.214055px); animation-timing-function: cubic-bezier(0.310382,0.25506,0.719913,0.848254)} 19.5% {transform: translate(27.3px,15.96px)} 20.5% {transform: translate(27.47px,15.63px)} 22.5% {transform: translate(27.96px,14.98px)} 24.5% {transform: translate(28.46px,14.3px)} 27% {transform: translate(29.004407px,13.613261px); animation-timing-function: cubic-bezier(0.36087,0.641427,0.696459,1)} 28% {transform: translate(29.07px,13.52px)} 28.5% {transform: translate(28.952353px,13.590588px)} 30% {transform: translate(28.55px,13.84px)} 31% {transform: translate(28.3px,14px)} 32% {transform: translate(28.13px,14.18px)} 33% {transform: translate(27.85px,14.3px)} 33.5% {transform: translate(27.776555px,14.35px)} 34% {transform: translate(27.6px,14.4px)} 34.5% {transform: translate(27.540925px,14.5px)} 35.5% {transform: translate(27.305294px,14.6px)} 36.5% {transform: translate(27.07px,14.72px)} 48% {transform: translate(27.765359px,14.148534px)} 100% {transform: translate(27.765359px,14.148534px)}}
				.is-in-view #e0NMFoeIPOT8_tr {animation: e0NMFoeIPOT8_tr__tr 2000ms linear 1 normal forwards} @keyframes e0NMFoeIPOT8_tr__tr {0% {transform: rotate(-5deg)} 8% {transform: rotate(-5deg); animation-timing-function: cubic-bezier(0.15,0,1,1)} 16.5% {transform: rotate(-7deg); animation-timing-function: cubic-bezier(0.25,0,0.75,1)} 28% {transform: rotate(7deg)} 36.5% {transform: rotate(-5deg)} 48% {transform: rotate(0deg)} 100% {transform: rotate(0deg)}}

	</style>
	<style>.a{opacity:0;}.b{fill:#fff;}.c{fill:#ff5f00;}.d{fill:#eb001b;}.e{fill:#f79e1b;}</style>
	<style type="text/css" id="style2">
		.visa-svg-path{fill:#1434CB;}
		.svg-payment-icon {
			display: inline-block;
			width: 48px;
			height: 32px;
			border: 1px solid #e2e2e2;
			background: #fdfdfc;
			border-radius: 3px;
			text-align: center;
			box-shadow: 0 1px 0 rgba(226,226,226,.2);
			vertical-align: middle;
		}
		.wt-screen-reader-only {
			border: 0 !important;
			clip: rect(0 0 0 0) !important;
			height: 1px !important;
			margin: -1px !important;
			overflow: hidden !important;
			padding: 0 !important;
			position: absolute !important;
			width: 1px !important;
		}
	</style>


<?php if ($_smarty_tpl->tpl_vars['username']->value) {
if (empty($_smarty_tpl->tpl_vars['cmt']->value) || empty($_smarty_tpl->tpl_vars['img']->value) || empty($_smarty_tpl->tpl_vars['img1']->value)) {?>

	
	<style>
		#updatePopupOverlay {
			position: fixed;
			top: 0; left: 0;
			width: 100vw; height: 100vh;
			background: rgba(0, 0, 0, 0.5);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}

		#updatePopup {
			background: white;
			padding: 30px;
			border-radius: 12px;
			text-align: center;
			width: 90%;
			max-width: 400px;
			box-shadow: 0 8px 20px rgba(0,0,0,0.2);
			animation: popupFadeIn 0.3s ease-out;
		}

		@keyframes popupFadeIn {
			from { opacity: 0; transform: scale(0.8); }
			to { opacity: 1; transform: scale(1); }
		}

		#updatePopup h2 {
			margin-top: 0;
			font-size: 22px;
			color: #333;
		}

		#updatePopup p {
			margin: 15px 0;
			color: #555;
		}

		#updatePopup .btn {
			padding: 10px 20px;
			background: #007bff;
			color: white;
			border: none;
			border-radius: 5px;
			text-decoration: none;
			display: inline-block;
			margin-top: 15px;
		}

		#updatePopup .close-btn {
			background: transparent;
			border: none;
			font-size: 20px;
			position: absolute;
			top: 12px;
			right: 20px;
			cursor: pointer;
		}
	</style>
	<?php echo '<script'; ?>
>
		document.addEventListener('DOMContentLoaded', function () {
			const popupKey = 'hideUpdatePopupUntil';
			const now = Date.now();

			// Kiểm tra xem có lưu thời gian tắt không
			const hideUntil = localStorage.getItem(popupKey);

			//if (!hideUntil || now > parseInt(hideUntil)) {
				// Nếu chưa lưu hoặc đã hết hạn thì hiển thị lại popup
				document.getElementById('updatePopupOverlay').style.display = 'flex';
			//}
		});

		function closeUpdatePopup() {
			document.getElementById('updatePopupOverlay').style.display = 'none';

			// Thiết lập thời gian ẩn popup trong 24 giờ (tính bằng mili giây)
			//const hideDuration = 24 * 60 * 60 * 1000; // 24 giờ
			const hideDuration = 1 * 60 * 1000; // 5 phut
			const hideUntil = Date.now() + hideDuration;

			localStorage.setItem('hideUpdatePopupUntil', hideUntil.toString());
		}
	<?php echo '</script'; ?>
>

<div id="updatePopupOverlay" style="display:none;">
	<div id="updatePopup">
		<button class="close" onclick="closeUpdatePopup()">×</button>
		<h2>Thông báo cập nhật</h2>
		<p>Tài khoản của bạn còn một bước nữa là hoàn thiện, hãy cập nhật để trải nghiệm tốt nhất.</p>
		<a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/user_iMember/" class="btn">Cập nhật ngay</a>
	</div>
</div>
<?php }
}?>

<div class="container" style="text-align:center">
	<h1 class="topiccontent">Giỏ hàng</h1>
</div>
<div class="container" style="padding-bottom:30px;">
	<div class="wt-rounded-02 wt-bg-denim-tint wt-width-full wt-display-flex-xs" style="padding:10px">
		<div class="col-xs-2 col-sm-1 col-md-1" aria-hidden="true">
                <span class="inline-svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" width="48" height="48" aria-hidden="true" focusable="false">

            <g id="e0NMFoeIPOT2_to" transform="translate(44.162561,5.846695)">
                <g id="e0NMFoeIPOT2_tr" transform="rotate(-5)">
                    <g transform="translate(-44.150002,-6.29719)">
                        <path d="M34.7,33.1l4.4-4.4c4.8-4.8,4.8-12.6,0-17.4v0c-4-4-10.1-4.9-14.7-2.1L17.7,15l17,18.1Z" fill="#4d6bc6"></path>
                        <path d="M36.5,33.5l-2.2-2.2l3.6-3.6c4.2-4.2,4.2-11,0-15.2C34.4,9,29,8.4,25.1,10.8L23.5,8.2C28.6,5,35.6,5.8,40.1,10.3c5.4,5.4,5.4,14.2,0,19.6l-3.6,3.6Z" fill="#222"></path>
                    </g>
                </g>
            </g>
            <g id="e0NMFoeIPOT5_to" transform="translate(4.2,5.697011)">
                <g id="e0NMFoeIPOT5_tr" transform="rotate(5)">
                    <g transform="translate(-3.85,-6.297191)">
                        <path d="M40.5,25.2l-4.8-4.8v0l-9-9c-4.8-4.8-12.6-4.8-17.4,0s-4.9,12.6-.1,17.4L15.4,35v0l4.4,4.4c1.2,1.2,3.2,1.2,4.4,0s1.2-3.2,0-4.4l-1.7-1.7l3.9,3.9c1.2,1.2,3.2,1.2,4.4,0s1.2-3.2,0-4.4l1.1,1.1c1.2,1.2,3.2,1.2,4.4,0v0c1.2-1.2,1.2-3.2,0-4.4l-4.9-4.9v0l4.9,4.9c1.2,1.2,3.2,1.2,4.4,0c1-1.2,1-3.1-.2-4.3Z" fill="#d7e6f5"></path>
                        <path d="M42.7,27.4c0-1.2-.5-2.4-1.4-3.3l-4.8-4.8v0l-9-9c-5.4-5.4-14.2-5.4-19.6,0s-5.4,14.2,0,19.6l6.2,6.2v0l4.4,4.4c.9.9,2.1,1.3,3.3,1.3s2.4-.4,3.3-1.3c.4-.4.7-.9,1-1.5.7.4,1.5.6,2.3.6c1.2,0,2.4-.4,3.3-1.3.6-.6,1-1.3,1.2-2c.3.1.7.1,1,.1c1.2,0,2.4-.5,3.3-1.4.8-.8,1.3-1.9,1.3-3c1.1-.1,2.2-.5,3-1.3.7-.9,1.2-2.1,1.2-3.3Zm-3.6,1.1c-.6.6-1.6.6-2.2,0l-7.6-7.6L27.2,23l7.6,7.6c.6.6.6,1.6,0,2.2s-1.6.6-2.2,0l-1.1-1.1L25,25.2l-2.2,2.2l6.5,6.5c.6.6.6,1.6,0,2.2s-1.6.6-2.2,0L25,33.9l-4.4-4.4-2.2,2.2l4.4,4.4c.6.6.6,1.6,0,2.2s-1.6.6-2.2,0l-1.9-1.9v0L10,27.7c-4.2-4.2-4.2-11,0-15.2s11-4.2,15.2,0l6.2,6.2v0L39,26.3c.3.3.5.7.5,1.1.1.4-.1.8-.4,1.1Z" fill="#222"></path>
                    </g>
                </g>
            </g>
            <g id="e0NMFoeIPOT8_to" transform="translate(28.52,15.1)">
                <g id="e0NMFoeIPOT8_tr" transform="rotate(-5)">
                    <g transform="translate(-27.765359,-14.148534)">
                        <path d="M32.3,15.1L23,19.8c-1.7,1.2-4.2.8-5.4-.9v0c-1.2-1.7-.8-4.1.9-5.4c2.1-1.5,4.7-3.4,5.6-3.9C28.7,6.7,35,7.4,39,11.4v0" fill="#4d6bc6"></path>
                        <path d="M19.4,14.7l1.9-1.4c1-.7,2-1.4,2.7-1.9.4-.3.7-.5.9-.6.7-.4,1.4-.7,2.1-.9c3.7-1.2,8-.3,10.9,2.6l2.2-2.2c-4.2-4.2-10.9-5.2-16-2.5-.3.1-.5.3-.8.4-.4.3-1.3.9-2.3,1.6-.5.3-.9.7-1.4,1l-1.9,1.4c-2.4,1.7-3,5.1-1.3,7.5.8,1.2,2.1,2,3.5,2.2.3.1.6.1.9.1c1.1,0,2.2-.3,3.1-1l5.9-4.1l2.6-1.8-2.2-2.2-2.6,1.8-5.4,3.8c-.5.4-1.1.5-1.7.4s-1.1-.4-1.5-1c-.9-1-.6-2.5.4-3.2Z" fill="#222"></path>
                    </g>
                </g>
            </g>
        </svg></span>
		</div>
		<p class="wt-text-black wt-text-caption">
			Bạn cần điền đầy đủ thông tin, thanh toán chuyển khoản, gửi chứng từ thanh toán để xác nhận.
			Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo
			<a href="#" class="wt-text-link" target="_blank">
				Điều khoản của Thuận Phát
			</a>
		</p>
	</div>
	<div class="row" style="padding-top:30px">


			<div class="col-xs-12 col-sm-8 col-md-8 account">
				<form name="updatebasket" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/view_basket//" method="post" enctype="multipart/form-data">
					<input type="hidden" name="product_id" value="" />
					<input type="hidden" name="op" value="view_basket" />
					<input type="hidden" name="ret_page" value="<?php echo $_smarty_tpl->tpl_vars['ret_page']->value;?>
" />
					<div class="col-xs-12 col-sm-12 col-md-12 d-none d-lg-flex" style="padding:0px; padding-bottom:10px;">
						<div class="col-xs-12 col-sm-12 col-md-6"><strong>Sản phẩm</strong></div>
					<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: center; vertical-align: middle; padding-top:10px">
						<div class="col-xs-3 col-sm-4 col-md-4"  style="text-align: center; vertical-align: middle;"><strong>Đơn giá</strong></div>
						<div class="col-xs-3 col-sm-3 col-md-3"  style="text-align: center; vertical-align: middle;"><strong>Số lượng</strong></div>
						<div class="col-xs-4 col-sm-4 col-md-4" style="text-align: center; vertical-align: middle;"><strong>Thành tiền</strong></div>
						<div class="col-xs-2 col-sm-1 col-md-1"  style="text-align: center; vertical-align: middle;"></div>
					</div>
					</div>


				<?php $_smarty_tpl->_assignInScope('total', 0);?>
				<?php $_smarty_tpl->_assignInScope('totalquantity', 0);?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrProductBasket']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
					<div class="row" style="border-top:1px dotted #CCCCCC; padding:0px; padding-bottom:10px; padding-top:10px;">
						<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: left; vertical-align: middle; padding-left:5px;">
							<div class="col-xs-4 col-sm-4 col-md-4"  style="text-align: left; vertical-align: middle; padding-left:5px;">
								<div class="item-recruit">
									<div class="avarta">
									<a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" border="0" style="height: 100px"/></a>
									</div>
								</div>
							</div>
							<div class="col-xs-8 col-sm-8 col-md-8"  style="text-align: left; vertical-align: middle;">
								<div><a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
" class="content"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: center; vertical-align: middle; padding-top:20px">

							<div class="col-xs-3 col-sm-4 col-md-4"  style="text-align: center; vertical-align: middle;  padding-left:5px;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['item']->value['price']),$_smarty_tpl ) );?>
</div>
							<div class="col-xs-3 col-sm-3 col-md-3"  style="text-align: center; vertical-align: middle;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="25%" align="center"><div class="quantity-decrease" onclick="qtyDown(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,'edit_basket')"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/theme_images/giam.png" border="0" style="cursor:pointer"></div></td>
										<td  width="50%" align="center"><div><input type="text" name="quantity<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['quantity'];?>
" id="qty<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" maxlength="12"  title="Quantity" class="input-text qty" onkeyup="onSubmit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,'edit_basket')" style="border-radius: 0.2rem; border:1px solid #CCCCCC; width:30px; text-align:center"/>
											</div></td>
										<td  width="25%" align="center"><div class="quantity-increase-right" onclick="qtyUp(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,'edit_basket')"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/theme_images/tang.png" border="0"  style="cursor:pointer;"></div></td>
									</tr>
								</table>

							</div>
							<div class="col-xs-4 col-sm-4 col-md-4" style="text-align: center; vertical-align: middle;">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['item']->value['price']*$_smarty_tpl->tpl_vars['item']->value['quantity']),$_smarty_tpl ) );?>

							</div>
							<div class="col-xs-2 col-sm-1 col-md-1"  style="text-align: center; vertical-align: middle;"><input type="image" src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/theme_images/deletecart.png" style="width:20px" onclick="onSubmit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,'delete_basket')" title="Remove" alt="Remove" /></div>
						</div>
					</div>
					<?php $_smarty_tpl->_assignInScope('total', $_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['item']->value['price']*$_smarty_tpl->tpl_vars['item']->value['quantity']);?>
					<?php $_smarty_tpl->_assignInScope('totalquantity', $_smarty_tpl->tpl_vars['totalquantity']->value+$_smarty_tpl->tpl_vars['item']->value['quantity']);?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</form>
			</div>



			<div class="col-xs-12 col-sm-4 col-md-4">
				<form name="frmbasket" id="frmbasket" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/basket/" method="post" enctype="multipart/form-data">
					<input type="hidden" name="product_id" value="" />
					<input type="hidden" name="f" value="order" />
					<input type="hidden" name="ret_page" value="<?php echo $_smarty_tpl->tpl_vars['ret_page']->value;?>
" />
					<input type="hidden" name="gioithieu" value="<?php echo $_smarty_tpl->tpl_vars['gioithieu']->value;?>
" />
					<input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['MemberID']->value;?>
" />
				<div style="text-align: left; padding-top:10px;" class="h4">Tổng số sản phẩm: <?php echo $_smarty_tpl->tpl_vars['totalquantity']->value;?>
<input type="hidden" name="quantity" value="<?php echo $_smarty_tpl->tpl_vars['totalquantity']->value;?>
" /></div>
				<div style="text-align: left;" class="h4">Tổng tiền: &nbsp;&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl ) );?>
<input type="hidden" name="tong" value="<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
" /></div>

				<div class="wt-mt-xs-1 wt-mb-xs-2 wt-bt-xs"></div>

				<div class="wt-mt-xs-1 wt-mb-xs-2 wt-bt-xs"></div>
				<?php if (!$_smarty_tpl->tpl_vars['username']->value) {?>

				<div id="logreg-forms">

					<div name="loginForm"  class="form-horizontal&#x20;form-signin" id="form-signin" >

												<div class="wt-btn wt-btn--filled wt-width-full" style="margin-bottom:20px">
							<span  data-toggle="modal" data-target="#exampleModalIn">  Đăng nhập (hoặc đăng ký) </span>
						</div>

					</div>

					<div name="frmRegisterUser" id="frmSignup"  class="form-signup">
						<div><h3 style="text-transform:uppercase" class="title">Địa chỉ nhận hàng</h3></div>

						<div ><input placeholder="Họ và tên" type="text" name="name" class="text" /></div>
						<div ><input placeholder="Email" type="text" name="email" class="text" /><label id="lblCheckMail" style="font-size:11px; color:#FF0000"></label></div>

						<div><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text"  onchange="isValidmobile(document.frmRegisterUser.mobile.value)" /><label id="lblCheckmobile" style="font-size:11px; color:#FF0000"></label></div>
						<div><input placeholder="Địa chỉ nhận hàng"  name="address" style="width:100%" class="text"></div>
						<div>
							<textarea name="otherinfo" class="text" style="width:100%; height:120px" placeholder="Lời nhắn"></textarea>
						</div>


						<div ><input type="button" class="btn btn-primary" value="Tiếp tục thanh toán" onClick="checkSendMail(document.frmbasket);" style="width:100%;"/></div>
						<div><a href="#" id="cancel_signup">Đăng nhập (hoặc đăng ký)</a></div>
					</div>
				</div>
				<?php } else { ?>
				<div>
					<div class="card-header bg-warning text-dark">
						💳 Quét mã để thanh toán
					</div>
					<div class="card-body text-center">
						<p>Vui lòng quét mã VietQR để thanh toán:</p>
						<img src="https://img.vietqr.io/image/VCB-0251001521762-compact2.png?amount=<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
&addInfo=THANH%20TOAN%20DON%20HANG%20<?php echo $_smarty_tpl->tpl_vars['Membermobile']->value;?>
"
							 alt="QR thanh toán" class="img-fluid" style="max-width:300px;">
											</div>
				</div>
				<div>
					<div><strong>Upload ảnh chứng từ thanh toán</strong><br />
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>

								<td>
									<div id="previewWrapper" style="margin: 10px 0;">
										<img id="previewImg" src="<?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {
echo @constant('_DOMAIN_ROOT_URL');?>
/images/order/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];
}?>" style="width:100%;" <?php if (!$_smarty_tpl->tpl_vars['arr']->value['img']) {?>style="display:none"<?php }?> />
									</div>

									<input type="file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage(event)" />
									<input type="hidden" name="fileName" id="fileName" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />

									<div style="margin-top:10px; padding-bottom: 10px">
										<button type="button" onclick="removeImage()" class="btn btn-sm btn-danger">Xoá ảnh</button>
									</div>
									
										<?php echo '<script'; ?>
>
											function previewImage(event) {
												const file = event.target.files[0];
												const reader = new FileReader();
												reader.onload = function(e) {
													document.getElementById("previewImg").src = e.target.result;
													document.getElementById("previewImg").style.display = "block";
												};
												reader.readAsDataURL(file);
											}

											function removeImage() {
												document.getElementById("previewImg").src = "";
												document.getElementById("previewImg").style.display = "none";
												document.getElementById("imageUpload").value = "";
												document.getElementById("fileName").value = "";
											}
										<?php echo '</script'; ?>
>
									
								</td>
							</tr>

						</table>
					</div>
					<div><h3 style="text-transform:uppercase" class="title">Địa chỉ nhận hàng</h3></div>

					<div ><input placeholder="Họ và tên" type="text" name="name" class="text" value="<?php echo $_smarty_tpl->tpl_vars['MemberName']->value;?>
" readonly="readonly"/></div>
					<div ><input placeholder="Email" type="text" name="email" class="text"  value="<?php echo $_smarty_tpl->tpl_vars['MemberEmail']->value;?>
" readonly="readonly"/></div>

					<div><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text" value="<?php echo $_smarty_tpl->tpl_vars['Membermobile']->value;?>
" /></div>
					<div><input placeholder="Địa chỉ nhận hàng"  name="address" style="width:100%" class="text"  value="<?php echo $_smarty_tpl->tpl_vars['MemberAddress']->value;?>
"></div>
					<div>
						<textarea name="otherinfo" class="text" style="width:100%; height:120px" placeholder="Lời nhắn"></textarea>
					</div>


					<div >
						<input type="button" class="btn btn-primary" id="submitBtn" value="Xác nhận" onClick="checkSendMail(document.frmbasket);" style="width:100%;"/>
						
					</div>

				</div>
				<?php }?>
				</form>
			</div>

		</div>
</div>


	<?php echo '<script'; ?>
>


		function toggleResetPswd(e){
			e.preventDefault();
			$('#logreg-forms .form-signin').toggle() // display:block or none
		}

		function toggleSignUp(e){
			e.preventDefault();
			$('#logreg-forms .form-signin').toggle(); // display:block or none
			$('#logreg-forms .form-signup').toggle(); // display:block or none
		}

		$(()=>{
			// Login Register Form
			$('#logreg-forms #forgot_pswd').click(toggleResetPswd);
			$('#logreg-forms #cancel_reset').click(toggleResetPswd);
			$('#logreg-forms #btn-signup').click(toggleSignUp);
			$('#logreg-forms #cancel_signup').click(toggleSignUp);
		});

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

			document.getElementById("custom-tooltip").style.display = "inline";
			document.execCommand("copy");
			setTimeout( function() {
				document.getElementById("custom-tooltip").style.display = "none";
			}, 1000);

		}

	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
		function qtyDown(product_id,op){
			//product_id = document.getElementById('product_id');
			qty_el = document.getElementById('qty'+product_id);
			qty = qty_el.value;
			if( !isNaN( qty ) && qty > 1 ){
				qty_el.value = parseInt(qty_el.value)-1	;

				document.updatebasket.product_id.value=product_id;
				document.updatebasket.op.value=op;
				document.updatebasket.submit();
			}
			return false;


		}
		function qtyUp(product_id,op){
			//product_id = document.getElementById('product_id');
			qty_el = document.getElementById('qty'+product_id);
			qty = qty_el.value;
			if( !isNaN( qty )) {
				qty_el.value = parseInt(qty_el.value)+1;
				document.updatebasket.product_id.value=product_id;
				document.updatebasket.op.value=op;
				document.updatebasket.submit();
			}
			return false;


		}

		//

	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 language="javascript">
		function onSubmit(product_id,op)
		{
			document.updatebasket.product_id.value=product_id;
			document.updatebasket.op.value=op;
			document.updatebasket.submit();
		}

	<?php echo '</script'; ?>
>

<?php }
}
