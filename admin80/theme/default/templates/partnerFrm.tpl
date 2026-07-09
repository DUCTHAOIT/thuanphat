<h2>Thêm mới</h2>
<form name="frmmain" action="?m=partner" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
 
  <tr>
    <td align="right" style="padding-right:10px">{$Group_name} :</td>
    <td>
	<select id="groupID" name="groupID[]" size="5" multiple="multiple" style="border:1px solid #cccccc;">
	{foreach key=key item=item from=$arrTopicpartner}
	<option value="{$key}" style="padding-left:{$item.level*15}px; padding-right:10px" {$item.select} >&nbsp; &nbsp;{$item.name} </option>
	{/foreach}	
	</select>
	</td>
  </tr>
 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Tên:</td>
    <td><input type="text" name="name" class="form-control" value="{$arr.name}" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px">{$Images} :</td>
    <td>
	
	<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px">{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/partner/{$arr.img}" />{/if}</td>
			
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong><i class="me-2 mdi mdi-folder-image"></i> Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label></td>
			
		  </tr>
		</table>	
		
		</td>
  </tr>

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Chức danh:</td>
    <td><input type="text" name="summary" class="form-control" value="{$arr.summary}" /></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px">Ý kiến:</td>
    <td>
	{viewFckeditor content=$arr.content}	</td>
  </tr> 
  <!--
  <tr>
    <td align="right" style="padding-right:10px">Lợi ích:</td>
    <td>
	{viewFckeditors contents=$arr.loiich}	</td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px">Ai nên học:</td>
    <td>
	{viewFckeditor1 content1=$arr.ainenhoc}	</td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px">Giảng viên:</td>
    <td>
	{viewFckeditor2 content2=$arr.giangvien}	</td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px">Nội dung:</td>
    <td>
	{viewFckeditor3 content3=$arr.noidung}	</td>
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px">Thông tin:</td>
    <td>
	{viewFckeditor4 content4=$arr.thongtin}	</td>
  </tr> 
   <tr>
    <td align="right" style="padding-right:10px">Ưu đãi:</td>
    <td>
	{viewFckeditor5 content5=$arr.uudai}	</td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Tài liệu</td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
            <td id="filePDFv">
			{if $arr.pdf}<img src="images/_.pdf.gif" />{/if}			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">Upload file</a></td>
          </tr>
        </table></td>
  </tr>
  -->  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Date_create} :</td>
    <td width="100%">
	<input type="text" name="date" id="date" style="width:20%" class="text" value="{if $id}{$arr.date_create} {else} {$date_create} {/if}" /><i class="fal fa-calendar-alt" id="btndate"></i></td>
  </tr>  
  <!--
  <tr>
    <td align="right" style="padding-right:10px">{$Language} :</td>
    <td>{getCboLanguage langID=$arr.lang}</td>
  </tr>
  -->
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" class="btn btn-primary" />	</td>
  </tr>
  
</table>
</form>
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