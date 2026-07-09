<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="7fb7f4"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" width="5" height="5"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #999999">
  <tr><td style="background-color:#c0c0c0; padding-bottom:0px"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/doitac_bg.jpg" border="0" /></td></tr>
  <tr>
  	{assign var="i" value="0"}
  	{foreach key=key item=item from = $arr}
	{if $i==1}
		</tr><tr>
		{assign var="i" value="0"}
	{/if}
    <td align="center"><a href="{$smarty.const._DOMAIN_ROOT_URL}/san_pham_hang_{$key}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$item.logo}" border="0" title="{$item.name}" hspace="5" vspace="5" /></a></td>
	{assign var="i" value="$i+1"}
	{/foreach}
  </tr>
</table>