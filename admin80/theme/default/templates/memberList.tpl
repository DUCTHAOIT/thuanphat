<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">
    <td class="td">{$No}</td>
	<td class="td">&nbsp;</td>
    <td class="td">{$Email}</td>
    <td class="td">{$Last_name}</td>
    <td class="td">{$Mobile}</td>
    <td class="td">{$Address}</td>
    <td class="td">{$Number_access}</td>
    </tr>
  {if $arr}
  {assign var="i" value=1}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$i}</td>
	<td class="td">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>
	</td>
    <td class="td"><a href="mailto:{$item.email}">{$item.email}</a></td>
    <td class="td">{$item.fullname}</td>
    <td class="td">{$item.mobile}</td>
    <td class="td">{$item.address}</td>
    <td class="td">{$item.num}</td>
    </tr>
  {assign var="i" value=$i+1}
  {/foreach}
  {else}
  <tr>
    <td colspan="7">{$Cannot_member}</td>
  </tr>
  {/if}
</table>
</form>