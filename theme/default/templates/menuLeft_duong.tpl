<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left" valign="top"><img src="theme/{$theme}/images/center/menu_header_left.gif" /></td>
		<td bgcolor="#250706" width="100%"></td>
		<td align="right" valign="top"><img src="theme/{$theme}/images/center/menu_header_right.gif" /></td>
	  </tr>
	</table></td>
  </tr>
  <tr  height="100%">
    <td><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top"><img src="theme/{$theme}/images/center/menu_top_left.gif" /></td>
		  </tr>
		  <tr height="100%">
			<td valign="top" style="background-image:url(theme/{$theme}/images/center/menu_bag.gif);background-repeat:repeat-y;"><img src="theme/{$theme}/images/center/menu_bag.gif" /></td>
		  </tr>
		  <tr>
			<td valign="bottom"><img src="theme/{$theme}/images/center/menu_bottom_left.gif" /></td>
		  </tr>
		</table></td>
    <td bgcolor="#250706" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      {foreach key=key item=item from=$arr}
      <tr>
        <td style="padding-left:10px; padding-right:10px;">
          <div style="padding-left:{$item.level*5+5}; padding-bottom:3px; padding-top:3px;" id="{$item.id}">
		  	{if $item.parent=="0"}
				 <img src="theme/{$theme}/images/center/menu_icon1.gif" />&nbsp;
				 <a href="#&{$smarty.const._MARK}={$item.parent}_{$item.id}" id="a{$item.id}" class="title" style="color:#b5784b">{$item.name}</a>
			{else} 
				<img src="theme/{$theme}/images/center/menu_icon2.gif" />&nbsp;
				<a href="{$item.url}&{$smarty.const._MARK}={$item.parent}_{$item.parent}_{$item.id}" id="a{$item.id}" style="color:#b5784b" class="leftMenu">{$item.name}</a>
			{/if}
		 </div></td>
      </tr>
      <tr height="1"><td style="padding-left:10px; padding-right:10px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
             <td bgcolor="#4b4b4b" width="100%"></td>
        </tr>
        </table></td></tr>
      {/foreach}
    </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</td>
  </tr>
  
  
  <tr>
    <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left" valign="bottom"><img src="theme/{$theme}/images/center/menu_footer_left.gif" /></td>
		<td bgcolor="#250706" width="100%"></td>
		<td align="right" valign="bottom"><img src="theme/{$theme}/images/center/menu_footer_right.gif" /></td>
	  </tr>
	</table></td>
  </tr>
</table>
