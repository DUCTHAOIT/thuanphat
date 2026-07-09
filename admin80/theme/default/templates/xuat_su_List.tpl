{literal}{/literal}
<table border="1" cellspacing="0" cellpadding="0" class="table" width="100%">
  <tr class="tr">
  	<td class="td">ID</td>
    <td>Ngày</td>
    <td>Tài sản ròng</td>
    <td>Tổng số lượng ĐVĐT TSI</td>
    <td>Gía 1 ĐVĐT</td>
    <td></td>
    </tr>
  {section name=i loop=$arr start=$pageID max=$limit}
  {if $arr[i].sort==1}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
  	<td class="td title" style="color:#FF0000" >{$arr[i].id}</td> 
    <td class="td"  style="color:#FF0000">{$arr[i].date}</td> 
    <td class="td"  style="color:#FF0000">{$arr[i].taisan}</td>
    <td  class="td"  style="color:#FF0000">{$arr[i].khoiluong}</td>
    <td  class="td"  style="color:#FF0000">{$arr[i].giadvdt}</td>
    <td align="center" class="td" nowrap="nowrap"><a href="?m=user&f=xuatsu&id={$arr[i].id}"><img src="images/edit.gif" border="0" /></a> &nbsp; <a href="?m=user&f=xuatsu&op=del&id={$arr[i].id}"><img src="images/delete.gif" border="0" /></a></td>
    </tr>
   {else}
    <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
  	<td class="td title">{$arr[i].id}</td> 
    <td class="td">{$arr[i].date}</td> 
    <td class="td">{$arr[i].taisan}</td>
    <td  class="td">{$arr[i].khoiluong}</td>
    <td  class="td">{$arr[i].giadvdt}</td>
    <td align="center" class="td" nowrap="nowrap"><a href="?m=user&f=xuatsu&id={$arr[i].id}"><img src="images/edit.gif" border="0" /></a> &nbsp; <a href="?m=user&f=xuatsu&op=del&id={$arr[i].id}"><img src="images/delete.gif" border="0" /></a></td>
    </tr>
   {/if} 
  {/section}
</table>
<div>{$sPage}</div>