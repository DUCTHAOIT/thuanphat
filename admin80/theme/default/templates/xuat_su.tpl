{literal}
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
	<script language="javascript">
		function checkForm()
		{
			var obj=document.frmmain;
			if(!obj.khoiluong.value)
			{
				alert('Khối lượng!');
				obj.khoiluong.focus();
			}
			else
			{
				obj.submit();
			}
		}
		//
		function searchList(str)
		{
			AjaxRequest.get(
			{
			'url':'?m=product&f=xuatsu&op=search&search='+ str
			,'onSuccess':function(req){document.getElementById('td_xuatsuList').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		}
	</script>
{/literal}
<div style="text-transform:uppercase" class="title">ĐẦU TƯ BỀN VỮNG TSBV</div>
<form name="frmmain" action="?m=tsbv&f=xuatsu" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="id" value="{$id}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" style="padding:10px; border:1px solid #D3D7DC">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap" class="td title">Ngày:</td>
        <td width="100%" colspan="2" class="td">
        <input type="text" name="date" id="date" style="width:20%" class="text" value="{if $id}{$arr.date} {else} {$date_create} {/if}" />&nbsp;
        <button id="btndate" class="button" style="height:20;">...</button>	</td>
      </tr> 
      <tr>
        <td nowrap="nowrap" class="td title">Tài sản ròng:</td>
        <td width="100%" class="td"><input type="text" name="taisan" style="width:50%" value="{$arr.taisan}" /></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td title">Tổng số lượng ĐVĐT TSI:</td>
        <td width="100%" class="td"><input type="text" name="khoiluong" style="width:50%" value="{$arr.khoiluong}"/></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Gía 1 ĐVĐT:</td>
        <td width="100%" class="td"><input type="text" name="giadvdt" style="width:50%" value="{$arr.giadvdt}"/></td>
      </tr>
      <tr>
	<td align="right" style="padding-right:10px; color:#FF0000">Giá ĐVĐT rút vốn là giá trị đóng cửa (sau 15h30) ngày thứ 5 hàng tuần</td>
	<td class="td">
		<input name="sort" type="checkbox" {if $arr.sort==1} checked="checked" {/if} />
	</td>
	</tr> 
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td align="left" class="td"><input type="button" value="{$Update}" onclick="checkForm();" /></td>
      </tr>
    </table></td>
    
  </tr>
</table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="padding-left:10px">{xuatsuList}</td>
  </tr>
</table>
{literal}
<script language="Javascript1.2">
	 Calendar.setup(
		{
		  inputField  : "date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "btndate",       // ID of the button
		  showsTime	  :	true
		}
	  );
</script>
{/literal}