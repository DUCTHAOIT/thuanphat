{literal}
{/literal}
<form name="listHtmlpage" action="?m=htmlpage" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td align="center" class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete(document.listHtmlpage)" style="cursor:pointer" /></td>
    <td class="td">&nbsp;</td>
    <td width="100%" class="td">Title name</td>
    </tr>  
	  {foreach key=key item=item from=$arr}
	  <tr bgcolor="{cycle values="#FFFFFF,#F8F8F8"}">
	    <td class="td">{$key}</td>
		<td align="center" class="td">
		{if $item.del==1}
		<input type="checkbox" value="{$key}" name="chkdelete[]" />
		{else}
		<input type="checkbox" disabled="disabled" />
		{/if}		</td>
		<td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit({$key})" style="cursor:pointer" /></td>
		<td class="td" style="padding-left:20px"><a href="#" onclick="goEdit({$key})">{$item.title}</a><em style="color:#666666">({$item.date})</em></td>
	  </tr>
	  {/foreach}
</table>
</form>