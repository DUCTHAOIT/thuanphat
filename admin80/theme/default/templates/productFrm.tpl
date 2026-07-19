<style type="text/css">
	@import url(js/jscalendar/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
<script type="text/javascript">
	// Chặn ngay ở client trước khi submit (bổ sung 2026-07-16): validate lại ở server (action.php) vẫn giữ
	// nguyên làm lớp an toàn cuối, nhưng nếu chặn ở đó thì trang phải load lại form từ DB, mất hết dữ liệu
	// admin vừa nhập các trường khác. Chặn ở đây để admin sửa ngay tại chỗ, không mất gì.
	function validateProductForm(f) {
		var commission = parseFloat((f.commission_amount.value || "0").replace(/[.,]/g, "")) || 0;
		var priceNew = parseFloat((f.price_new.value || "0").replace(/[.,]/g, "")) || 0;
		if (priceNew > 0 && commission >= priceNew) {
			alert("Hoa hồng sản phẩm phải nhỏ hơn giá niêm yết.");
			f.commission_amount.focus();
			return false;
		}
		return true;
	}
</script>
<form name="frmmain" action="?m=product" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm(this);">
	<input type="hidden" name="op" value="addProduct" />
	<input type="hidden" name="id" value="{$id}" />
	<input type="hidden" name="imgsmall" value="{$arr.img}" />
	<input type="hidden" name="imgbig" value="{$arr.img1}" />
	<input type="hidden" name="filePDF" value="{$arr.pdf}" />
	<h2>Thêm mới</h2>
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr>
			<td nowrap="nowrap" style="padding-right:10px">
				<table border="0" cellspacing="5" cellpadding="0" width="100%">
					<tr>
						<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Đầu mục: </td>
						<td width="50%" style="padding-top:10px">
							<select name="catID" id="catID" style="border:1px solid #cccccc;" onchange="technical();">
								{foreach key=key item=item from=$arrTopicProduct}
								{if $item.id==$arr.catID}
								<option value="{$key}" selected="selected">{if $item.level=='1'}&nbsp; &nbsp; {elseif
									$item.level=='2'}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
								{else}
								<option value="{$key}" style="padding-left:15px; padding-right:10px">{if
									$item.level=='1'} &nbsp; &nbsp; {elseif $item.level=='2'}&nbsp; &nbsp;&nbsp;
									&nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
								{/if}
								{/foreach}
							</select>
						</td>
						<td width="25%" rowspan="4" valign="bottom" style="padding-top:10px">
							<div>Ảnh đại diện (kích thước khuyến nghị w:1000px - h:600px)<br />
								<em style="color:#666666"></em>
							</div>
							<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img
										src="{$arr.imgs_view}" border="0" style="max-width:300px" /></a></div><label
								style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label>
						</td>
						<!--
        <td width="25%" rowspan="6" valign="bottom" style="padding-top:10px"><div><strong>{$Photo_big_size}</strong><br />
	      <em style="color:#666666">(w: 270px - h: 180px)</em></div>
		<div id="imgbigv"><a href="#" onclick="WindowUpload('imgbig')"><img src="{$arr.imgb_view}" border="0" /></a></div><label style="cursor:pointer" onclick="removeImg2()"><strong>Remove photo</strong></label></td>
        -->
					</tr>

					<tr>
						<td align="right" style="padding-right:10px;" nowrap="nowrap">Tên: </td>
						<td><input name="name" type="text" style="width:80%" class="text" maxlength="255"
								value="{$arr.name}" /></td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Sologan</td>
						<td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255"
								value="{$arr.promotion}" /></td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px; text-decoration:line-through" nowrap="nowrap">Giá
							cũ:</td>
						<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20"
								value="{$arr.price_old}" /></td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Giá niêm yết:</td>
						<td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20"
								value="{$arr.price}" /></td>
					</tr>

					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Tóm tắt</td>
						<td width="100%" colspan="3"><textarea name="summary" class="textarea"
								style="height:100">{$arr.summary}</textarea></td>
					</tr>

					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Nội dung:</td>
						<td colspan="3">{viewFckeditor content=$arr.content}</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Chính Sách Affiliate: </td>
						<td colspan="3">{viewFckeditor1 content1=$arr.tienich}</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Nổi bật:</td>
						<td>
							<input name="special_promotion" type="checkbox" {if $arr.special_promotion==1}
								checked="checked" {/if} />
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Combo kích hoạt:</td>
						<td>
							<input name="is_activation_combo" type="checkbox" {if $arr.is_activation_combo==1}
								checked="checked" {/if} />
							<em>(Đơn hàng mua sản phẩm này sẽ kích hoạt business_active cho khách)</em>
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Hoa hồng sản phẩm:</td>
						<td>
							<input name="commission_amount" type="text" style="width:80%" class="text" maxlength="20"
								value="{if !$arr.commission_amount}0{else}{$arr.commission_amount|string_format:"%.0f"}{/if}" />

						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Chấp nhận thanh toán bằng:</td>
						<td>
							<label><input name="accept_card_payment" type="checkbox" {if !$arr.id ||
									$arr.accept_card_payment==1} checked="checked" {/if} /> Điểm thẻ tiêu
								dùng</label>&nbsp;&nbsp;
							<label><input name="accept_tich_luy_payment" type="checkbox" {if !$arr.id ||
									$arr.accept_tich_luy_payment==1} checked="checked" {/if} /> Tích lũy tiêu
								dùng</label>&nbsp;&nbsp;
							<label><input name="accept_tieu_dung_payment" type="checkbox" {if !$arr.id ||
									$arr.accept_tieu_dung_payment==1} checked="checked" {/if} /> Ví tiêu
								dùng</label>&nbsp;&nbsp;
							<label><input name="accept_kha_dung_payment" type="checkbox" {if !$arr.id ||
									$arr.accept_kha_dung_payment==1} checked="checked" {/if} /> Ví khả dụng</label>
							<!-- <br /><em>(Chuyển khoản/tiền mặt luôn được chấp nhận, không tắt được. Giỏ hàng nhiều sản phẩm chỉ hiện nguồn được TẤT CẢ sản phẩm trong giỏ chấp nhận)</em> -->
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">Thứ tự:</td>
						<td><input type="text" class="text" name="sort" style="width:40"
								value="{if !$arr.sort}1{else}{$arr.sort}{/if}" /></td>
					</tr>

					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">{$Date_create}: </td>
						<td colspan="3"><input type="text" name="date" id="date" style="width:20%" class="text"
								value="{if $arr.date_create}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
							<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em>
						</td>
					</tr>

					<tr>
						<td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
						<td colspan="3"><input type="submit" class="btn btn-primary" value="{$Update}" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</form>
{literal}
<script language="Javascript1.2">
	$("#tongvondautu1,#tongvondautu2,#tongvondautu3,#sotienmotxuat1,#sotienmotxuat2,#sotienmotxuat3,#chietkhau12,#chietkhau1,#chietkhau22,#chietkhau2,#chietkhau32,#chietkhau3").on('keyup', function () {
		var n = parseInt($(this).val().replace(/\D/g, ''), 10);
		$(this).val(n.toLocaleString());
	});

	Calendar.setup(
		{
			inputField: "date",         // ID of the input field
			ifFormat: "%Y-%m-%d",    // the date format
			button: "btndate",       // ID of the button
			showsTime: true
		}
	);

	//
	//
	function removeImg() {
		document.getElementById('imgsmallv').innerHTML = "";
		document.frmmain.imgsmall.value = "";
	}
	//	
	function removeImg2() {
		document.getElementById('imgbigv').innerHTML = "";
		document.frmmain.imgbig.value = "";
	}
	//

	//
	//
	function manufacturers() {
		AjaxRequest.get(
			{
				'url': '?m=product&f=search_manufacturers&fid=' + document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
				, 'onSuccess': function (req) { document.getElementById('div_manufacturers').innerHTML = req.responseText; }
				, 'onError': function (req) { }
			}
		)
	}
	//
	//
	function xuatsu() {
		AjaxRequest.get(
			{
				'url': '?m=product&f=search_xuatsu&fid=' + document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
				, 'onSuccess': function (req) { document.getElementById('div_xuatsu').innerHTML = req.responseText; }
				, 'onError': function (req) { }
			}
		)
	}
	//
	function technical() {
		AjaxRequest.get(
			{
				'url': '?m=product&f=search_criteria&fid=' + document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
				, 'onSuccess': function (req) { document.getElementById('div_technical').innerHTML = req.responseText; }
				, 'onError': function (req) { }
			}
		)
	}
	//
	function logo_hang_san_xuat() {
		AjaxRequest.get(
			{
				'url': '?m=product&f=logo_hang_san_xuat&id_hang_san_xuat=' + document.frmmain.hang_san_xuat.value
				, 'onSuccess': function (req) { document.getElementById('div_logo_hang_san_xuat').innerHTML = req.responseText; }
				, 'onError': function (req) { }
			}
		)
	}
	manufacturers();
	xuatsu();
	//technical();
	//logo_hang_san_xuat();
</script>
{/literal}