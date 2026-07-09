<form name="frmaddBlockOnPage" action="?m=block" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addBlockOnPage" />
<input type="hidden" name="pid" value="{$pid}" />
<input type="hidden" name="pos" value="{$pos}" />
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td id="massage">&nbsp;</td>
    <td>
	<select name="blockID">
	{foreach key=key item=item from=$arr}
	<option value="{$key}">{$item}</option>
	{/foreach}
	</select>	</td>
	<td style="padding-left:10px; padding-right:5px" nowrap="nowrap">{$Position}</td>
	<td><input type="text" name="order" class="text" style="width:40" value="1" /></td>
	<td><input type="button" onclick="calladdBlockOnPage(document.frmaddBlockOnPage);" value="{$Update}" class="button" /></td>
	</tr>
</table>
</form>