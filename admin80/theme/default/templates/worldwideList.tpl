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
<form name="frmList" action="#" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">Stt</td>
    <td class="td"></td>
    <td width="100%" class="td">Tên</td>    
    <td align="center" nowrap="nowrap" class="td">Trạng thái</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr class="unselected" bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$item.no}</td>
    <td class="td"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/worldwide/{$item.img}" width="70" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td">
		<a href="#" onclick="goEdit({$key})" class="title">{$item.name}</a><br />
        <em style="color:#999999">{$item.address}</em><br />
		Nhóm: <span style="font-weight: bold">{$item.funname}</span></td>    
   
    <td class="td">
    	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>
    </td>
  </tr>
  {/foreach}
</table>
<div style="text-align:right; color:#0000CC"> {$Display}</div>
</form>