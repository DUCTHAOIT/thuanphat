<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr  style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/2gab.gif); background-repeat:repeat-x;">
	<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/1ga.gif" /></td>       
	 <td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/2ga.gif" border="0" /></td>
	<td align="right" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/3ga.gif" /></td>
  </tr>
  <tr>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4ga.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4ga.gif" /></td>		
	<td width="100%" valign="top" bgcolor="#f4f5f6" style="padding-top:10px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"> 			
			  <tr>
				{assign var="i" value="0"}
				{foreach item=item key=key from=$arr}
				{if $i==1}	</tr><tr>
				{assign var="i" value="1"}
				{/if}
				<td valign="top" align="center" style="border-bottom:10px">
					<table border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="100%" align="center">
						{if $item.img}
						<div style="border:1px solid #CCCCCC; padding:2px; background-color:#FFFFFF" align="center">
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}&id={$key}">
							<img src="{$smarty.const._DOMAIN_ROOT_URL}/modules/photo/newgallery/thumbs/{$item.img}" border="0" vspace="2" hspace="2" width="205" height="136" style="border:1px solid #7d9bc2"/>						</a>
                         </div>   
						{/if}
						</td>						
					  </tr>					
					</table>
				 </td>
				{assign var="i" value="$i+1"}
				{/foreach}
			  </tr>
			</table>
		
	</td>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/5ga.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/5ga.gif" /></td>
  </tr>			 			 
  <tr>
	<td valign="top" align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/6ga.gif" /></td>
	 <td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/7ga.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/7ga.gif" /></td>
	<td valign="top" align="right"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/8ga.gif" /></td>
  </tr>
</table>