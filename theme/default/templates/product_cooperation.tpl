{literal}{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
   <tr>
	<td style="padding-left:20px; padding-right:20px; padding-bottom:10px; padding-top:5px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>		
		<td style="color:#AC001C; text-transform:uppercase" nowrap="nowrap" align="left" class="title"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/iconTopic.gif" />&nbsp;&nbsp;{$arr.name}</td>			
	  </tr>			  
	</table></td>			
  </tr>        
  <tr>
	<td width="100%" style="padding-left:10px; padding-right:10px">
	<div style="" class="content"><a name="solutions" class="content">{$arr.cooperation}</a></div>
	</td>			
  </tr>
  <tr>
  	<td style="padding-left:10px; padding-right:10px;">
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
		 <tr>	
		 <td width="100%">&nbsp;</td>
		 <td class="content" style="padding-right:5px" nowrap="nowrap">{$MailToFriend}</td>
		 <td nowrap style="padding-right:10px;">				 	
			<a class="content" href="mailto:{$email}?subject={$arr.name}"><img border="0" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/sv_mail.gif"></a>
		 </td>	
		 <td class="content" style="padding-right:5px" nowrap="nowrap">{$Print}</td>
		 <td nowrap style="padding-right:10px;" valign="top">
		 <label onclick="window.showModalDialog('{$smarty.const._DOMAIN_ROOT_URL}/product_print/{$arr.id}/','Uploadsd','dialogWidth=800px; dialogHeight=600px; scroll=yes; status=no');" style="cursor:pointer " class="content"><img border="0" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/sv_print.gif"></label>	 </td>
 		 	
		 </tr>
 	</table> 	
</td>
  </tr>
</table>