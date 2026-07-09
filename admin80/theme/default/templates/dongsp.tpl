{literal}
	<script language="javascript">
		function checkForm()
		{
			var obj=document.frmmain;
			if(!obj.name.value)
			{
				alert('dongsp name!');
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
			'url':'?m=product&f=dongsp&op=search&search='+ str
			,'onSuccess':function(req){document.getElementById('td_dongspList').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		}
	</script>
{/literal}
<div style="text-transform:uppercase" class="title"></div>
<form name="frmmain" action="?m=product&f=dongsp" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="logo" value="{$arr.logo}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" style="padding:10px; border:1px solid #D3D7DC">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap" class="td title">Tên</td>
        <td width="100%" class="td"><input type="text" name="name" style="width:100%" value="{$arr.name}" onkeyup="searchList(this.value);" /></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Thứ tự</td>
        <td width="100%" class="td"><input type="text" name="sort" style="width:20%" value="{$arr.sort}" /></td>
      </tr>
	  <!--
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td class="td">
		<div id="logov">{if $arr.logo}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$arr.logo}" onclick="WindowUpload('logo')" style="cursor:pointer" />{/if}</div>
		<label onclick="WindowUpload('logo')" style="cursor:pointer" class="title">{$Company_logo}</label></td>
      </tr>
	  -->
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td align="right" class="td"><input type="button" value="{$Update}" onclick="checkForm();" /></td>
      </tr>
    </table></td>
    <td valign="top" style="padding-left:10px" id="td_dongspList">{dongspList}</td>
  </tr>
</table>
</form>