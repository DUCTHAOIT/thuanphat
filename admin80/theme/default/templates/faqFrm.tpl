{literal}{/literal}
<form name="frmmain" action="?m=faq" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<div class="topic">{$Faq_infomation}</div>
<table width="60%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td nowrap="nowrap" class="td">{$Name}</td>
    <td width="100%" class="td">{$arr.name}</td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" class="td">{$Date}</td>
    <td class="td">{$arr.date}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Address}</td>
    <td class="td">{$arr.address}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Email}</td>
    <td class="td"><a href="mailto:{$arr.email}">{$arr.email}</a></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Mobile}</td>
    <td class="td">{$arr.mobile}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Subject}</td>
    <td class="td"><input type="text" class="text" name="subject" value="{$arr.subject}" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">{$Question}</td>
    <td class="td"><textarea name="question" class="text" style="height:100">{$arr.question}</textarea></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" class="td">{$Answer}</td>
    <td class="td"><textarea name="answer" style="height:150" class="text">{$arr.answer}</textarea></td>
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