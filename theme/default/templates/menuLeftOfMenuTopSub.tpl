<table width="100%" border="0" cellspacing="0" cellpadding="0"> 	
	   {foreach key=key item=item from=$arr}
		 
				  <tr id="{$item.id}" height="30px">
					<td align="left"  style="border-top:1px dotted #c9cacb" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/menu/iconsub.gif" vspace="8" hspace="8" border="0" /></td>
					<td width="100%"  style="border-top:1px dotted #c9cacb" nowrap="nowrap"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  id="a{$item.id}" class="content" style="color:#414042">{$item.name}</a>			
					</td>					
				  </tr>	
				
	  {/foreach}
</table>