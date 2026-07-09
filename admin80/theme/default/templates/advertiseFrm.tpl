{literal}{/literal}
<div>
<h4 class="page-title">Thêm mới quảng cáo</h4>
<form name="frmmain" action="?m=advertise" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" name="position" value="0" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap="nowrap" class="td">Tiêu đề</td>
    <td width="100%" class="td"><input type="text" name="name" value="{$arr.name}" class="form-control" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" class="td">Tiêu đề 2</td>
    <td class="td"><input type="text" value="{$arr.address}" name="address" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td">		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
            <a href="#" onclick="WindowUpload('fileName')">
			{if $arr.img}
			<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/advertise/{$arr.img}" style="max-height:200px" />
			
			{/if}
            </a>
			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload logo</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
 
  <tr>
    <td nowrap="nowrap" class="td">{$Tel}</td>
    <td class="td"><input type="text" name="tel" value="{$arr.tel}" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Website}</td>
    <td class="td"><input type="text" value="{$arr.website}" name="website" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Description}</td>
    <td class="td"><textarea name="des" style="height:150" class="form-control">{$arr.des}</textarea></td>
  </tr>
 
  <tr>
	<td nowrap="nowrap" class="td">Vị trí:</td>
	<td  class="td">
	<select name="position"  class="select2 form-select shadow-none form-control"
                        style="width: 30%; height: 36px">	  
	 <!--
      <option value="0" style="padding-right:10px" {if $arr.position=='0'} selected="selected" {/if} >&nbsp; &nbsp;Popup (height=265px)</option>	  
	 	 
     
	  <option value="3" style="padding-right:10px" {if $arr.position=='3'} selected="selected" {/if}>&nbsp; &nbsp; Giờ vàng (620px - 430px)</option>	
       <option value="4" style="padding-right:10px" {if $arr.position=='4'} selected="selected" {/if}>&nbsp; &nbsp; Những con số (280px - 114px)</option>
    -->
     <option value="1" style="padding-right:10px" {if $arr.position=='1'} selected="selected" {/if}>&nbsp; &nbsp; Đối tác</option>
     <option value="2" style="padding-right:10px" {if $arr.position=='2'} selected="selected" {/if} >&nbsp; &nbsp;Giữa trên Home</option>	
     <option value="3" style="padding-right:10px" {if $arr.position=='3'} selected="selected" {/if}>&nbsp; &nbsp; Footer</option>	   	 
	</select>		
	</td>
	</tr>
  
  <tr>
    <td nowrap="nowrap" class="td">{$No}</td>
    <td class="td"><input type="text" name="no" class="form-control" value="{$arr.no}" style="width:50" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Languages}</td>
    <td class="td">{getCboLanguage langID=$lang}</td>
  </tr>  
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td"><input type="submit" value="Update" class="btn btn-primary" /></td>
  </tr>
</table>
</form>
</div>