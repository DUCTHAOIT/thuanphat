<form name="frmmain" action="?m=article" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td colspan="2" class="topic">Cập nhật tin bài</td>
    </tr>
  <tr>
    <td align="right" style="padding-right:10px">{$Date_create} :</td>
    <td width="100%">
    <div style="width:200px">
    	<input type="text" name="date" id="date" style="width:200px" value="{if $id}{$arr.date_create} {else} {$date_create} {/if}"  class="text" data-datepicker/>
         <div style="position:absolute; right:0; top:0; z-index:9; width:20px; height:30px; padding-top:10px"><i class="fal fa-calendar-alt"></i></div>
     </div>                        
	</td>
  </tr>  
  <tr>
    <td align="right" style="padding-right:10px">{$Group_name} :</td>
    <td>
	<select id="groupID" name="groupID[]" size="5" multiple="multiple" style="border:1px solid #cccccc;">
	{foreach key=key item=item from=$arrTopicArticle}
	<option value="{$key}" style="padding-left:10px; padding-right:10px" {$item.select} >{if $item.parent=='0'}{else}&nbsp; &nbsp;&nbsp; &nbsp;{/if}{$item.name} </option>
	{/foreach}	
	</select>
	</td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Article_name} :</td>
    <td><input type="text" name="name" class="text" value="{$arr.name}" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px">{$Images} :</td>
    <td>
	<div><strong>{$Photo_big_size}</strong><br /><em style="color:#666666">(w: 300px, h: 200px)</em></div>
	<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px">{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/article/{$arr.img}" />{/if}</td>
			<!-- <td id="fileName1v" style="padding-left:40px;">{if $arr.img1}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/article/{$arr.img1}" />{/if}</td>-->
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remote photo</strong></label></td>
			<!--
            <td style="padding-left:40px;">
			<label style="cursor:pointer" onclick="WindowUpload('fileName1')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg1()"><strong>Remote photo</strong></label>
			</td>
            -->
		  </tr>
		</table>	
		
		</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Images_title} :</td>
    <td><input type="text" name="title_img" class="text" value="{$arr.title_img}" /></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px">{$Summary} :</td>
    <td><textarea name="summary" class="textarea" style="height:150">{$arr.summary}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px">{$Content} :</td>
    <td>
	{viewFckeditor content=$arr.content}	</td>
  </tr>
  <tr>
	<td align="right" style="padding-right:10px">Tin tiêu biểu:</td>
	<td>
	<input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} />
	</td>
	</tr>
  <tr>
    <td align="right" style="padding-right:10px">{$Source} :</td>
    <td><input type="text" name="source" class="text" value="{$arr.source}" /></td>
  </tr>
  <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Thông tin hỗ trợ SEO</td>  
  </tr>
  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Title</td>
    <td width="100%" colspan="3"><textarea name="title" class="textarea" style="height:100">{$arr.title}</textarea></td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Description</td>
    <td width="100%" colspan="3"><textarea name="description" class="textarea" style="height:100">{$arr.description}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Keywords</td>
    <td width="100%" colspan="3"><textarea name="keywords" class="textarea" style="height:100">{$arr.keywords}</textarea></td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px">{$Language} :</td>
    <td>{getCboLanguage langID=$arr.lang}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" />	</td>
  </tr>
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
</table>
</form>