{literal}{/literal}
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
	<td class="td">&nbsp;</td>
    <td class="td">Người gửi</td>
    <td class="td">Nội dung ý kiến</td>   
    <td class="td">Sản phẩm</td>   
  </tr>
  {if $arr}
  {assign var="i" value="1"}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$i}</td>
	<td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>	</td>
    <td class="td">
		<strong>{$item.name}</strong><br /><a href="mailto:{$item.email}" target="_blank">{$item.email}</a>
		<br />{$item.address }
		<br />{$item.date_create}</td>
	<td class="td" >		
	<div><a href="#" onclick="goEdit({$key})" >{$item.question}</a></div>
	</td>
    <td class="td">{$item.articlename}</td>  
    </tr>
  {assign var="i" value="$i+1"}
  {/foreach}
  {else}
  <tr>
    <td colspan="8" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  {/if}
</table>
</form>