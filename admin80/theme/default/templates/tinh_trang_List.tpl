{literal}{/literal}
<table border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">{$Photo}</td>
    <td class="td">{$Product_name}</td>
    <td class="td">&nbsp;</td>
    </tr>
  {section name=i loop=$arr start=$pageID max=$limit}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
    <td class="td">{$arr[i].date_create}</td>
    <td width="50%" class="td title">{$arr[i].name}</td>
    <td align="center" class="td" nowrap="nowrap"><a href="?m=product&f=tinhtrang&id={$arr[i].id}"><img src="images/edit.gif" border="0" /></a> &nbsp; <a href="?m=product&f=tinhtrang&op=del&id={$arr[i].id}"><img src="images/delete.gif" border="0" /></a></td>
    </tr>
  {/section}
</table>
<div>{$sPage}</div>