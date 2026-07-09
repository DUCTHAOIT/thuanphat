{literal}
{/literal}
<form name="frmListhieuqua" action="?m=hieuqua2" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td width="20%" class="td">Ngày</td>    
    <td align="right" nowrap="nowrap" class="td">Giá trị đơn vị đầu tư</td>
   
    <td class="td" align="right">VNindex</td>
  
    <td colspan="3" align="center">Trạng thái</td>
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td">{$key}</td>
    <td class="td"><a href="#" onclick="goEdit({$key})" class="title">{$item.date_create}</a></td>  
    <td class="td" align="right"><a href="#" onclick="goEdit({$key})">{$item.giatri1}</a></td>  
    
    <td class="td" align="right"><a href="#" onclick="goEdit({$key})">{$item.giatri3}</a></td>    
    
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer"><img src="images/{$item.ctrl}.gif"  /></td>
    <td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit({$key})" style="cursor:pointer" /></td>
    <td class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete({$key},document.frmListhieuqua)" style="cursor:pointer" /></td>
  </tr>
  {/foreach}
</table>
</form>