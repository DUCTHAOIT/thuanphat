{literal}{/literal}
<table border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
  	<td class="td">STT</td>
    <td class="td">{$Photo}</td>
    <td class="td">{$Product_name}</td>
    <td class="td">&nbsp;</td>
    </tr>
  {section name=i loop=$arr start=$pageID max=$limit}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
  	 <td class="td title">{$arr[i].sort}</td>
    <td class="td">
	{if $arr[i].logo}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$arr[i].logo}" width="100px" />	
	{/if}	</td>
    <td width="50%" class="td title">{$arr[i].name}<br />Link:{$arr[i].link}</td>
    <td align="center" class="td" nowrap="nowrap"><a href="?m=product&f=slide&id={$arr[i].id}"><img src="images/edit.gif" border="0" /></a> &nbsp; <a href="?m=product&f=slide&op=del&id={$arr[i].id}"><img src="images/delete.gif" border="0" /></a></td>
    </tr>
  {/section}
</table>
<div>{$sPage}</div>