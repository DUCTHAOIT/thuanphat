<table width="100%" border="0" cellspacing="0" cellpadding="0"> 	
	 {foreach key=key item=item from=$arr}
	  {if $count>1}
	  {if $item.parent<>0}     
	  <tr>
		<td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/menuiconl.gif" hspace="0" border="0" /></td>
		<td valign="top" width="100%" bgcolor="#046854">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr id="{$item.id}">
				<td align="left" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/iconTopic.gif" vspace="0" hspace="0" border="0" /></td>
				<td width="100%" style="color:#FFFFFF; padding-left:5px" nowrap="nowrap" ><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  id="a{$item.id}" class="title" style="color:#FFFFFF">{$item.name}</a>			
				</td>
			  </tr>
			</table></td>    
		<td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/menuiconr.gif" hspace="0" border="0" /></td>	    
	</tr>  
	<tr>	
		 <td colspan="3" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgB.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" width="200" height="2"  /></td>    
 	</tr>    
	  {/if}	 
	  {else}
		 <tr>
		 <td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/menuiconl.gif" hspace="0" border="0" /></td>
		<td valign="top" width="100%" bgcolor="#046854">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr id="{$item.id}">
				<td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/iconTopic.gif" vspace="0" hspace="0" border="0" /></td>
				<td width="100%" nowrap="nowrap"  style="color:#FFFFFF;; padding-left:5px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  id="a{$item.id}" class="title" style="color:#FFFFFF">{$item.name}</a></td>
			  </tr>
			</table></td>  
		<td align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/menuiconr.gif" hspace="0" border="0" /></td>	      
	</tr> 
	<tr>	
		 <td colspan="3" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgB.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" width="200" height="2"  /></td>    
 	</tr> 
  {/if}
  {/foreach}
</table>