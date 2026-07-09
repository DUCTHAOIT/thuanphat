<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td bgcolor="#E9E9E9" style="padding:10px; border:1px solid #cccccc">
		<div style="padding-bottom:20px;"><strong>{$more_technical_early_entry} {$catName}</strong></div>
		{$frmEdit}</td>
	  </tr>
	</table>

	</td>
  </tr>
  <tr>  
    <td valign="top" style="padding-left:20px;">{$technicalList}</td>
  </tr>
  
</table>
{literal}
	<script language="javascript">
		function fAddText(){
			var str,id,idNext;
			id=document.frmTechnical.add_text.value;
			idNext=id+1;
			str='<div><input type="hidden" name="id[]" value=""><input type="file" name="img_file[]"><input type="text" value="" style="width:100%" name="technical[]" /><input type="text" style="width:40" name="order_number[]" /></div>';
			str= str + '<div id="txt_' + idNext  + '"></div>';
			document.getElementById('txt_'+ id).innerHTML = str;
			document.getElementById('add_text').value= idNext;
		}
	</script>
{/literal}