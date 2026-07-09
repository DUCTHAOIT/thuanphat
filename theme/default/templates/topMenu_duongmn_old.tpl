{literal}{/literal}
<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr height="20">  	  
	{foreach key=key item=item from=$arr}	
    <td align="left" width="4" style="padding-left:5px; padding-right:5px"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/header/linemenu.gif" border="0" ></td>
	<td class="cnl_vincomtopmenu" onmouseover="bgColor='#AC001C'" onmouseout="bgColor=''" align="center" nowrap="nowrap" id="{$key}" style="padding-left:15px; padding-right:15px; padding-top:2px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" id="a{$key}" style="text-decoration:none" >{$item.name}</a></td>	
	{/foreach}		
  </tr>
</table>

