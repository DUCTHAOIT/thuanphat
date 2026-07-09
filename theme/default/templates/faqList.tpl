{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  {foreach key=key item=item from=$arr}
	{if $k==2}
		{assign var="k" value="0"}
		</tr><tr>		
	{/if}	
    <td valign="top" width="50%" style="padding:5px">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				  <tr>
					<td valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/tl.gif" /></td>
					<td valign="top" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/tc.gif); background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/tc.gif" /></td>
					<td valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/tr.gif" /></td>
				  </tr>
				  
				  <tr>
					<td valign="top" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/hl.gif); background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/hl.gif" /></td>
					<td align="left" style="padding:5px; text-align:justify;" class="content">{$item.question}<br /><br /><font class="title">{$item.name}</font></td>
					<td valign="top" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/hr.gif); background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/hr.gif" /></td>
				  </tr>
				  <tr>
					<td valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/bl.gif" /></td>
					<td valign="top" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/bc.gif); background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/bc.gif" /></td>
					<td valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/faq/br.gif" /></td>
				  </tr>
				</table>
		</td>	
	{assign var="k" value="$k+1"}
   {/foreach}
  </tr>
</table>