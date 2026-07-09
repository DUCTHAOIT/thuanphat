<!--
Danh sach chuc nang
-->
{literal}
<style>
	.yellow {
		background-color: #ddd !important;
	}
</style>
<script>


	$(function() {
		$('tr.unselected').hover(function() {
			$(this).addClass('yellow');
		}, function() {
			$(this).removeClass('yellow');
		});
	});
</script>
{/literal}
<form name="frmListpartner" action="?m=partner" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td class="td"></td>
    <td width="100%" class="td">Tên</td>    
    <td align="center" nowrap="nowrap" class="td">Trạng thái</td>
    <td class="td">&nbsp;</td>
    <td class="td">&nbsp;</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr class="unselected" bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$key}</td>
    <td class="td"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/partner/{$item.img}" width="70" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td">
		<a href="#" onclick="goEdit({$key})" class="title">{$item.name}</a> <em style="color:#999999">({$item.date_create})</em><br />
		{$Group_name}: <span style="font-weight: bold">{$item.topicName}</span></td>    
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete({$key},document.frmListpartner)" style="cursor:pointer" /></td>
  </tr>
  {/foreach}
</table>
<div style="text-align:right; color:#0000CC"> {$Display}</div>
</form>