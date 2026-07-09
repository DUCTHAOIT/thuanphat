<div class="contentFun"><font class="title">{$Sitemap}</font></div>
<div style="border:1px solid #d1d3d4; padding:10px">		
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td style="padding:10px;" width="100%" valign="top"><table width="80%" border="0" cellspacing="10" cellpadding="0">
			  {foreach key=key item=item from=$arr}				  
			  {if $item.level=='0'}
			  <tr>
					  <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="left" style="padding-left:0px; padding-right:5px; padding-bottom:2px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/icon.gif" vspace="5" hspace="0" border="0" /></td>
							<td width="100%" style="color:#000000;" nowrap="nowrap" ><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  class="content" style="color:#000000; text-transform:uppercase">{$item.name}</a>{if $item.focus=='1'}&nbsp;<img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/new.gif" />{/if} </td>
						  </tr>
					  </table></td>
			  </tr>
			  {else}
			  <tr>
				<td valign="top" style="padding-right:10px; padding-left:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="left" style="padding-left:0px; padding-right:5px; padding-bottom:2px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/icon.gif" vspace="5" hspace="0" border="0" /></td>
					<td width="100%" style="color:#000000;" nowrap="nowrap" ><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  class="content" style="color:#000000">{$item.name}</a>{if $item.focus=='1'}&nbsp;<img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/new.gif" />{/if} </td>
				  </tr>
				</table></td>
			  </tr>
			  {/if}
			  {/foreach}
			</table></td>
		  </tr> 
		</table>
</div>