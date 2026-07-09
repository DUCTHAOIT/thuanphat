<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Đặt hàng</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">  
  <tr>
    <td style="padding-top:15px;">Ngày tạo<strong>{$date}</strong></td>
  </tr>
  <tr height="25">
    <td bgcolor="#EBEBEB"><strong>Sản phẩm</strong></td>
  </tr>
  <tr>
    <td style="padding: 10px;">{$basketInfo}</td>
  </tr>
</table>
<table width="100%" cellpadding="5" cellspacing="2" class="content">
<tr>
<td colspan="2" class="title" bgcolor="#CCCCCC">Thông tin thanh toán</td>
</tr>
<tr>
<td align="left" nowrap class="title" colspan="2" style="padding-left:20px">THÔNG TIN NGƯỜI ĐẶT HÀNG  :</td>
</tr>
<tr>
<td align="right" nowrap>Họ và Tên  :</td>
<td class="form_asterisk">{$ord_name}</td>
</tr>
<tr>
<td align="right" nowrap>Giới tính  :</td>
<td class="form_asterisk">{$ord_gender}</td>
</tr>
<tr>
<td align="right" nowrap>Địa chỉ  :</td>
<td class="form_asterisk" nowrap="nowrap">{$ord_address}</td>
</tr>
<tr>
<td align="right" nowrap>E-mail :</td>
<td class="form_asterisk">{$ord_email}</td>
</tr>
<tr>
<td align="right" nowrap>Điện thoại  :</td>
<td class="form_asterisk">{$ord_phone}</td>
</tr>
<tr>
<td align="right" nowrap>Di động :</td>
<td>{$ord_mobile}</td>
</tr>
<tr>
<td align="right" nowrap>Fax :</td>
<td>{$ord_fax}</td>
</tr>
<tr>
<td align="right" valign="top">Ghi chú :</td>
<td>{$ord_otherinfo}</td>
</tr>
<tr>
<td align="right" nowrap class="order_status" colspan="2"><hr size="1" width="98%" color="#999999" /></td>
</tr>
<tr>
<td nowrap="nowrap" class="title" colspan="2" style="padding-left:20px">THÔNG TIN NGƯỜI NHẬN HÀNG :</td>
</tr>
<tr>
<td align="right" nowrap>Họ và Tên  :</td>
<td class="form_asterisk">{$ord_sname}</td>
</tr>
<tr>
<td align="right" nowrap>Giới tính  :</td>
<td class="form_asterisk">{$ord_sgender}</td>
</tr>
<tr>
<td align="right" nowrap>Địa chỉ  :</td>
<td class="form_asterisk" nowrap="nowrap">{$ord_saddress}</td>
</tr>
<tr>
<td align="right" nowrap>E-mail :</td>
<td class="form_asterisk">{$ord_semail}</td>
</tr>
<tr>
<td align="right" nowrap>Điện thoại  :</td>
<td class="form_asterisk">{$ord_sphone}</td>
</tr>
<tr>
<td align="right" nowrap>Di động :</td>
<td>{$ord_smobile}</td>
</tr>
<tr>
<td align="right" nowrap>Fax :</td>
<td>{$ord_sfax}</td>
</tr>
<tr>
<td align="right" valign="top">Ghi chú :</td>
<td>{$ord_sotherinfo}</td>
</tr>
<tr>
<td align="right" nowrap class="order_status" colspan="2"><hr size="1" width="98%" color="#999999" /></td>
</tr>
<tr>
<td nowrap="nowrap" class="title" colspan="2" style="padding-left:20px">VẬN CHUYỂN VÀ THANH TOÁN :</td>
</tr>
<tr>
<td align="right" nowrap>Hình thức vận chuyển :</td>
<td>{$ord_delivery}</td>
</tr>
<tr>
<td align="right" nowrap>Thời gian vận chuyển :</td>
<td class="form_asterisk">{$timeOder}</td>
</tr>
<tr> 
<td align="right" nowrap>Hình thức thanh toán :</td>
<td>{$ord_payment}</td>
</tr>  
  <tr>
    <td colspan="2" align="right" style="padding: 10px;"><a href="{$smarty.const._DOMAIN_ROOT_URL}/" target="_blank">{$smarty.const._DOMAIN_ROOT_URL}/</a></td>
  </tr>
  <tr>
    <td colspan="2"  style="padding-top:15px;"><strong>Thanks!</strong></td>
  </tr>
</table>
</body>
</html>