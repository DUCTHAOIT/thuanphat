{literal}{/literal}
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="" />
<input type="hidden" name="fileID" value="" />
<input type="hidden" name="id" value="{$groupID}" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
    <td class="td">{$Name}</td>
    <td class="td">{$FileName}</td>
    <td class="td">{$Size}</td>
    <td class="td">{$Date_create}</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><a href="?m=product&op=file&id={$item.proid}&idFile={$key}"><img src="images/edit.gif" style="cursor:pointer" border="0" /></a> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label></td>
    <td class="td" width="100%"><strong>{$item.name}</strong><br />{$item.content}</td>
    <td class="td" nowrap="nowrap">{$item.file}</a></td>
    <td class="td" nowrap="nowrap">{$item.size}</td>
    <td class="td" nowrap="nowrap">{$item.date_create}</td>
  </tr>
  {/foreach}
</table>
</form>