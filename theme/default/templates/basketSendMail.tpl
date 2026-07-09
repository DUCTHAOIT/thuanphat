<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Đặt hàng</title>
</head>
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0">  
  <tr>
    <td style="padding-top:15px;">Ngày tạo:<strong> {$date}</strong></td>
  </tr>
</table>
<table cellspacing="1" bordercolor="#c0c0c0" border="1" width="100%"  class="table">	
<tr>
<td align="left" nowrap colspan="2" style="text-transform:uppercase" bgcolor="#EBEBEB"><strong>THÔNG TIN NGƯỜI ĐẶT HÀNG</strong></td>
</tr>
<tr>
<td align="left" nowrap width="30%">Họ và Tên  :</td>
<td class="form_asterisk" width="70%">{$ord_name}</td>
</tr>
<tr>
<td align="left" nowrap>Địa chỉ  :</td>
<td class="form_asterisk" nowrap="nowrap">{$ord_address}</td>
</tr>
<tr>
<td align="left" nowrap>E-mail :</td>
<td class="form_asterisk">{$ord_email}</td>
</tr>
<tr>
<td align="left" nowrap>Điện thoại  :</td>
<td class="form_asterisk">{$ord_phone}</td>
</tr>
<tr>
<td align="left" valign="top">Ghi chú :</td>
<td>{$ord_otherinfo}</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">  
 
  <tr height="25">
    <td bgcolor="#EBEBEB" style="text-transform:uppercase"><strong>Sản phẩm</strong></td>
  </tr>
  <tr>
    <td>{$basketInfo}</td>
  </tr>
</table>
</body>
</html>