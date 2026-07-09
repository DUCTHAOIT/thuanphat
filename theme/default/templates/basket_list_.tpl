{literal}
<script language="javascript">

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
 
<script language="javascript">
function checksame(){
if (document.getElementById("check_same").checked){

document.getElementById("ord_sname").value= document.getElementById("ord_name").value;
document.getElementById("ord_saddress").value= document.getElementById("ord_address").value;
document.getElementById("ord_semail").value= document.getElementById("ord_email").value;
document.getElementById("ord_sphone").value= document.getElementById("ord_phone").value;
document.getElementById("ord_smobile").value= document.getElementById("ord_mobile").value;
document.getElementById("ord_sfax").value= document.getElementById("ord_fax").value;
document.getElementById("ord_sotherinfo").value = document.getElementById("ord_otherinfo").value;
}
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr height="35">
	<td style="padding-top:10px; padding-left:35px; background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/title.gif); background-repeat:no-repeat; color:#e40f01; font-size:16px" class="title">Đặt hàng</td>
</tr>
</table>
 
<div style="padding-bottom:15px; padding-top:25px; color:#FF0000"><strong>Hướng dẫn:</strong> Để xóa sản phẩm khỏi giỏ hàng, click Xóa bỏ / Điền số lượng sản phẩm vào ô rồi click Cập nhật để thêm số lượng</div>
<table cellspacing="1" bordercolor="#c0c0c0" border="1" width="100%" style="border-collapse: collapse;">
		<form name="frmbasket" action="{$smarty.const._DOMAIN_ROOT_URL}/basket/" method="post" enctype="multipart/form-data">
		<input type="hidden" name="product_id" value="" />
		<input type="hidden" name="op" value="" />
		  <tr>
			<td class="title td">{$Amount}</td>
			<td class="title td">{$Product_name}</td>
			<td class="title td">{$Price}</td>
			<td class="title td">&nbsp;</td>
		  </tr>
		  {assign var="total" value="0"}
		  {foreach key=key item=item from=$arrProductBasket}
		   <tr>
			<td align="center">
			<input type="text" name="quantity{$key}" value="{$item.quantity}" size="15" style="text-align:center" onkeypress="return txtSymbolEnterKey({$key});" />
			<div style="padding-top:5px"><input type="image" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_update_cart.gif" onclick="onSubmit({$key},'edit_basket')" title="Update" /></div>
			</td>
			<td class="td">
			<!--
			<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}f=detail&{$smarty.const._ID_PRODUCT}={$key}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$item.img}" border="0"  width="130"/></a>
			-->
			<div class="title"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}f=detail&{$smarty.const._ID_PRODUCT}={$key}" class="title">{$item.name}</a></div></td>
			<td class="td">{format_number number=$item.price}</td>
			<td class="td"><input type="image" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_delete_cart.gif" onclick="onSubmit({$key},'delete_basket')" /></td>
		  </tr>
		  {assign var="total" value="$total+$item.price"}
		  {/foreach}
		   <tr>
			<td></td>
			<td align="right" style="padding-right:10px;" class="td"><strong>{$Total}: </strong></td>
			<td style="padding-left:10px">{format_number number=$total}</td>
			<td  class="td"><a href="/"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_continue_basket.gif" border="0"></a></td>
		  </tr>
 </table> 
	  

