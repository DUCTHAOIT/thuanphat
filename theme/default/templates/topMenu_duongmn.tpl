{literal}{/literal}
{assign var="k" value="0"}
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 {assign var="k" value="0"} 
  <tr height="30px">  	  
	{foreach key=key item=item from=$arr}
	
	<td  align="center" nowrap="nowrap" id="center{$key}" width="118px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" id="a{$key}" style="text-decoration:none; color:#FFFFFF; font-size:12px;" class="title">{$item.name}</a></td>	
	
	{assign var="k" value="$k+1"}	
	{/foreach}
  </tr>
</table>
