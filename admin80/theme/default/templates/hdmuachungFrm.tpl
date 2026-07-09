<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
<form name="frmmain" action="?m=hdmuachung" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addhdmuachung" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />
<input type="hidden" name="giaidoan" value="{$arr.giaidoan}" />
<input type="hidden" name="proid" value="{$arr.proid}" />
<input type="hidden" name="userid" value="{$arr.userid}" />

<div class="topic">{$Create}</div>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr class="tr" height="24">
    <td></td>
  </tr>  
  <tr>
    <td nowrap="nowrap" style="padding-right:10px">
		<table border="0" cellspacing="5" cellpadding="0" width="100%">
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">ID: </td>
		<td>{$arr.id}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Ngày đăng ký: </td>
		<td>{$arr.date_create}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Người Đk: </td>
		<td class="title" style="text-transform:uppercase">{$arr.name}</td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Khóa học: </td>
		<td>{$arr.nameproduct}</td>
	  </tr>
   
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Giá niêm yết: </td>
		<td>{format_number number=$arr.price}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Chiết khấu: </td>
		<td>Giảm {$arr.khuyenmai}%</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Tổng thanh toán: </td>
		<td style="color:#FF0000">{format_number number=$arr.tongtien}</td>
	  </tr>
      
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Người giới thiệu: </td>
		<td>{$arr.nguoigioithieu}</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Hoa hồng giới thiệu: </td>
		<td><input name="hoahong" id="hoahong" type="text" style="width:100%" class="text" maxlength="255" value="{format_number number=$arr.hoahong}" /></td>
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
		<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Lớp: </td>
		<td  style="padding-top:10px">		
		<select name="lop" id="lop" style="border:1px solid #cccccc;">	
        <option value="0" >-- Xếp lớp học --</option>		
		{foreach key=key item=item from=$arrLop}
		{if $key==$arr.lop}  			
		  <option value="{$key}" selected="selected" >{$item.name}</option>
		{else}
		  <option value="{$key}" >{$item.name}</option>
		{/if}	
		{/foreach}
		</select>
        </td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Ghi chú: </td>
		<td> <textarea name="content" class="textarea" style="height:100">{$arr.content}</textarea></td>
	  </tr>
   
   

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td ><input type="button" class="btn btn-primary" value="{$Update}" onclick="checkInput()"/></td>
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