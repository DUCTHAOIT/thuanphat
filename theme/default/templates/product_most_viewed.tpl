{assign var="k" value="1"}
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#232323">  
  <tr>
	<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		   <tr id="{$item.id}">
		   <td width="30%" align="center" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebbL.gif); background-repeat:repeat-x; color:#b2b2b2; padding-left:10px; padding-right:40px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/faqs/" class="title" style="color:#b2b2b2">Most Popular</a></td>
			<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/LeftL.gif" /></td>	
			
			<td align="left" valign="top" width="70%" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb2L.gif); background-repeat:repeat-x" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb2L.gif" /></td>
		  </tr>
		</table></td>        
  </tr>  
 {section name=i loop=$arr start=$pageID max=$limit}
 	 <tr>
		<td valign="top" width="100%" style="padding-left:10px; padding-bottom:5px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr id="{$item.id}">
				<td align="left" style="padding:5px; padding-right:0px; color:#c6c6c6" class="content">{$k}</td>
				<td width="100%" style="padding:5px;">
					<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="content" style="color:#c6c6c6; font-size:11px">{$arr[i].name}</a>
				</td>
			  </tr>
			</table></td>        
	</tr> 
	{assign var="k" value="$k+1"}	
	{/section}
</table>