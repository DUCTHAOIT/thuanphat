{literal}
<script language="javascript" type="text/javascript">
function returnHour(){	
	var obj;	
	obj=document.frmmain;	
	obj.submit();	
}

</script>
{/literal}
<form name="frmmain" action="?m=basket" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="sorder" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #cccccc">
 
  <tr>
    <td valign="top" style="border-bottom:1px solid #cccccc; padding-left:15px;">{$basketInfoMember}</td>
    <td width="60%" valign="top" style="border-left:1px solid #cccccc; border-bottom:1px solid #cccccc; padding-left:15px; padding-right:10px;">
	  {$basketInfo}</td>
  </tr>   
  <tr>
  	<td colspan="2" align="center">		
		<div style="font-weight:bold;" align="left" style="padding-left:15px; padding-top:10px">Lựa chọn cách thức chuyển hàng và thanh toán:</div><br>
        <span id="ctl00_ContentPlaceHolder1_shippingRequiredLabel"></span>
        <span id="ctl00_ContentPlaceHolder1_shippingLabel"><input type=hidden name=selectShippingMethod id=selectShippingMethod>
		<table cellpadding=4 cellspacing=0 border=1 bordercolor=#CCCCCC style="border-collapse:collapse;" width="95%">
		<tr bgcolor="#EEEEEE">
			<td>Chọn</td>
			<td>Cách thức</td>
			<td>Giá vận chuyển</td>
		</tr>
		<tr>
			<td class=check><input type=radio name=shippingMethod value="0" ></td>
			<td>Vận chuyển miễn phí bởi IRVietNam<br />IRVietNam chỉ vận chuyển h&agrave;ng miễn ph&iacute; tại một số địa b&agrave;n (hiện tại chỉ tại H&agrave; nội) v&agrave; loại sản phẩm đặt h&agrave;ng theo quy định của c&ocirc;ng ty.</td>
			<td>0 VND</td>
		</tr>
		<tr>
			<td class=check><input type=radio name=shippingMethod value="1" ></td>
			<td>Quí khách đến nhận hàng tại IRVietNam <br />Qu&yacute; kh&aacute;ch c&oacute; thể đặt h&agrave;ng tr&ecirc;n mạng v&agrave; đến IRVietNam để nhận h&agrave;ng trực tiếp</td><td>0 VND</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  	 <td style="padding-right:10px; padding-left:0px;" class="title" nowrap="nowrap">Thời gian nhận hàng:</td>
					<td style="padding-right:10px" nowrap="nowrap"><input style="width:40"  type="text" name="hour" class="text" value="24.00" />&nbsp;<b>h</b></td>		 
					 <td nowrap="nowrap" style="padding-right:10px">{html_select_date prefix="StartDate" time=$time start_year="-50" end_year="+0" display_days=true}</td>
					 <td width="100%" align="left"><label style="color:#FF0000">*</label></td>
				  </tr>
				</table>

			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  	 <td nowrap="nowrap" class="title" style="padding-right:10px">Phương thức thanh toán:</td>
						<td class="content"  align="left" width="100%">
						<select  name="method" size=1>          
						<option value="">----- Lựa chọn cách thanh toán -----</option>
						<option value="Thanh toán tại nhà">Thanh toán tại nhà </option>
						<option value="Thanh toán tại cửa hàng">Thanh toán tại cửa hàng </option>
						<option value="Chuyển khoản qua ngân hàng">Chuyển khoản qua ngân hàng </option>
						</select>
						</td>
				  </tr>
				</table>

			</td>
		</tr>
		<tr bgcolor="#EEEEEE">
			<td class="title" colspan="3">{$Add_Comments_About_Your_Order}:</td>
		  </tr>
		   <tr>
			<td colspan="3" valign="top" align="center"><textarea class="textarea" style="height:140; width:100%" name="des"></textarea></td>
		  </tr>
		</table></span>     
	</td>
  </tr>  
  <tr>
    <td colspan="2" align="right" valign="top" style="padding-top:10px; padding-bottom:10px; padding-right:20px">
	<label onclick="javascript: returnHour();" style="cursor:pointer; color:#999999" class="title" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_oder.gif" border="0" style="cursor:pointer" /></label></td>
	
  </tr>
</table>
</form>