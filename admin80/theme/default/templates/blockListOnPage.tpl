<!--Danh sach block tren trang-->
<form name="frmBlockOnPage" action="?m=block" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<input type="hidden" name="pid" value="{$pid}" />
<input type="hidden" name="pos" value="{$pos}" />
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table">
  <tr  class="tr">
    <td class="td" nowrap="nowrap">&nbsp;</td>
    <td class="td" nowrap="nowrap">{$Description_block}</td>
    <td align="center" style="padding-left:10px; padding-right:10px">{$Position}</td>
    <td align="center" style="padding-left:10px; padding-right:10px">{$Status}</td>
    <td align="right" style="padding-left:10px; padding-right:10px">{$Path}</td>
    <td align="right" style="padding-left:10px; padding-right:10px">&nbsp;</td>
  </tr>
  {foreach key=key item=item from=$arr}
  {assign var="order" value="$order+1"}
  <tr bgcolor="{cycle values="#FFFFFF,#F9F9F9"}">
    <td class="td" nowrap="nowrap" style="padding-left:{$padding}; padding-right:20px">{$order}</td>
    <td class="td" nowrap="nowrap" style="padding-left:{$padding}; padding-right:20px">{$item.des}</td>	
	<td align="center" style="padding-left:10px; padding-right:10px;" nowrap="nowrap"><img src="images/down.gif" onclick="orderBlock({$key},'down',document.frmBlockOnPage)" style="cursor:pointer" /> <img src="images/up.gif" onclick="orderBlock({$key},'up',document.frmBlockOnPage)" style="cursor:pointer" /></td>
	<td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap" id="lock_{$key}" onclick="callLock({$key})">	
	<img src="images/{$item.ctrl}.gif" style="cursor:pointer" /></td>
    <td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap">{$item.path}</td>
    <td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
	<img src="images/delete.gif" alt="Delete" onclick="goDelete({$key},document.frmBlockOnPage)" style="cursor:pointer" /></td>
  </tr>  
 {/foreach} 
 {if !$order}
 <tr>
    <td colspan="6" style="padding-bottom:10px; padding-top:10px; padding-left:10px; color:#FF0000" class="title">{$Not_block}</td>
  </tr>
 {/if}
</table>
</form>
<div align="right" bgcolor="#E9E9E9" style="padding-right:10px; padding-top:10px">{blockFrmAddOnpage}</div>
