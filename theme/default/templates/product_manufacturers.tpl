{literal}{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td style="padding-left:5px; padding-bottom:5px; padding-top:5px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button.gif"></td>
        <td width="100%" class="td title" nowrap="nowrap">{$Manufacturers}</td>
    </tr>
	{if $hsx}
	<tr>
	  <td>&nbsp;</td>
		<td class="td" style="padding-left:15px; color:#0000FF" nowrap="nowrap"><strong>{$arr[$hsx].name} ({$arr[$hsx].number_product})</strong> <a href="{remote_url id=0}">x</a></td>
	</tr>
	{else}		
	{foreach item=item key=key from=$arr}	
	<tr>
	  <td>&nbsp;</td>
		<td class="td" style="padding-left:15px;" nowrap="nowrap"><a href="{$url}{$key}">{$item.name}</a> ({$item.number_product})</td>
	</tr>	
	{/foreach}  
	{/if}
</table>
