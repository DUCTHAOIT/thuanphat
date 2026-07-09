{literal}{/literal}
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
    <td class="td">{$Name_weblink}</td>
    <td class="td">{$Website}</td>
    <td class="td">{$Description}</td>
    <td class="td">{$No}</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td"><label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key},document.frmList)" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label></td>
    <td class="td">{$item.name}</td>
    <td class="td"><a href="{$item.url}" target="_blank">{$item.url}</a></td>
    <td class="td">{$item.des}</td>
    <td class="td">{$item.no}</td>
  </tr>
  {/foreach}
</table>
</form>