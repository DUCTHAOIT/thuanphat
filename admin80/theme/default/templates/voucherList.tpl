{literal}{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> {$vouchers_in_the_list}</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td" align="center">ID</td>
    <td class="td" align="center">Mã Voucher</td>
    <td class="td" align="center">% Giá trị giảm</td>
     <td class="td" align="center">Ngày Tạo</td>
    <td class="td" align="center">Ghi chú: </td>
    <td class="td" nowrap="nowrap">Trạng thái</td>
    <td class="td" nowrap="nowrap">Khách hàng</td>
    <td class="td">{$Status}</td>
    </tr>
  {foreach key=key item=item from=$arr}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
   <td align="left" class="td">{$key}</td>
    <td class="td" nowrap="nowrap">{$item.name}</td>
    <td align="center" class="td">{$item.loai}</td>
    <td align="center" class="td">{$item.date_create}</td>
    <td align="center" class="td">{$item.des}</td>
    
    <td nowrap="nowrap" class="td">{if $item.trangthai==0}<font style="color:#FF0000">Chưa sử dụng</font>{/if}{if $item.trangthai==1}<font style="color:#0000FF">Đã Sử dụng</font>{/if}</td>
    <td align="center" class="td">{if $item.userid}{nameUser id=$item.userid}{/if}</td>
    <td align="center" class="td"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" /></td>
    </tr>
  {/foreach}
</table>
</form>
{$sPage}