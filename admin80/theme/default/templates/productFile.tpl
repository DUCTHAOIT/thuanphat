{literal}
<script language="javascript" type="text/javascript">
	function callLock(id){
		AjaxRequest.get(
			{
			'url':'?m=product&op=lockFile&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function goEdit(id,f){
		document.frmList.fileID.value=id;
		document.frmList.op.value='addFile';	
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=product'
			  ,'onSuccess':function(req){ document.getElementById('projectListFile').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
	//
    //
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
			document.frmList.fileID.value=id;
			document.frmList.op.value='deleteFile';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=product'
				  ,'onSuccess':function(req){ document.getElementById('projectListFile').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );		  
			  return status;	
		}
	}	
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td style="padding:10px">{if $arr.img}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" width="140" />
		{else}
			Not image
		{/if}</td>
	<td align="left" valign="top" width="100%" style="padding:10px"><strong>{$arr.name}</strong></td>
  </tr>
</table>
<form name="frmmain" action="?m=product" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addFile" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="idFile" value="{$idFile}" />
<input type="hidden" name="file" value="{$arrFile.file}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:10px">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
		  <tr>
			<td align="left" colspan="2" valign="top" class="title" style="padding:5px; padding-left:10px; border-top:2px solid #6694E3; border-left:2px solid #6694E3; border-right:2px solid #6694E3 " bgcolor="#E0ECFF">{$Management_project_file}</td>
		  </tr>
		  <tr>
				<td bgcolor="#E0ECFF" align="right" style="padding-right:10px; padding-left:10px;  border-left:2px solid #6694E3;" nowrap="nowrap">{$Title}: </td>
				<td bgcolor="#E0ECFF" style="border-right:2px solid #6694E3; padding-right:5px"><input name="name" type="text" style="width:100%" class="text" maxlength="255" value="{$arrFile.name}" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#E0ECFF" style=" border-left:2px solid #6694E3;" >&nbsp;</td>
			<td bgcolor="#E0ECFF" width="100%" style="padding:5px; border-right:2px solid #6694E3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td id="filev"></td>
			  </tr>
			  {if $arrFile.file}
			   <tr>
				<td><img src="../../images/att.gif" /><a href="#" onclick="windowUploadFile('file')">{$arrFile.file}</a></td>
			  </tr>
			  {else}
			  <tr>
				<td><img src="../../images/att.gif" /><a href="#" onclick="windowUploadFile('file')">{$Insert_file}</a></td>
			  </tr>	  
			  {/if}
			</table>	</td>
		  </tr>
		  <tr>
			<td bgcolor="#E0ECFF" align="right" style="padding-right:10px; padding-left:10px; border-left:2px solid #6694E3;" nowrap="nowrap">{$Content}: </td>
			<td bgcolor="#E0ECFF" style="border-right:2px solid #6694E3; padding-right:5px">{viewFckeditor content=$arrFile.content}</td>
		  </tr>  
		  <tr>  
			<td bgcolor="#E0ECFF" style=" border-left:2px solid #6694E3;  border-bottom:2px solid #6694E3">&nbsp;</td>
			<td bgcolor="#E0ECFF" style="padding:5px; border-right:2px solid #6694E3; border-bottom:2px solid #6694E3" align="left"><input type="submit" class="buttoninput" value="{$Update}" /></td>
		  </tr>
		</table>
		</form>	
	</td>
  </tr>
</table>
<div id="productListFile">{productListFile}</div>