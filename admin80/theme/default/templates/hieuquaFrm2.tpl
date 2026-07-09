<form name="frmmain" action="?m=hieuqua2" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
  <tr>
    <td colspan="2" class="topic">Cập nhật</td>
    </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Date_create} :</td>
    <td width="100%" colspan="2" class="td">
	<input type="text" name="date" id="date" style="width:20%" class="text" value="{if $id}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button>	</td>
  </tr>  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Giá trị đơn vị đầu tư:</td>
    <td colspan="2" class="td"><input type="text" name="giatri1" class="text" value="{$arr.giatri1}" /></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">VNindex:</td>
   
    <td class="td"><input type="text" name="giatri3" class="text" value="{$arr.giatri3}" /></td>
  </tr>
 <!-- 
  <tr>
  	 <td class="td">Tăng trưởng đơn vị đầu tư:<input type="text" name="giatri2" class="text" value="{$arr.giatri2}" /></td>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Tên chuyên gia:</td>
    <td><input type="text" name="name" class="text" value="{$arr.name}" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px">{$Images} :</td>
    <td>
	<div><strong>{$Photo_big_size}</strong><br /><em style="color:#666666">(w: 200px, h: 300px)</em></div>
	<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px">{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/hieuqua/{$arr.img}" />{/if}</td>
			
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remote photo</strong></label></td>
			
		  </tr>
		</table>	
		
		</td>
  </tr>
 -->
  <tr>
    <td>&nbsp;</td>
    <td class="td">
	<input type="submit" value="Submit" />	</td>
  </tr>
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
		function removeImg(){
			document.getElementById('fileNamev').innerHTML="";
			document.frmmain.fileName.value="";
		}	
		function removeImg1(){
			document.getElementById('fileName1v').innerHTML="";
			document.frmmain.fileName1.value="";
		}		  
	</script>
	
	{/literal}
</table>
</form>