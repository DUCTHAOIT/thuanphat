{literal}{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> {$albumss_in_the_list}</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">{$Photo}</td>
    <td class="td">{$albums_name}</td>
    <td class="td">{$Price}</td>   
    <td class="td">{$Date_create}</td>
    <td class="td" nowrap="nowrap">{$Status}</td>
    <td class="td">Photo</td>
    <td class="td">&nbsp;</td>
    </tr>
  {foreach key=key item=item from=$arr}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
    <td class="td">
	{if $item.img}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/albums/{$item.img}" width="70" onclick="goEdit({$key})" style="cursor:pointer" />
	{else}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/none.gif" width="70" onclick="goEdit({$key})" style="cursor:pointer" />
	{/if}	</td>
    <td width="50%" class="td">
	<a href="#" class="title" onclick="goEdit({$key})">{$item.name}</a> <em style="color:#999999">{$item.date_create}</em><br />
	{$albums_group}: <strong>{$item.nameCat}</strong><br />{if $item.nameHSX}HSX: <strong>{$item.nameHSX}</strong>{/if}	</td>
    <td width="50%" class="td">
	<label style="color:#FF0000; text-decoration:line-through">{format_number number=$item.price_old}</label><br />
	{format_number number=$item.price}</td>    
    <td align="center" class="td">{$item.date_create}</td>	
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td align="center" class="td"><a href="#" onclick="goPhoto({$key})"><img src="images/albums_photo.gif" border="0" /></a></td>
    <td align="center" class="td"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" /></td>
    </tr>
  {/foreach}
</table>
</form>
{$sPage}