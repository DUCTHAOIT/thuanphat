<form name="frmmain" action="?m=htmlpage" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2"><h2>{$Html_mannagement}</h2></td>
    </tr>
    
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$title}:</td>
    <td width="100%"><input type="text" name="title" class="form-control" value="{$arr.title}" /></td>
  </tr>
  
  
  <tr>
    <td align="right" style="padding-right:10px">{$Content} :</td>
    <td>{viewFckeditor content=$arr.content}</td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">File</td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8"><table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
            <td id="filePDFv">
			{if $arr.pdf}<img src="images/_.pdf.gif" />{/if}			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">Upload file</a></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px">{$Language}: </td>
    <td>{getCboLanguage lang=$arr.lang}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" class="btn btn-success btn-lg text-white" />	</td>
  </tr>  
</table>
</form>