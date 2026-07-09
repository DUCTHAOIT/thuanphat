{literal}{/literal}
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
	<td class="td">&nbsp;</td>
    <td class="td">{$Name}</td>
    <td class="td">{$Tel}</td>
    <td class="td">{$Website}</td>
    <td class="td">{$Address}</td>
    <td class="td">{$No}</td>
    <td class="td">&nbsp;</td>
  </tr>
  {if $arr}
  {assign var="i" value=1}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$i}</td>
	<td class="td">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>	</td>
    <td class="td"><a href="#" onclick="goEdit({$key})" >{$item.name}</a></td>
    <td class="td">{$item.tel}</td>
    <td class="td"><a href="{$item.website}" target="_blank">{$item.website}</a></td>
    <td class="td">{$item.address}</td>
    <td class="td">{$item.no}</td>
    <td class="td"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/advertise/{$item.img}" width="100" /></td>
    </tr>
  {assign var="i" value=$i+1}
  {/foreach}
  {else}
  <tr>
    <td colspan="8" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  {/if}
</table>
</form>