<table width="100%" cellpadding="5" cellspacing="2" class="content">
<tr>
<td colspan="2" class="title" bgcolor="#CCCCCC">Thông tin thanh toán</td>
</tr>
<tr>
<td></td>
<td style="color:#FF0000">Những mục có dấu * là phần bắt buộc phải nhập <font color="#FF0000">(*)</font>  là phần bắt buộc phải nhập .</td>
</tr>
<tr>
<td align="left" nowrap class="title" colspan="2" style="padding-left:20px">THÔNG TIN NGƯỜI ĐẶT HÀNG  :</td>
</tr>
<tr>
<td align="right" nowrap>Họ và Tên  :</td>
<td class="form_asterisk"><input value=" " name="ord_name" id="ord_name" type="text" class="form" size="35" maxlength="50">  <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>Giới tính  :</td>
<td class="form_asterisk">
<select name="ord_gender" id="ord_gender" class="form">
<option value="1">Nam </option>
<option value="0" >Nữ </option>
</select>
</td>
</tr>
<tr>
<td align="right" nowrap>Địa chỉ  :</td>
<td class="form_asterisk" nowrap="nowrap"><input value="" name="ord_address" id="ord_address" type="text" class="form" size="50"> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>E-mail :</td>
<td class="form_asterisk"><input value="" name="ord_email" id="ord_email" type="text" class="form" size="40" maxlength="60"> <font color="#FF0000">*</font> </td>
</tr>
<tr>
<td align="right" nowrap>Điện thoại  :</td>
<td class="form_asterisk"><input value="" name="ord_phone" id="ord_phone" type="text" class="form" size="30" maxlength="50"> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>Di động :</td>
<td><input value="" name="ord_mobile" id="ord_mobile" type="text" class="form" size="30" maxlength="50"> </td>
</tr>
<tr>
<td align="right" nowrap>Fax :</td>
<td><input value="" name="ord_fax" id="ord_fax" type="text" class="form" size="30" maxlength="50"> </td>
</tr>
<tr>
<td align="right" valign="top">Ghi chú :</td>
<td><textarea name="ord_otherinfo" id="ord_otherinfo" class="form" cols="50" rows="8"></textarea> </td>
</tr>
<tr>
<td align="right" nowrap class="order_status" colspan="2"><hr size="1" width="98%" color="#999999" /></td>
</tr>
<tr>
<td nowrap="nowrap" class="title" colspan="2" style="padding-left:20px">THÔNG TIN NGƯỜI NHẬN HÀNG :</td>
</tr>
<tr>
<td></td>
<td nowrap="nowrap"><input type="checkbox" id="check_same" onClick="checksame()">&nbsp;<label for="check_same">Thông tin người nhận trùng với thông tin người đặt</label></td>
</tr>
<tr>
<td align="right" nowrap>Họ và Tên :</td>
<td class="form_asterisk"><input name="ord_sname" id="ord_sname" type="text" class="form" size="35" value="" maxlength="50"> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>Giới tính :</td>
<td class="form_asterisk">
<select name="ord_sgender" id="ord_sgender" class="form">
<option value="1">Nam</option>
<option value="0">Nữ</option>
</select>
</td>
</tr>
<tr>
<td align="right" nowrap>Địa chỉ :</td>
<td class="form_asterisk" nowrap="nowrap"><input name="ord_saddress" id="ord_saddress" type="text" value="" class="form" size="50"> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>E-mail :</td>
<td class="form_asterisk"><input name="ord_semail" id="ord_semail" type="text" class="form" size="40" value=""> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>Điện thoại :</td>
<td class="form_asterisk"><input name="ord_sphone" id="ord_sphone" type="text" class="form" size="30" value=""> <font color="#FF0000">*</font></td>
</tr>
<tr>
<td align="right" nowrap>Di động :</td>
<td><input name="ord_smobile" id="ord_smobile" type="text" class="form" size="30" value=""> </td>
</tr>
<tr>
<td align="right" nowrap>Fax :</td>
<td><input name="ord_sfax" id="ord_sfax" type="text" class="form" size="30" value=""> </td>
</tr>
<tr>
<td align="right" valign="top">Ghi chú :</td>
<td><textarea name="ord_sotherinfo" id="ord_sotherinfo" class="form" cols="50" rows="8"></textarea> </td>
</tr>
<tr>
<td align="right" nowrap class="order_status" colspan="2"><hr size="1" width="98%" color="#999999" /></td>
</tr>
<tr>
<td nowrap="nowrap" class="title" colspan="2" style="padding-left:20px">VẬN CHUYỂN VÀ THANH TOÁN :</td>
</tr>
<tr>
<td align="right" nowrap>Hình thức vận chuyển :</td>
<td> 
<select name="ord_delivery" id="ord_delivery" class="form">
<option value="Đến địa chỉ người nhận">Đến địa chỉ người nhận</option>
<option value="Khách đến nhận hàng">Khách đến nhận hàng</option>
<option value="Qua bưu điện">Qua bưu điện</option>
<option value="Hình thức khác">Hình thức khác</option>
</select>
</td>
</tr>
<tr>
<td align="right" nowrap>Thời gian vận chuyển :</td>
<td class="form_asterisk"> 
<select name="ord_date" id="ord_date" class="form">
<option value=1 >1</option>";
<option value=2 >2</option>";
<option value=3 >3</option>";
<option value=4 >4</option>";
<option value=5 >5</option>";
<option value=6 >6</option>";
<option value=7 >7</option>";
<option value=8 >8</option>";
<option value=9 >9</option>";
<option value=10 >10</option>";
<option value=11 >11</option>";
<option value=12 >12</option>";
<option value=13 >13</option>";
<option value=14 >14</option>";
<option value=15 >15</option>";
<option value=16 >16</option>";
<option value=17 >17</option>";
<option value=18 >18</option>";
<option value=19 >19</option>";
<option value=20 >20</option>";
<option value=21 >21</option>";
<option value=22 >22</option>";
<option value=23 >23</option>";
<option value=24 >24</option>";
<option value=25 selected='selected'>25</option>";
<option value=26 >26</option>";
<option value=27 >27</option>";
<option value=28 >28</option>";
<option value=29 >29</option>";
<option value=30 >30</option>";
<option value=31 >31</option>";
</select>
<select name="ord_month" id="ord_month" class="form">
<option value=1 >1</option>";
<option value=2 >2</option>";
<option value=3 >3</option>";
<option value=4 selected='selected'>4</option>";
<option value=5 >5</option>";
<option value=6 >6</option>";
<option value=7 >7</option>";
<option value=8 >8</option>";
<option value=9 >9</option>";
<option value=10 >10</option>";
<option value=11 >11</option>";
<option value=12 >12</option>";
</select>
<select name="ord_year" id="ord_year" class="form">
<option value=2010 selected='selected'>2010</option>";
<option value=2011 >2011</option>";
<option value=2012 >2012</option>";
<option value=2013 >2013</option>";
<option value=2014 >2014</option>";
</select>
<br />
<font>(Ví dụ: hh:mm Ngày - Tháng - Năm)</font>
</td>
</tr>
<tr> 
<td align="right" nowrap>Hình thức thanh toán :</td>
<td> 
<select name="ord_payment" id="ord_payment" class="form">
<option value="Tiền mặt">Tiền mặt</option>
<option value="Thẻ ATM">Thẻ ATM</option>
<option value="Chuyển khoản">Chuyển khoản</option>
</select>
</td>
</tr>  
<tr height="50"> 
<td nowrap align="right">&nbsp;</td>
<td>
<div style="text-align:left; padding-top:15px; padding-bottom:50px">	 
	  <img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_oder.gif"  onClick="document.frmbasket.op.value='sorder'; document.frmbasket.submit();" style="cursor:pointer" border="0"> </div>
</td>
</tr>
</table>
</form>

{literal}
	<script language="javascript">
		function onSubmit(product_id,op)
		{
			document.frmbasket.product_id.value=product_id;
			document.frmbasket.op.value=op;
			document.frmbasket.submit();
		}
	</script>
{/literal}