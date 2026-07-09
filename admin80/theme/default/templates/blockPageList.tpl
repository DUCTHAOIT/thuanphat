<!--Danh sach cac trang-->
{literal}
{/literal}
<form name="frmListBlockOnPage" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="blockListOnPage" />
<input type="hidden" name="pid" value="" />
<input type="hidden" name="pos" value="" />
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table">
  <tr  class="tr">
    <td class="td" nowrap="nowrap">&nbsp;</td>
    <td class="td" nowrap="nowrap">{$Page_name}</td>
    <td colspan="3" align="center" style="padding-left:10px; padding-right:10px">{$Position}</td>
  </tr>
  {assign var="order" value="0"}
  {foreach key=key item=item from=$arr}
  {assign var="order" value=$order+1}
  <tr bgcolor="{cycle values="#FFFFFF,#F9F9F9"}" onmouseout="bgColor=''" onmouseover="bgColor='#F3F3F3'">
    <td class="td" nowrap="nowrap" style="padding-left:{$padding}; padding-right:20px">{$order}</td>
    <td class="td" nowrap="nowrap" style="padding-left:{$padding}; padding-right:20px">{$item.des}</td>
	<td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
	<a href="#" onclick="listBlockOnPage({$key},2,document.frmListBlockOnPage)">{$Left}</a></td>
    <td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap"><a href="#" onclick="listBlockOnPage({$key},16,document.frmListBlockOnPage)">{$Center}</a></td>
    <td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap"><a href="#" onclick="listBlockOnPage({$key},4,document.frmListBlockOnPage)">{$Right}</a></td>
  </tr>
 {/foreach}  
</table>
</form>