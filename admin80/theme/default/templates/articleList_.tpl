{literal}
{/literal}
<form name="frmListArticle" action="?m=article" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td width="100%" class="td">{$Article_name}</td>
    <td align="center" nowrap="nowrap" class="td">{$Source}</td>
    <td align="center" nowrap="nowrap" class="td">{$Status}</td>
    <td class="td">&nbsp;</td>
    <td class="td">&nbsp;</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td">{$key}</td>
    <td class="td">
		<a href="#" onclick="goEdit({$key})" class="title">{$item.name}</a> <em style="color:#999999">({$item.date_create})</em><br />
		{$Group_name}: <span style="font-weight: bold">{$item.topicName}</span></td>
    <td align="center" class="td">{if $item.source} {$item.source} {else}N/A{/if}</td>
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete({$key},document.frmListArticle)" style="cursor:pointer" /></td>
  </tr>
  {/foreach}
</table>
<div style="text-align:right; color:#0000CC"> {$Display}</div>
</form>