<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
<form name="frmmain" action="?m=voucher" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addvoucher" />
<input type="hidden" name="id" value="{$arr.id}" />

<div class="topic">Tạo mới voucher</div>
<table border="0" cellspacing="5" cellpadding="0" width="100%">
	 
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số lượng: </td>
		<td width="100%"><input name="soluong" type="text" style="width:100%" class="form-control" maxlength="255" value="{$arr.soluong}" /></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">% mức giảm:</td>
		<td><input name="loai" type="text" style="width:100%" class="form-control" maxlength="20" value="{$arr.loai}" /></td>
	  </tr>
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Ghi chú:</td>
	    <td><input name="des" style="width:100%" type="text" class="form-control" maxlength="20" value="{$arr.des}" /></td>
	  </tr>

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td><input type="button" class="btn btn-primary" value="{$Update}"  onclick="checkInput(document.frmmain);" /></td>
  </tr>
</table>
</form>
{literal}
<script language="Javascript1.2">
	
	function checkInput(){
		var obj;	
	
		obj=document.frmmain;		
		
		if(!obj.soluong.value){
			alert("Bạn cần nhập Số Voucher!");
			obj.soluong.focus();
			return;
		}
		if(!obj.loai.value){
			alert("Bạn cần nhập % Giá trị giảm!");
			obj.loai.focus();
			return;
		}		
		else{		
			obj.submit();
		}
	}
</script>
{/literal}