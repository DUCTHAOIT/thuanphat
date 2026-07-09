<table width="100%" border="0" cellspacing="0" cellpadding="0">	
	  {foreach key=key item=item from=$arr}    
      <tr>
	  	<td valign="top" style="padding-right:10px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr id="{$item.id}">
				<td align="left" style="padding-left:0px; padding-right:5px; padding-bottom:2px;  border-bottom:1px dotted #000000" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/iconTopic.gif" vspace="10" hspace="0" /></td>
				<td width="100%" style="color:#990000; border-bottom:1px dotted #000000" nowrap="nowrap" >
				<a href="{$item.url}f=detail&{$smarty.const._ID_PRODUCT}={$item.id}" id="a{$item.id}" class="title" style="color:#333333">{$item.name}</a>			
				</td>
			  </tr>
			</table></td>        
    </tr>           
    {/foreach}	  
   <tr><td height="10">&nbsp;</td></tr>	 
</table>
