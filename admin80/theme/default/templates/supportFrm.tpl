{literal}{/literal}
<form name="frmmain" action="?m=support" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<div class="topic">{$support_infomation}</div>
<table width="60%" border="1" cellspacing="0" cellpadding="0" class="table">
  
 <!-- 
   <tr>
    <td nowrap="nowrap" class="td">Kiểu</td>
    <td width="100%" class="td">
		<select name="yahoo" style="border:1px solid #cccccc;" onchange="technical();">		
		  <option value="0" style="padding-left:10px; padding-right:10px" {if $arr.yahoo=='0'} selected="selected" {/if}>&nbsp; &nbsp;Yahoo&nbsp; &nbsp;</option>
	      <option value="1" style="padding-left:10px; padding-right:10px" {if $arr.yahoo=='1'} selected="selected" {/if}>&nbsp; &nbsp;Skype&nbsp; &nbsp;</option>
		  <option value="2" style="padding-left:10px; padding-right:10px" {if $arr.yahoo=='2'} selected="selected" {/if}>&nbsp; &nbsp;Email&nbsp; &nbsp;</option>
		  <option value="3" style="padding-left:10px; padding-right:10px" {if $arr.yahoo=='3'} selected="selected" {/if}>&nbsp; &nbsp;Tell&nbsp; &nbsp;</option>
		</select>	
	</td>
  </tr>
  -->
  <tr>
    <td nowrap="nowrap" class="td">Tên</td>
    <td width="100%" class="td"><input type="text" name="nick" value="{$arr.nick}" class="text" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" class="td">Tell</td>
    <td width="100%" class="td"><input type="text" name="tel" value="{$arr.tel}" class="text" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" class="td">Yahoo</td>
    <td width="100%" class="td"><input type="text" name="yahoo" value="{$arr.yahoo}" class="text" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" class="td">Skype</td>
    <td width="100%" class="td"><input type="text" name="skype" value="{$arr.skype}" class="text" /></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" class="td">Mô tả</td>
    <td class="td"><textarea name="summary" style="height:150" class="text">{$arr.summary}</textarea></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">Thứ tự</td>
    <td class="td"><input type="text" name="no" class="text" value="{$arr.no}" style="width:50" /></td>
  </tr>
  <!--
  <tr>
    <td nowrap="nowrap" class="td">Thuộc nhóm</td>
    <td width="100%" class="td">
		<select name="type" style="border:1px solid #cccccc;">		
		  <option value="0" style="padding-left:10px; padding-right:10px"  {if $arr.type=='0'} selected="selected" {/if} >&nbsp; &nbsp;Kỹ thuật&nbsp; &nbsp;</option>
		  <option value="1" style="padding-left:10px; padding-right:10px" {if $arr.type=='1'} selected="selected" {/if}>&nbsp; &nbsp;Bán hàng&nbsp; &nbsp;</option>			  
		</select>
	</td>
  </tr>
  -->
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