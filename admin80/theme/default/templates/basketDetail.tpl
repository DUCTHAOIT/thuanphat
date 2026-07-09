{literal}{/literal}
<div><strong>ID Đơn hàng:</strong> <strong style="color:#990000">{$basketID}</strong></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="title">{$Shipping_Address}</td>
    </tr>
  <tr>
    <td class="td" style="text-align:justify">{$Fullname}</td>
    <td>{$arrUser.firstname} {$arrUser.lastname}</td>
  </tr>
  <tr>
    <td class="td">E-Mail</td>
    <td>{$arrUser.email}</td>
  </tr>
  <tr>
    <td class="td">{$Telephone}</td>
    <td>{$arrUser.telephone}</td>
  </tr> 
  <tr>
    <td class="td">{$Street_Address}</td>
    <td>{$arrUser.streetaddress}</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="25">
    <td class="tr">Image</td>
    <td class="tr">Tên SP</td>
    <td class="tr">Số lượng</td>
    <td class="tr">Giá</td>
    <td class="tr">Tổng</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" width="100" /></td>
    <td class="td">{$item.name_product}</td>
    <td class="td">{$item.quanlity}</td>
    <td class="td">{format_number number=$item.price}</td>
    <td class="td">{format_number number=$item.quanlity*$item.price}</td>
  </tr>
  {/foreach}
</table>
