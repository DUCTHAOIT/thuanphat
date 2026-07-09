{literal} 
{/literal} 
  {assign var="i" value="0"}
{foreach item=item key=key from=$arr}
	<div style="padding-bottom:10px" align="center"><a href="{$item.website}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}" width="100%"  border="0"  style="cursor:pointer" /><a></div>
 {assign var="i" value="$i+1"}	 
{/foreach}