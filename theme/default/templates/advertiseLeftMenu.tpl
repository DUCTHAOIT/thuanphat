{literal}
{/literal}
{foreach item=item key=key from=$arradvertiseLeftMenu}			
<div style="padding-bottom:3px" align="center">
 <a href="{$item.website}"><img   src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}"  border="0"/></a>
</div>
{/foreach}