<form name="frmmain" action="?m=htmlpage" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="title">{$Html_mannagement}</td>
    </tr>
    
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$title}:</td>
    <td width="100%"><input type="text" name="title" class="text" value="{$arr.title}" /></td>
  </tr>
  
  
  <tr>
    <td align="right" style="padding-right:10px">{$Content} :</td>
    <td>{viewFckeditor content=$arr.content}</td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px">{$Language}: </td>
    <td>{getCboLanguage lang=$arr.lang}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" />	</td>
  </tr>  
</table>
</form>