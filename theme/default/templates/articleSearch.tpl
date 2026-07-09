{if $numberRecord=='0'}
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr>
	<td colspan="3" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" nowrap="nowrap"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/l.gif" border="0" ></td>
			<td class="title" width="100%" align="left" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/b.gif); background-repeat:repeat-x;">{$Results}</td>
			<td align="right" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/r.gif" border="0" ></td>
		  </tr>
	</table></td>       
  </tr>
  <tr>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgLeft.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgLeft.gif" /></td>		
	<td width="100%" style="padding-top:10px; padding-left:10px; padding-right:10px;">
	 	{$NotFound}
	</td>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgRight.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgRight.gif" /></td>
  </tr>			 			 
  <tr>
	<td valign="top" align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/LeftB.gif" /></td>
	 <td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgB.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgB.gif" /></td>
    <td valign="top" align="right"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/RightB.gif" /></td>
  </tr>
</table>
{else}
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr>
	<td colspan="3" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" nowrap="nowrap"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/l.gif" border="0" ></td>
			<td class="title" width="100%" align="left" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/b.gif); background-repeat:repeat-x;">{$Results}</td>
			<td align="right" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/news/r.gif" border="0" ></td>
		  </tr>
	</table></td>       
  </tr>
  <tr>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgLeft.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgLeft.gif" /></td>		
	<td width="100%" id="articleList" style="padding-top:10px; padding-left:10px; padding-right:10px;">	 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        {assign var="i" value="0"}
        {section name=i loop=$arr start=$pageID max=$limit}
        {assign var="i" value="1"}
        <tr>
      <td width="100%" class="content" style="padding-right:10px; padding-top:10px; text-align:justify"> {if $arr[i].img}
        <table border="0" style="border:0px solid #993300"  align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding-right:10" align="center"><a href="{$arr[i].url}op=detail&{$smarty.const._ID_ARTICLE}={$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/article/{$arr[i].img}" border="0"  width="160" vspace="2" hspace="2" /></a> </td>
            </tr>
          </table>
        {/if} <font class="title"><a href="{$arr[i].url}op=detail&{$smarty.const._ID_ARTICLE}={$arr[i].alias}" class="title">{$arr[i].name}</a></font><br />
          <font class="content" style="text-align:justify">{$arr[i].summary|nl2br}</font></td>
        </tr>
    <tr>
      <td width="100%" style="border-bottom:1px dotted #990000" >&nbsp;</td>
    </tr>
        {/section}
      </table>
	  <div style="padding:10px" align="center">{$sPage}</div>
	</td>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgRight.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgRight.gif" /></td>
  </tr>			 			 
  <tr>
	<td valign="top" align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/LeftB.gif" /></td>
	 <td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgB.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/BgB.gif" /></td>
    <td valign="top" align="right"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/RightB.gif" /></td>
  </tr>
</table>
{/if}

