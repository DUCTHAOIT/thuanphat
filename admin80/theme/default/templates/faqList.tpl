{literal}{/literal}
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
  	<td class="td">{$Address}</td>
    <td class="td">&nbsp;</td>
	<td class="td">&nbsp;</td>
    <td class="td">Họ tên</td>
    <td class="td">Điện thoại</td>
    <td class="td">Email</td>
    
    <td class="td">{$No}</td>
  </tr>
  {if $arr}
  {assign var="i" value=1}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
    <td class="td">{$i}</td>
	<td class="td">{$item.date_create}</td>
    <td class="td" ><strong>{$item.subject}</strong><br />				
	<div>{$item.question}</div>
	</td>
    <td class="td">{$item.name}</td>
    <td class="td">{$item.mobile}</td>
    <td class="td"><a href="mailto:{$item.email}" target="_blank">{$item.email}</a></td>
    
    <td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	</td>
    </tr>
  {assign var="i" value=$i+1}
  {/foreach}
  {else}
  <tr>
    <td colspan="8" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  {/if}
</table>
</form>