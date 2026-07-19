{literal}
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

	<script language="javascript">
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

			}else if(obj.fileName && tpudCashAmount > 0 && obj.fileName.value==""){
				alert("Đơn hàng cần chuyển khoản phần còn thiếu, vui lòng upload ảnh chứng từ thanh toán trước khi xác nhận.");
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
	</script>
	<style>
		.wt-bg-denim-tint {
			background-color: #e5e7eb !important;
		}
		/* assets/css/bootstrap.min.css (v4, flex grid) va skins/frontend/css/bootstrap.min.css (v3, float
		   grid) cung duoc load tren trang nay (header.tpl) - .row ke thua display:flex tu ban v4 khien
		   2 cot "col-xs-12" (khong co trong v4) chi nhan duoc width:100% tu v3 ma khong co flex-basis
		   tuong ung, gay khoang trong bat thuong khi wrap tren mobile. Ep display:block rieng cho hang
		   san pham/thanh toan de 2 ban Bootstrap khong xung dot, khong sua 2 file bootstrap.min.css dung
		   chung toan site. */
		.tpud-basket-grid {
			display: block !important;
		}
		.tpud-basket-grid:after {
			content: "";
			display: table;
			clear: both;
		}
		.tpud-basket-grid > [class*="col-"] {
			box-sizing: border-box;
		}
		@media (min-width: 768px) {
			.tpud-basket-grid > [class*="col-"] {
				float: left;
			}
		}
		@media (max-width: 767px) {
			.tpud-basket-grid > [class*="col-"] {
				width: 100% !important;
				float: none !important;
			}
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
					background-color: #e5e7eb !important;
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

{/literal}
{if $username}
{if empty($cmt) || empty($img) || empty($img1)}

	{literal}
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
	<script>
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
	</script>
{/literal}
<div id="updatePopupOverlay" style="display:none;">
	<div id="updatePopup">
		<button class="close" onclick="closeUpdatePopup()">×</button>
		<h2>Thông báo cập nhật</h2>
		<p>Tài khoản của bạn còn một bước nữa là hoàn thiện, hãy cập nhật để trải nghiệm tốt nhất.</p>
		<a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" class="btn">Cập nhật ngay</a>
	</div>
</div>
{/if}{/if}

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
{if $arrProductBasket}
	<div style="padding-top:30px">
		<div class="account">
			<form name="updatebasket" action="{$smarty.const._DOMAIN_ROOT_URL}/view_basket//" method="post" enctype="multipart/form-data">
				<input type="hidden" name="product_id" value="" />
				<input type="hidden" name="op" value="view_basket" />
				<input type="hidden" name="ret_page" value="{$ret_page}" />
				<div class="col-xs-12 col-sm-12 col-md-12 d-none d-lg-flex" style="padding:0px; padding-bottom:10px;">
					<div class="col-xs-12 col-sm-12 col-md-6"><strong>Sản phẩm</strong></div>
				<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: center; vertical-align: middle; padding-top:10px">
					<div class="col-xs-3 col-sm-4 col-md-4"  style="text-align: center; vertical-align: middle;"><strong>Đơn giá</strong></div>
					<div class="col-xs-3 col-sm-3 col-md-3"  style="text-align: center; vertical-align: middle;"><strong>Số lượng</strong></div>
					<div class="col-xs-4 col-sm-4 col-md-4" style="text-align: center; vertical-align: middle;"><strong>Thành tiền</strong></div>
					<div class="col-xs-2 col-sm-1 col-md-1"  style="text-align: center; vertical-align: middle;"></div>
				</div>
				</div>


			{assign var="total" value=0}
			{assign var="totalquantity" value=0}
			{foreach key=key item=item from=$arrProductBasket}
				<div class="row" style="border-top:1px dotted #CCCCCC; padding:0px; padding-bottom:10px; padding-top:10px;">
					<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: left; vertical-align: middle; padding-left:5px;">
						<div class="col-xs-4 col-sm-4 col-md-4"  style="text-align: left; vertical-align: middle; padding-left:5px;">
							<div class="item-recruit">
								<div class="avarta">
								<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" border="0" style="height: 100px"/></a>
								</div>
							</div>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8"  style="text-align: left; vertical-align: middle;">
							<div><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}" class="content">{$item.name}</a></div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6"  style="text-align: center; vertical-align: middle; padding-top:20px">

						<div class="col-xs-3 col-sm-4 col-md-4"  style="text-align: center; vertical-align: middle;  padding-left:5px;">{format_number number=$item.price}</div>
						<div class="col-xs-3 col-sm-3 col-md-3"  style="text-align: center; vertical-align: middle;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25%" align="center"><div class="quantity-decrease" onclick="qtyDown({$key},'edit_basket')"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/giam.png" border="0" style="cursor:pointer"></div></td>
									<td  width="50%" align="center"><div><input type="text" name="quantity{$key}" value="{$item.quantity}" id="qty{$key}" maxlength="12"  title="Quantity" class="input-text qty" onkeyup="onSubmit({$key},'edit_basket')" style="border-radius: 0.2rem; border:1px solid #CCCCCC; width:30px; text-align:center"/>
										</div></td>
									<td  width="25%" align="center"><div class="quantity-increase-right" onclick="qtyUp({$key},'edit_basket')"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/tang.png" border="0"  style="cursor:pointer;"></div></td>
								</tr>
							</table>

						</div>
						<div class="col-xs-4 col-sm-4 col-md-4" style="text-align: center; vertical-align: middle;">
							{format_number number=$item.price*$item.quantity}
						</div>
						<div class="col-xs-2 col-sm-1 col-md-1"  style="text-align: center; vertical-align: middle;"><input type="image" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/deletecart.png" style="width:20px" onclick="onSubmit({$key},'delete_basket')" title="Remove" alt="Remove" /></div>
					</div>
				</div>
				{assign var="total" value=$total+$item.price*$item.quantity}
				{assign var="totalquantity" value=$totalquantity+$item.quantity}
			{/foreach}
			</form>
		</div>
	</div>

	<div style="padding-top:20px;">
		<div class="account">
			<form name="frmbasket" id="frmbasket" action="{$smarty.const._DOMAIN_ROOT_URL}/basket/" method="post" enctype="multipart/form-data">
				<input type="hidden" name="product_id" value="" />
				<input type="hidden" name="f" value="order" />
				<input type="hidden" name="ret_page" value="{$ret_page}" />
				<input type="hidden" name="gioithieu" value="{$gioithieu}" />
				<input type="hidden" name="user_id" value="{$MemberID}" />
				<div style="text-align: left; font-weight:700;" class="h4">Tổng số sản phẩm: {$totalquantity}<input type="hidden" name="quantity" value="{$totalquantity}" /></div>
				<div style="text-align: left; font-weight:700; padding-bottom:15px;" class="h4">Tổng tiền: &nbsp;&nbsp;{format_number number=$total}<input type="hidden" name="tong" value="{$total}" /></div>

				{if !$username}

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
				{else}
				<div class="row tpud-basket-grid">
					<div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom:15px;">
						<div style="border:1px solid #e2e2e2; border-radius:6px; padding:12px; background:#fff;">
							<strong>Chọn nguồn thanh toán</strong>
							<div style="margin-top:8px;">
								{if $acceptCard}
								<label style="display:block; margin-bottom:6px;">
									<input type="checkbox" name="use_card" id="use_card" value="1" onchange="updatePaymentPreview()" {if $cardBalance<=0}disabled{/if} />
									<strong style="color:#b45309;">Điểm thẻ tiêu dùng</strong> (số dư: {format_number2 number=$cardBalance}, tối đa {$cardPaymentPercent}% giá trị đơn)
								</label>
								{/if}
								{if $acceptTichLuy}
								<label style="display:block; margin-bottom:6px;">
									<input type="checkbox" name="use_tich_luy" id="use_tich_luy" value="1" onchange="updatePaymentPreview()" {if $tichLuyBalance<=0}disabled{/if} />
									<strong style="color:#b45309;">Tích lũy tiêu dùng</strong> (số dư: {format_number2 number=$tichLuyBalance})
								</label>
								{/if}
								{if $acceptTieuDung}
								<label style="display:block; margin-bottom:6px;">
									<input type="checkbox" name="use_tieu_dung" id="use_tieu_dung" value="1" onchange="updatePaymentPreview()" {if $tieuDungBalance<=0}disabled{/if} />
									<strong style="color:#b45309;">Ví tiêu dùng</strong> (số dư: {format_number2 number=$tieuDungBalance})
								</label>
								{/if}
								{if $acceptKhaDung}
								<label style="display:block; margin-bottom:6px;">
									<input type="checkbox" name="use_kha_dung" id="use_kha_dung" value="1" onchange="updatePaymentPreview()" {if $khaDungBalance<=0}disabled{/if} />
									<strong style="color:#b45309;">Ví khả dụng</strong> (số dư: {format_number2 number=$khaDungBalance})
								</label>
								{/if}
								{if !$acceptCard && !$acceptTichLuy && !$acceptTieuDung && !$acceptKhaDung}
								<div style="color:#92400e;">Các sản phẩm trong giỏ chỉ chấp nhận thanh toán chuyển khoản.</div>
								{/if}
							</div>
							<div id="paymentPreview" style="margin-top:10px; font-size:14px; background:#f8f9fa; color:#1f2937; padding:8px; border-radius:4px;"></div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom:15px;">
						<div style="border:1px solid #e2e2e2; border-radius:6px; padding:12px; background:#fff; text-align:center;">
							<strong>Chứng từ thanh toán</strong>
							<p style="margin-top:8px; margin-bottom:6px;">Vui lòng quét mã VietQR để thanh toán:</p>
							<img id="paymentQrImg" data-base-url="https://img.vietqr.io/image/TCB-1316833888-compact2.png?addInfo=THANH%20TOAN%20DON%20HANG%20{$Membermobile}" src="https://img.vietqr.io/image/TCB-1316833888-compact2.png?amount={$total}&addInfo=THANH%20TOAN%20DON%20HANG%20{$Membermobile}"
								 alt="QR thanh toán" class="img-fluid" style="max-width:220px; width:100%;">

							<div style="text-align:left; margin-top:12px;">
								<strong>Upload ảnh chứng từ thanh toán</strong>
								<div id="previewWrapper" style="margin: 10px 0;">
									<img id="previewImg" src="{if $arr.img}{$smarty.const._DOMAIN_ROOT_URL}/images/order/{$arr.img}{/if}" style="width:100%;" {if !$arr.img}style="display:none"{/if} />
								</div>

								<input type="file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage(event)" />
								<input type="hidden" name="fileName" id="fileName" value="{$arr.img}" />

								<div style="margin-top:10px;">
									<button type="button" onclick="removeImage()" class="btn btn-sm btn-danger">Xoá ảnh</button>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom:15px;">
						<div style="border:1px solid #e2e2e2; border-radius:6px; padding:12px; background:#fff;">
							<h3 style="text-transform:uppercase; margin-top:0; font-size:16px;">Địa chỉ nhận hàng</h3>

							<div ><input placeholder="Họ và tên" type="text" name="name" class="text" value="{$MemberName}" readonly="readonly"/></div>
							<div ><input placeholder="Email" type="text" name="email" class="text"  value="{$MemberEmail}" readonly="readonly"/></div>

							<div><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text" value="{$Membermobile}" /></div>
							<div><input placeholder="Địa chỉ nhận hàng"  name="address" style="width:100%" class="text"  value="{$MemberAddress}"></div>
							<div>
								<textarea name="otherinfo" class="text" style="width:100%; height:80px" placeholder="Lời nhắn"></textarea>
							</div>

							<div style="margin-top:8px;">
								<input type="button" class="btn btn-primary" id="submitBtn" value="Xác nhận" onClick="checkSendMail(document.frmbasket);" style="width:100%;"/>
							</div>
						</div>
					</div>
				</div>

{literal}
<script>
	var tpudTotalAmount = {/literal}{$total|default:0}{literal};
	var tpudCardBalance = {/literal}{$cardBalance|default:0}{literal};
	var tpudTichLuyBalance = {/literal}{$tichLuyBalance|default:0}{literal};
	var tpudTieuDungBalance = {/literal}{$tieuDungBalance|default:0}{literal};
	var tpudKhaDungBalance = {/literal}{$khaDungBalance|default:0}{literal};
	var tpudCardPaymentPercent = {/literal}{$cardPaymentPercent|default:100}{literal};
	var tpudCashAmount = 0;

	function tpudFormatMoney(n) {
		return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	function updatePaymentPreview() {
		var remaining = tpudTotalAmount;
		var cardAmount = 0, tichLuyAmount = 0, tieuDungAmount = 0, khaDungAmount = 0;

		if (document.getElementById("use_card") && document.getElementById("use_card").checked) {
			var maxCardByPercent = tpudTotalAmount * (tpudCardPaymentPercent / 100);
			cardAmount = Math.min(remaining, maxCardByPercent, tpudCardBalance);
			remaining -= cardAmount;
		}
		if (document.getElementById("use_tich_luy") && document.getElementById("use_tich_luy").checked) {
			tichLuyAmount = Math.min(remaining, tpudTichLuyBalance);
			remaining -= tichLuyAmount;
		}
		if (document.getElementById("use_tieu_dung") && document.getElementById("use_tieu_dung").checked) {
			tieuDungAmount = Math.min(remaining, tpudTieuDungBalance);
			remaining -= tieuDungAmount;
		}
		if (document.getElementById("use_kha_dung") && document.getElementById("use_kha_dung").checked) {
			khaDungAmount = Math.min(remaining, tpudKhaDungBalance);
			remaining -= khaDungAmount;
		}

		var cashAmount = remaining;
		tpudCashAmount = cashAmount;

		var previewEl = document.getElementById("paymentPreview");
		if (previewEl) {
			previewEl.innerHTML =
				"Điểm thẻ: " + tpudFormatMoney(cardAmount) + "<br>" +
				"Tích lũy tiêu dùng: " + tpudFormatMoney(tichLuyAmount) + "<br>" +
				"Ví tiêu dùng: " + tpudFormatMoney(tieuDungAmount) + "<br>" +
				"Ví khả dụng: " + tpudFormatMoney(khaDungAmount) + "<br>" +
				"<strong>Còn lại chuyển khoản: " + tpudFormatMoney(cashAmount) + "</strong>";
		}

		var qrImg = document.getElementById("paymentQrImg");
		if (qrImg) {
			var base = qrImg.getAttribute("data-base-url");
			qrImg.src = base + "&amount=" + Math.round(cashAmount);
		}
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", updatePaymentPreview);
	} else {
		updatePaymentPreview();
	}
</script>
{/literal}
				{literal}
					<script>
						function previewImage(event) {
							const file = event.target.files[0];
							const reader = new FileReader();
							reader.onload = function(e) {
								document.getElementById("previewImg").src = e.target.result;
								document.getElementById("previewImg").style.display = "block";
							};
							reader.readAsDataURL(file);
							document.getElementById("fileName").value = file.name;
						}

						function removeImage() {
							document.getElementById("previewImg").src = "";
							document.getElementById("previewImg").style.display = "none";
							document.getElementById("imageUpload").value = "";
							document.getElementById("fileName").value = "";
						}
					</script>
				{/literal}
				{/if}
			</form>
		</div>
	</div>
{else}
	<div style="text-align:center; padding-top:60px; padding-bottom:60px; color:#8D0100"><b>Không có sản phẩm nào trong giỏ hàng</b></div>
{/if}
</div>

{if $username}
<div class="container" style="padding-bottom:30px;">
	<div class="row" style="padding-top:20px;">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="card" style="background-color:#f3f4f6 !important; color:#1f2937 !important; border:1px solid #e2e2e2; border-radius:6px; padding:16px;">
			<h3 style="text-transform:uppercase; margin-top:0; margin-bottom:20px; font-weight:bold;">Thống kê đơn hàng của bạn</h3>

			<form method="get" action="{$smarty.const._DOMAIN_ROOT_URL}/" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; margin-bottom:16px;">
				<input type="hidden" name="m" value="basket">
				<input type="hidden" name="op" value="view_basket">
				<div>
					<label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Trạng thái</label>
					<select name="order_status" class="form-control" style="min-width:150px;">
						<option value="">Tất cả</option>
						{foreach key=st_key item=st_label from=$orderStatusLabel}
						<option value="{$st_key}" {if $orderFilterStatus==$st_key}selected{/if}>{$st_label}</option>
						{/foreach}
					</select>
				</div>
				<div>
					<label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Từ ngày</label>
					<input type="date" name="order_from" class="form-control" value="{$orderFilterFrom|escape}">
				</div>
				<div>
					<label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Đến ngày</label>
					<input type="date" name="order_to" class="form-control" value="{$orderFilterTo|escape}">
				</div>
				<div style="display:flex; gap:8px;">
					<button type="submit" class="btn btn-primary">Lọc</button>
					<a href="{$smarty.const._DOMAIN_ROOT_URL}/view_basket/" class="btn btn-secondary">Xóa lọc</a>
				</div>
			</form>

			{if $ownOrders}
			<div style="overflow-x:auto;">
			<table class="table table-bordered table-striped">
				<thead>
				<tr>
					<th>Mã đơn</th>
					<th>Ngày đặt</th>
					<th>Tổng tiền</th>
					<th>Điểm thẻ</th>
					<th>Tích lũy tiêu dùng</th>
					<th>Ví tiêu dùng</th>
					<th>Ví khả dụng</th>
					<th>Tiền mặt</th>
					<th>Trạng thái</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				{foreach item=ord from=$ownOrders}
				<tr>
					<td>#{$ord.id}</td>
					<td>{$ord.created_at_fmt}</td>
					<td><strong>{format_number number=$ord.amount}</strong></td>
					<td>{format_number number=$ord.card_amount}</td>
					<td>{format_number number=$ord.tich_luy_amount}</td>
					<td>{format_number number=$ord.tieu_dung_amount}</td>
					<td>{format_number number=$ord.kha_dung_amount}</td>
					<td><strong>{format_number number=$ord.cash_amount}</strong></td>
					<td>{$ord.status_label}</td>
					<td>
						<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#orderDetailModal{$ord.id}">Xem chi tiết</button>
					</td>
				</tr>
				{/foreach}
				</tbody>
			</table>
			</div>
			{else}
			<div>Không có đơn hàng nào phù hợp bộ lọc.</div>
			{/if}
		</div>
	</div>
	</div>
</div>

{foreach item=ord from=$ownOrders}
<div class="modal fade" id="orderDetailModal{$ord.id}" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Chi tiết đơn hàng #{$ord.id}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
					<tr><th>Sản phẩm</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr>
					</thead>
					<tbody>
					{foreach item=it from=$ord.items}
					<tr>
						<td>{$it.name}</td>
						<td>{format_number number=$it.price}</td>
						<td>{$it.quantity}</td>
						<td>{format_number number=$it.price*$it.quantity}</td>
					</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
{/foreach}
{/if}
{literal}

	<script>


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

	</script>
	<script type="text/javascript">
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

	</script>
	<script language="javascript">
		function onSubmit(product_id,op)
		{
			document.updatebasket.product_id.value=product_id;
			document.updatebasket.op.value=op;
			document.updatebasket.submit();
		}

	</script>

{/literal}
