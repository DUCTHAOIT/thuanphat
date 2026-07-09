{literal}{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> {$userorders_in_the_list}</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td class="td">Ngày</td>
    <td class="td">Số Hợp Đồng</td>
    <td class="td">Giá trị mua: </td>
     <td class="td">Giá mua 1 ĐVĐT bình quân</td>
    <td class="td">Số lượng ĐVĐT: </td>
   
    <td class="td" nowrap="nowrap">{$Status}</td>
    <td class="td">&nbsp;</td>
    </tr>
  {foreach key=key item=item from=$arr}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
   <td align="left" class="td">{$item.id}</td>
    <td align="left" class="td">{$item.date_create}</td>
    <td class="td"><a href="#" class="title" onclick="goEdit({$key})">{$item.name}</a></td>
    <td align="left" class="td">{$item.price_old}</td>
    <td align="left" class="td">{$item.price}</td>
    <td align="left" class="td">{$item.model}</td>
    
    
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td align="center" class="td"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" /></td>
    </tr>
  {/foreach}
</table>
</form>
{$sPage}