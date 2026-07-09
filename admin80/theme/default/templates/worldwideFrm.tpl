{literal}{/literal}
<form name="frmmain" action="?m=worldwide" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" name="position" value="0" />


<div class="topic">Thêm mới</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Danh mục: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;">			
		{foreach key=key item=item from=$arrTopicProduct}
		{if $item.id==$arr.catID}  			
		  <option value="{$key}" selected="selected"  style="padding-left:15px; padding-right:10px">{$item.name}</option>
		{else}
		  <option value="{$key}"  style="padding-left:15px; padding-right:10px">{$item.name}</option>
		{/if}	
		{/foreach}
		</select>	
  </tr>
  <tr>
    <td nowrap="nowrap" >Họ tên</td>
    <td width="100%" ><input type="text" name="name" value="{$arr.name}" class="text" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td >		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
			{if $arr.img}
			<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/worldwide/{$arr.img}" style="max-height:200px" />
			
			{/if}
			</td>
           
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload image</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
 
  <tr>
    <td nowrap="nowrap" >Địa chỉ</td>
    <td ><input type="text" value="{$arr.address}" name="address" class="text" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" >Điện thoại</td>
    <td ><input type="text" value="{$arr.tel}" name="tel" class="text" /></td>
  </tr>
  <!--<tr>
    <td nowrap="nowrap" >{$Website}</td>
    <td ><input type="text" value="{$arr.website}" name="website" class="text" /></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" >Tóm tắt</td>
    <td ><textarea name="address" style="height:150" class="text">{$arr.address}</textarea></td>
  </tr>
 -->
  <tr>
    <td nowrap="nowrap" >Ý kiến</td>
    <td >{viewFckeditor content=$arr.des}	</td>
  </tr>
 
  
  <!--
  <tr>
	<td nowrap="nowrap" >Vị trí:</td>
	<td>
	<select name="position" style="border:1px solid #cccccc;">	  
	  <option value="0" style="padding-right:10px" {if $arr.position=='0'} selected="selected" {/if} >&nbsp; &nbsp;factory</option>	  
	  <option value="1" style="padding-right:10px" {if $arr.position=='1'} selected="selected" {/if}>&nbsp; &nbsp; engineering company</option>
	      
	</select>		
	</td>
	</tr>
 -->
  <tr>
    <td nowrap="nowrap" >{$No}</td>
    <td ><input type="text" name="no" class="text" value="{$arr.no}" style="width:50" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" >{$Languages}</td>
    <td >{getCboLanguage langID=$lang}</td>
  </tr>  
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td ><input type="submit" value="Update" class="btn btn-primary" /></td>
  </tr>
</table>
</form>