<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr  style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/b.gif); background-repeat:repeat-x;">
		<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/l.gif" /></td>
		<td class="titleBlock" width="100%" align="left" nowrap="nowrap" style="color:#FFFFFF">{$Project_Implementation}</td>	
   </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 {foreach item=item key=key from=$arr}	 
	 <tr>
		<td align="center" style="padding-top:5px">
			<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}&op=detail&{$smarty.const._ID_partner}={$item.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" border="0"  width="194" /></a>
		</td>
	 </tr>
	 <tr>
		<td width="100%" style="padding-top:10px; padding-bottom:10px" nowrap="nowrap" align="center" ><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}&op=detail&{$smarty.const._ID_partner}={$item.alias}"  class="title" style="color:#225097">{$item.name}</a></td>
	  </tr>
	{/foreach}
</table>