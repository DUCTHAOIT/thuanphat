{literal}
	<script language="javascript">
		function checkForm()
		{
			var obj=document.frmmain;
			if(!obj.name.value)
			{
				alert('slide name!');
				obj.name.focus();
			}
			else
			{
				obj.submit();
			}
		}
		//
		function searchList(str)
		{
			AjaxRequest.get(
			{
			'url':'?m=product&f=slide&op=search&search='+ str
			,'onSuccess':function(req){document.getElementById('td_slideList').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		}
	</script>
{/literal}
<div style="text-transform:uppercase" class="title">Quản lý ảnh slide</div>
<form name="frmmain" action="?m=product&f=slide" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="logo" value="{$arr.logo}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" style="padding:10px; border:1px solid #D3D7DC">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap" class="td title">Tiêu đề</td>
        <td width="100%" class="td"><input type="text" name="name" style="width:100%" value="{$arr.name}" onkeyup="searchList(this.value);" /></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Mô tả</td>
        <td width="100%" class="td"><input type="text" name="des" style="width:100%" value="{$arr.des}" /></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Link:</td>
        <td width="100%" class="td"><input type="text" name="link" style="width:100%" value="{$arr.link}"/></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td class="td">
		<div id="logov">{if $arr.logo}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$arr.logo}" onclick="WindowUpload('logo')" style="cursor:pointer; max-width:500px" />{/if}</div>
		<label onclick="WindowUpload('logo')" style="cursor:pointer" class="title"> <i class="me-2 mdi mdi-folder-image"></i>Upload Image</label></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td title">Thứ tự:</td>
        <td width="100%" class="td"><input type="text" name="sort" style="width:10%" value="{$arr.sort}"/></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td align="left" class="td"><input type="button" class="btn btn-primary" value="{$Update}" onclick="checkForm();" /></td>
      </tr>
    </table></td>
   
  </tr>
</table>
</form>
 <div id="td_slideList">{slideList}</div>