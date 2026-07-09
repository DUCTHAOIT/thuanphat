{literal}
<script language="javascript" type="text/javascript">
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
		document.frmList.photoID.value=id;
		document.frmList.op.value='deletePhoto';				
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('albumsListPhoto').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  progress('albumsListPhoto');
		  return status;	
	}
	}
</script>
{/literal}
<form name="frmmain" action="?m=albums" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addPhoto" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="imgsmall" value="{$arrPhoto.img}" />
<input type="hidden" name="imgbig" value="{$arrPhoto.img1}" />
<input type="hidden" name="idPhoto" value="{$arrPhoto.id}" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" style="padding-bottom:15px;"><strong>{$Management_albumss} {$arr.name}</strong></td>
    </tr>
  <tr>
    <td align="center">
		{if $arr.img}
	<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/albums/{$arr.img}" />
	{else}
		Not image
	{/if}</td>
    <td width="100%" style="padding-left:50px">
	<div style="color:#FF0000; padding-bottom:15px"><strong>{$Photo_size}</strong></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><div><strong>W:74px - H: 74px</strong></div>
			<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img src="{$arrPhoto.imgs_view}" border="0" /></a></div></td>
		<td><div><strong>W:500px - H: 500px</strong></div>
			<div id="imgbigv"><a href="#" onclick="WindowUpload('imgbig')"><img src="{$arrPhoto.imgb_view}" border="0" /></a></div></td>
	  </tr>
	</table>	</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td style="padding-left:50px; padding-top:20px"><input type="submit" value="{$Update}" /></td>
  </tr>
</table>
</form>
<div style="padding-bottom:10px; padding-top:10px" class="title">{$Photo_relation}</div>
<div id="albumsListPhoto">{albumsListPhoto}</div>
