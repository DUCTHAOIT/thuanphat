<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#232323">  
  <tr>
	<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		   <tr id="{$item.id}">
		   <td width="30%" align="center" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebbL.gif); background-repeat:repeat-x; color:#b2b2b2; padding-left:10px; padding-right:40px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/faqs/" class="title" style="color:#b2b2b2">{$Comment}</a></td>
			<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/LeftL.gif" /></td>	
			
			<td align="left" valign="top" width="70%" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb2L.gif); background-repeat:repeat-x" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb2L.gif" /></td>
		  </tr>
		</table></td>        
  </tr>
  <tr>
  	<td valign="top" align="center" style="padding:10px"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/faq.jpg" border="0" /></td>
  </tr>   
  {foreach item=item key=key from=$arr}	 
 	 <tr>
		<td valign="top" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr id="{$item.id}">
				<td align="left" style="border-bottom:1px dotted #383838; padding:5px; padding-top:10px" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/iconfaq.gif" vspace="0" hspace="0" border="0" /></td>
				<td width="100%" style="border-bottom:1px dotted #383838; padding:5px;"><a href="{$smarty.const._DOMAIN_ROOT_URL}/faqs/" class="content" style="color:#b2b2b2; font-size:11px">{$item.subject}</a></td>
			  </tr>
			</table></td>        
	</tr> 
	{/foreach}
</table>