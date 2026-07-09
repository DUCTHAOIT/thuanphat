{literal}{/literal}
<form name="frmmain" action="?m=video" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />
<div class="topic">{$video_infomation}</div>
<table width="60%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td nowrap="nowrap" class="td">{$Name}</td>
    <td width="100%" class="td"><input type="text" name="name" value="{$arr.name}" class="text" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td">		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
			{if $arr.img}
			<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/video/{$arr.img}" />
			{else}
			<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/none.gif" />
			{/if}
			</td>
            <td style="padding-left:10px" id="fileName1v">
			{if $arr.img1}Flash	{/if}
			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')">Upload image (W:280 - H: 246)</a></td>
            <td><a href="#" onclick="WindowUpload('fileName1')">Upload Video (.flv)</a></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">Video nổi bật</td>
    <td class="td"><input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} /></td>
  </tr> 
  <tr>
    <td nowrap="nowrap" class="td">{$Description}</td>
    <td class="td"><textarea name="des" style="height:150" class="text">{$arr.des}</textarea></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$No}</td>
    <td class="td"><input type="text" name="no" class="text" value="{$arr.no}" style="width:50" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Languages}</td>
    <td class="td">{getCboLanguage langID=$lang}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td"><input type="submit" value="Update" class="button" /></td>
  </tr>
</table>
</form>