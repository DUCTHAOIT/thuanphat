<form action="?m=block" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addBlock" />
<input type="hidden" name="id" value="{$id}" />
<div class="topic">{$Create} Block</div>
<table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr" height="24">
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">{$Position}: </td>
    <td width="100%" style="padding-top:10px"><select name="pos">
	{foreach key=key item=item from=$arrPosition}
	{if $arr.position==$key}
	<option value="{$key}" selected="selected">{getLablePosition lableID=$key}</option>
	{else}
	<option value="{$key}">{getLablePosition lableID=$key}</option>
	{/if}
	{/foreach}
	</select></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px;" nowrap="nowrap">{$Description}: </td>
    <td><input name="des" type="text" class="text" maxlength="50" value="{$arr.des}" /></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Block_content}: </td>
    <td><textarea class="textarea" name="content" style="height:300">{$content}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td>{getCboLanguage langID=$arr.lang}</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td><input type="submit" class="button" value="{$Update}" /></td>
  </tr>
</table>

</form>