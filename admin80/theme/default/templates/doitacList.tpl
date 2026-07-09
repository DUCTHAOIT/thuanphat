{literal}{/literal}
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table border="1" width="100%" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
    <td class="td">{$Date}</td>
    <td class="td">Họ tên</td>
    <td class="td">Email</td>
    <td class="td">Người giới thiệu</td>
  </tr>
  {if $arr}
  {assign var="i" value="1"}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$i}</td>
    <td class="td">{$item.date}</td>
	
    <td class="td">
	<a href="?m=doitac&op=frmCreate&id={$item.username}"  ><strong>{$item.name}</strong></a></td>
    <td class="td">{$item.email}</td>
    <td class="td">{$item.gioithieu}</td>
   <!-- <td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete('{$item.id}',document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit('{$key}')" style="cursor:pointer" /> </label>
	<label id="lock_{$item.username}" onclick="callLock('{$item.username}')" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>	</td>-->
    </tr>
  {assign var="i" value=$i+1}
  {/foreach}
  {else}
  <tr>
    <td colspan="5" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  {/if}
</table>
</form>