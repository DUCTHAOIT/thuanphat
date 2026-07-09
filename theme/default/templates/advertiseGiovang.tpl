<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="titleBlock" style="margin:0" nowrap="nowrap">{if $lang=='vn'}Khuyến mại{else}Gold Hour{/if}</td>
      <td nowrap="nowrap" align="right" width="100%" style="border-bottom:1px solid #ebebeb;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 	
   {assign var="i" value="0"}
    {foreach item=item key=key from=$arr}					
    <td align="left" {if $i=='1'} style="padding-left:20px"{/if}>
    {if $item.img}<a href="{$item.website}" target="_blank"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}" border="0" /></a>{/if}
   </td>	
   {assign var="i" value="$i+1"}	 
   {/foreach}
</table>