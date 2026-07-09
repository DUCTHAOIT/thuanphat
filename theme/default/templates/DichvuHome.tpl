<table width="100%" border="0" cellspacing="0" cellpadding="0">
  {assign var="i" value="0"}
	{foreach item=item key=key from=$arr}	
	<tr>
    {if $i==1} 
	<td align="left" width="100%" style="border-bottom:1px solid #7f7f7f; border-top:1px solid #7f7f7f;  padding-bottom:5px; padding-top:5px" valign="top">
	{else}
	<td align="left" width="100%" style="border-bottom:0px solid #666666; padding-bottom:5px; padding-top:5px" valign="top">
	{/if}
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td style="padding-bottom:5px" colspan="2"><strong style="color:#792D13">{$item.name}</strong></td>
		  </tr>
		  <tr>
			<td align="center" valign="top" style="padding-right:5px">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #c0c0c0">
			  <tr>
				<td>
				<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/function/{$item.img1}" border="0" vspace="2"  hspace="2" alt="Chi tiết"/></a></td>
			  </tr>
			</table>
			</td>
			<td style="text-align:justify; font-size:12px" class="content">{$item.des}<br /><div align="right"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/icon.gif" border="0" alt="Chi tiết"  /></a></div></td>
		  </tr>
		</table>
	</td>
	<tr>
	{assign var="i" value="$i+1"}
	{/foreach}
  
</table>