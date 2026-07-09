<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
<form name="frmmain" action="?m=hdgopvon" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addhdgopvon" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />
<input type="hidden" name="giaidoan" value="{$arr.giaidoan}" />
<input type="hidden" name="proid" value="{$arr.proid}" />
<input type="hidden" name="soxuatdautu" value="{$arr.soxuatdautu}" />

<div class="topic">{$Create}</div>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr class="tr" height="24">
    <td></td>
  </tr>  
  <tr>
    <td nowrap="nowrap" style="padding-right:10px">
		<table border="0" cellspacing="5" cellpadding="0" width="100%">
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số HĐ: </td>
		<td>GV-{$arr.id}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Ngày HĐ: </td>
		<td>{$arr.date_create}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Người mua: </td>
		<td>{$arr.name}</td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Dự án: </td>
		<td>{$arr.nameproduct}</td>
	  </tr>
     
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số cổ phần: </td>
		<td>{$arr.soxuatdautu}</td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số tiền / 1 cổ phần: </td>
		<td>{format_number number=$arr.sotienmotxuat}</td>
	  </tr>
     
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Tổng giá trị vốn góp: </td>
		<td>{format_number number=$arr.tongtien}</td>
	  </tr>
      
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số tiền Ck lần 1: </td>
		<td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="cklan1" id="cklan1" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.cklan1}" /></td>
                <td align="right" style="padding-right:10px" nowrap="nowrap">Ngày ck lần 1: </td>
        		<td ><input type="text" name="ngaycklan1" id="date1" style="width:50%" class="text" value="{if $arr.ngaycklan1}{$arr.ngaycklan1}{else}{$date_create}{/if}" />&nbsp;
        		<button id="btndate1" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
              </tr>
            </table>

        </td>
	  </tr>
     
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số tiền Ck lần 2: </td>
		<td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="cklan2" id="cklan2" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.cklan2}" /></td>
                <td align="right" style="padding-right:10px" nowrap="nowrap">Ngày ck lần 2: </td>
       			<td><input type="text" name="ngaycklan2" id="date2" style="width:50%" class="text" value="{$arr.ngaycklan2}" />&nbsp;
        		<button id="btndate2" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
              </tr>
            </table>

        </td>
	  </tr>
    
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">% Phí hoàn cọc: </td>
		<td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="phihoancoc" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.phihoancoc}" /></td>
                <td align="right" style="padding-right:10px" nowrap="nowrap">Hạn được phép hoàn cọc: </td>
        		<td><input type="text" name="ngayhoancoc" id="date" style="width:50%" class="text" value="{if $arr.ngayhoancoc}{$arr.ngayhoancoc}{/if}" />&nbsp;
        		<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
              </tr>
            </table>

        </td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Ghi chú: </td>
		<td> <textarea name="content" class="textarea" style="height:100">{$arr.content}</textarea></td>
	  </tr>
     <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">File tài liệu</td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8" colspan="3">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">  
          <tr>
          	<td>{$technicalList}</td>
          </tr>	        
         
        </table></td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Upload File tài liệu</td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8" colspan="3">
    	{$frmEdit}
    </td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td  colspan="3"><input type="button" class="button" value="{$Update}" onclick="checkInput()"/></td>
  </tr>
</table>
</form>
{literal}
<script language="Javascript1.2">
	$("#cklan1,#cklan2").on('keyup', function(){
		var n = parseInt($(this).val().replace(/\D/g,''),10);
		$(this).val(n.toLocaleString());
	});

	Calendar.setup(
		{
			inputField  : "date",         // ID of the input field
			ifFormat    : "%Y-%m-%d",    // the date format
			button      : "btndate",       // ID of the button
			showsTime	  :	true
		}
	);
	
	Calendar.setup(
		{
			inputField  : "date1",         // ID of the input field
			ifFormat    : "%Y-%m-%d",    // the date format
			button      : "btndate1",       // ID of the button
			showsTime	  :	true
		}
	);	
	
	Calendar.setup(
		{
			inputField  : "date2",         // ID of the input field
			ifFormat    : "%Y-%m-%d",    // the date format
			button      : "btndate2",       // ID of the button
			showsTime	  :	true
		}
	);	
	
	function checkInput(){
		var obj;	
	
		obj=document.frmmain;		
		
		if(!obj.cklan1.value){
			alert("Bạn cần nhập ck lần 1!");
			obj.cklan1.focus();
			return;
		}
		if(!obj.ngaycklan1.value){
			alert("Bạn cần nhập ngày ck lần 1!");
			obj.ngaycklan1.focus();
			return;
		}else{		
			obj.submit();
		}
	}
</script>
{/literal}