<table border="0" cellspacing="0" cellpadding="0">
  <tr>
	{foreach item=item key=key from=$arr}	
    <td nowrap="nowrap" style="padding:2px" align="center"><a href="{$item.url}" target="_blank"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}" border="0" width="30px;"></a></td>
    {/foreach}
  </tr>
</table>