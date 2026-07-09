<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td style="padding-right:10px"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/basket.gif" border="0" /></td>
	<td style="padding-right:10px; color:#175b96" nowrap="nowrap">Giỏ hàng</td>
    <td width="100%" align="right" style="padding-right:10px;" nowrap="nowrap"><strong><a style="color:#FF0000" href="{$smarty.const._DOMAIN_ROOT_URL}/view_basket/">Đặt hàng</a></strong></td>    
  </tr> 
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="content" style="color:#175b96; padding:10px" nowrap="nowrap">Tổng số:</td>
	 <td width="100%" align="left" style="color:#175b96" nowrap="nowrap"><a style="color:#175b96" href="{$smarty.const._DOMAIN_ROOT_URL}/view_basket/" class="content">{$str}</a></td> 
  </tr>
  <tr>
	<td class="content" style="color:#175b96; padding-left:10px" nowrap="nowrap">Tổng tiền:</td>
	<td  class="content" style="color:#175b96;" nowrap="nowrap">{format_number number=$total}</td>
  </tr>
	<tr>
		<td colspan="2" style="border-bottom:1px dotted #CCCCCC">&nbsp;</td>
	</tr>
</table>
