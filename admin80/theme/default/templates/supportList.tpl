{literal}{/literal}
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
   <td class="td">Thứ tự</td>     
    <td class="td">Tên</td>
    <td class="td">Tell</td>
    <td class="td">Yahoo</td>
    <td class="td">Skype</td>  
     <td class="td"></td>  
  </tr>
  {if $arr}
  {assign var="i" value="1"}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
     <td class="td">{$item.no}</td>  	
    <td class="td"><a href="{$item.website}" target="_blank">{$item.nick}</a></td>
    <td class="td">{$item.tel}</td>  
    <td class="td">{$item.yahoo}</td>
    <td class="td">{$item.skype}</td>
	<td class="td">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>	</td>
   
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