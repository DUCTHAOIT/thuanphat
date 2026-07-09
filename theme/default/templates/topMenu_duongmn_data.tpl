{literal}{/literal}
<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr height="34">  	  
	{foreach key=key item=item from=$arr}	
    <td align="left" width="2" style=""><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme/default/images/menu/icon.gif" border="0" ></td>
	<td headers="34" class="cnl_vincomtopmenu" onmouseover="bgColor='#07517B'" onmouseout="bgColor=''" align="center" nowrap="nowrap" id="{$key}" style=""><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" id="a{$key}" style="text-decoration:none; text-transform:uppercase; padding-top:5px; padding-bottom:5px; color:#FFFFFF" class="title" >{$item.name}</a></td>	
	{/foreach}
  </tr>
</table>

