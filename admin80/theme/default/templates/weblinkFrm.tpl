{literal}{/literal}
<form name="frmmain" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update"  />
<input type="hidden" name="id" value="{$arr.id}"  />
<input type="hidden" name="fileName" value="{$arr.img}" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <tr>
      <td nowrap="nowrap">Tên</td>
      <td width="90%"><input type="text" name="name" value="{$arr.name}" style="width:40%" class="text" /></td>
    </tr>
    <tr>
      <td>Link</td>
      <td><input type="text" name="url" value="{$arr.url}" class="text" style="width:40%" /></td>
    </tr>
    <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
			{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/advertise/{$arr.img}" />{/if}
			</td>
           
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload logo</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
    <tr>
      <td>{$No}</td>
      <td><input type="text" name="no" value="{$arr.no}" class="text" style="width:10%" /></td>
    </tr>
    <tr>
      <td>{$Description}</td>
      <td><textarea name="des" class="textarea" style="height:100px">{$arr.des}</textarea></td>
    </tr>
    <tr>
      <td>{$Language}</td>
      <td>{getCboLanguage langID=$lang}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="button" class="btn btn-primary" onclick="callSubmit(document.frmmain)" value="{$Update}" /></td>
    </tr>
  </table>
</form>