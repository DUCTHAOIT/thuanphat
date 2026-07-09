{literal}
<script language="javascript" type="text/javascript">
function goEdit(id){
	document.frmBlockList.id.value=id;
	document.frmBlockList.op.value='frmBlock';
	document.frmBlockList.submit();	
}
function goDelete(id){
	if (confirm('Are you sure to delete?')!=0){
		document.frmBlockList.id.value=id;
		document.frmBlockList.op.value='delete';
		document.frmBlockList.submit();
	}
}
</script>
{/literal}
<table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="topic">{$Block_list}</td>
    <td align="right" class="title" style="color:#0000FF">{$countarr} Block</td>
  </tr>
</table>

<form name="frmBlockList" action="?m=block" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="" />
<input type="hidden" name="id" value=""  />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
    <td class="td">{$Block_description}</td>
    <td class="td" align="right">{$Position}</td>
    <td class="td" align="right">{$Create_date}</td>
    <td class="td" align="right">{$File_path}</td>
    <td>&nbsp;</td>
  </tr>
  {assign var="i" value="0"}
  {foreach key=key item=item from=$arr}
  {assign var="i" value="$i+1"}
  <tr bgcolor="{cycle values="#F9F9F9,#F5F5F5"}">
    <td class="td">{$i}</td>
    <td class="td">
	{if $item.ctrl==1}
	<a href="#" onclick="goEdit({$key})">{$item.des}</a>
	{else}
	{$item.des}
	{/if}	</td>
    <td class="td" align="right">{getLablePosition lableID=$item.position}</td>
    <td class="td" align="right">{$item.date}</td>
    <td class="td" align="right">{$item.path}</td>
    <td class="td" align="center">
	{if $item.ctrl==1}
	<img src="images/delete.gif" alt="Delete" onclick="goDelete({$key})" style="cursor:pointer" />
	{else}
	<img src="images/deleteOff.gif" />
	{/if}	</td>
  </tr>
  {/foreach}
</table>
</form>