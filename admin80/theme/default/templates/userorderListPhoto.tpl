{literal}{/literal}
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="" />
<input type="hidden" name="photoID" value="" />
<input type="hidden" name="id" value="{$groupID}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cccccc">
  <tr>
  	{assign var="i" value="0"}
	{foreach item=item key=key from=$arr}
	{if $i==4}
	</tr><tr>
	{assign var="i" value="`1`"}
	{/if}
    <td valign="top" style="padding:10px">
	<div style="width:190px; padding-bottom:5px; padding-top:5px; text-align:center">	
	{if $item.img}<a href="?m=product&op=photo&id={$item.proid}&idPhoto={$key}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" border="0" onmouseover="border='1'" onmouseout="border='0'" width="120" /></a>{/if}</div>	
	<div style="width:190px; padding-bottom:5px; padding-top:5px; text-align:center"><img src="images/delete.gif" title="{$Delete}" style="cursor:pointer" onclick="goDelete({$key},document.frmList)" /></div>
	</td>
	{assign var="i" value="`$i+1`"}
	{/foreach}
  </tr>
</table>
</form>