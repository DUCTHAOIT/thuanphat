{literal}{/literal}
<form name="frmmain" action="?m=photo" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" name="fileName1" value="{$arr.img1}" />
<input type="hidden" name="parent" value="{$parent}" />
<div class="topic">{$Advertise_infomation}</div>
<table width="80%" border="1" cellspacing="0" cellpadding="0" class="table">  
  {if !$parent}
  <tr>
    <td nowrap="nowrap" class="td">Đầu mục</td>
    <td class="td">
		<select name="groupID">
			<option value="0"></option>			
			{foreach key=key item=item from=$arrGroup}
				{if $arr.catID==$key}
				<option value="{$key}" selected="selected">{$item.name}</option>	
				{else}
				<option value="{$key}">{$item.name}</option>
				{/if}
			{/foreach}
		</select>
	</td>
  </tr>
  {/if}
  <tr>
    <td nowrap="nowrap" class="td">Tên</td>
    <td width="100%" class="td"><input type="text" name="name" value="{$arr.name}" class="text" /></td>
  </tr>
   <tr>
    <td>Mô tả</td>
    <td><div id="des"><textarea name="des" class="textarea" style="width:100%; height:100">{$arr.des}</textarea></div></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Upload ảnh đại diện</td>
    <td>
     <div id="fileName1v" style="padding:10px;">{if $arr.img1}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/photo/thumbs/{$arr.img1}" style="max-width:200"/>{/if}</div>	
    <div  style="padding:10px;">
    <label style="cursor:pointer" onclick="WindowUpload('fileName1')"><strong>Upload thumbnail (khích thước: 300px-200px)</strong></lable> &nbsp; | &nbsp;
    <label style="cursor:pointer" onclick="removeImg1()"><strong>Remove thumbnail</strong></label>
    </div>   
 </td>
 </tr>
 <tr>   
    <td>Upload ảnh lớn</td>
    <td >
    <div id="fileNamev" style="padding:10px">{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/photo/{$arr.img}" style="max-width:350" />{/if}</div>	
    <div  style="padding:10px;">
    <label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
    <label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label>
    </div>
    </td>        
  </tr>
  <tr>
    <td nowrap="nowrap" >Thứ tự</td>
    <td class="td"><input type="text" name="no" class="text" value="{if $arr.no}{$arr.no}{else}0{/if}" style="width:50" /></td>
  </tr>
 <!--
  <tr>
  	 <td nowrap="nowrap" style="padding-right:10px">{$Focus}?</td>
    <td class="td"><input type="checkbox" name="focus" id="focus" value="1" {if $arr.focus} checked="checked" {/if} /></td>      
  	</tr>
  -->  
  <tr>
    <td nowrap="nowrap" class="td">{$Languages}</td>
    <td class="td">{getCboLanguage langID=$lang}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td"><input type="submit" value="Update" class="button" /></td>
  </tr>
</table>
</form>
{literal}
<script language="Javascript1.2">						  
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