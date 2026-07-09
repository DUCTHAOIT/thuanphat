{literal}
{/literal}
<form name="listNewsletter" action="?m=email" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="send" />
<table width="100%" border="10" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td width="100%" class="td">Email</td>
    
    <td align="center" class="td">Xác thực</td>
    <td class="td">&nbsp;</td>
    </tr>  
	  {foreach key=key item=item from=$arr}
	  <tr bgcolor="{cycle values="#FFFFFF,#F8F8F8"}">
	     <td class="td">{$key}</td>
		<td class="td" style="padding-left:20px">{$item.email}</td>
       
		<td align="center" class="td">
		{if $item.status==1}
		<img src="images/loai0.gif" alt="Đã xác thực" border="0" />
		{else}
		<img src="images/loai1.gif" alt="Chưa xác thực" border="0" />
		{/if}		</td>
		<td class="td"><a href="?m=email&op=delete&id={$key}"><img src="images/delete.gif" alt="Delete" style="cursor:pointer" border="0" /></a></td>
	  </tr>
	  {/foreach}
      <!--
	   <tr>
		<td align="right" style="padding-right:10px">{$Content} :</td>
		<td colspan="4" >{viewFckeditor content=$arr.content}</td>
	  </tr>
	  <tr>
	  	<td colspan="5" align="right"><input type="submit" value="Send" /></td>
	  </tr>
      -->
</table>
</form>