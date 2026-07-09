<input type="hidden" name="add_text" id="add_text" value="1">
<table width="90%" border="0" cellpadding="0" cellspacing="0">
 <!--
  <tr>
	<td align="right" nowrap="nowrap" class="title" style="padding:5px">{$Username_technical}:</td>
	<td nowrap="nowrap"><input type="hidden" name="id[]" value="{$arr[0].id}"><input type="text" style="width:100%" value="{$arr[0].name}" name="technical[]" /><input type="text" style="width:40" name="order_number[]"  value="{$arr[0].order_number}"/> <label style="color:#FF0000">*</label> </td>
  </tr>
  -->
 
  <tr>

	<td nowrap="nowrap">
	{assign var="i" value="0"}
	{foreach key=key item=item from = $arrfile}
			<div>Tiêu đề: <input type="text" style="width:200px" value="{$item.name}" name="technical[]" />&nbsp;Thứ tự: <input type="text" style="width:50" name="order_number[]" value="{$item.order_number}" /><input type="hidden" name="idfile[]" value="{$item.id}">&nbsp;<input type="file" name="img_file[]" value="{$item.logo}"></div>
         
	{/foreach}	
	<div id="txt_1"></div></td>
  </tr>
  <tr>
	
	<td><input type="button" value="Add" onClick="fAddText();"> 
	&nbsp;</td>
  </tr>
</table>
{literal}
	<script language="javascript">
		function fAddText(){
			var str,id,idNext;
			id=document.frmmain.add_text.value;
			idNext=id+1;
			str='<div>Tiêu đề: <input type="text" value="" style="width:200px" name="technical[]" />&nbsp;Thứ tự: <input type="text" style="width:50" name="order_number[]" /><input type="hidden" name="idfile[]" value="">&nbsp;<input type="file" name="img_file[]"></div>';
			str= str + '<div id="txt_' + idNext  + '"></div>';
			document.getElementById('txt_'+ id).innerHTML = str;
			document.getElementById('add_text').value= idNext;
		}
	</script>
{/literal}