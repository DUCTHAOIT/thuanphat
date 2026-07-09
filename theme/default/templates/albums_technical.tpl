{literal}{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	{foreach item=item key=key from=$arr}
	{if !$arr_tech[$item.parent] || $item.select > 0 }
		{if $item.parent == 0}
			<tr>
			  <td style="padding-left:5px; padding-bottom:5px; padding-top:5px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button.gif"></td>
		    <td width="100%" class="td title" nowrap="nowrap">{$item.name}</td></tr>
		{elseif !$item.select}					
			<tr>
			  <td align="right"></td>
		    <td class="td" style="padding-left:15px;" nowrap="nowrap"><a href="{$url}:{$key}:">{$item.name}</a> ({$item.number_product})</td></tr>
		{else}
			<tr>
			  <td align="right"></td>
			  <td class="td title" style="padding-left:15px; color:#0000FF" nowrap="nowrap">{$item.name} ({$item.number_product}) <a href="{remote_url id=$key}">x</a> </td>
			</tr>
		{/if}		
	{/if}
	{/foreach}  
</table>
