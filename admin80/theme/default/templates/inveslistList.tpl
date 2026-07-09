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
<form name="frmListinveslist" action="?m=inveslist" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">
    <td class="td">ID</td>
    <td width="100%" class="td">Tiêu đề</td>
   
    <td align="center" nowrap="nowrap" class="td" colspan="3">{$Status}</td>
    
  </tr>
  {foreach key=key item=item from=$arr}
  <tr  class="unselected" bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$key}</td>
    <td class="td">
		<a href="#" onclick="goEdit({$key})" class="title">{$item.name}</a><br />
        Ngày khai giảng: {$item.date_create}<br />
        Địa điểm: {$item.summary}<br />
		Huấn luyện viên: <span style="font-weight: bold">{$item.topicName}</span><br />
        Học viên: <span style="font-weight: bold">{$item.NumUser}</span><br />
    </td>
   
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete({$key},document.frmListinveslist)" style="cursor:pointer" /></td>
   
  </tr>
  {/foreach}
</table>
<div style="text-align:right; color:#0000CC"> {$sPage}</div>
</form>
