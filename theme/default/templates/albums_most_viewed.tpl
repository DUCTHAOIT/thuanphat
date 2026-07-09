<script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/tooltip.js"></script>
{assign var="k" value="0"}
<div style="float:left; padding:0px 15px 5px 10px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/product_access.gif" /></div>
<div style="padding-top:15px; text-transform:uppercase; color:#8D0100"><strong>{$Products_most_viewed}</strong></div>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==2}
		{assign var="k" value="0"}		</tr><tr>	 	
	{/if}
	<td style="border:1px solid #D4D4D4; width:40%; padding:10px" valign="top">
		<table width="80%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  	<td style="padding-left:10px;" valign="top" width="30%">
				{if $arr[i].logo}
				<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$arr[i].logo}" border="0"  width="100"/></a>
				{/if}			</td>
			<td align="center" style="padding-left:5px;" valign="top" width="70%">							
				{if $arr[i].img}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"  onmouseout="UnTip()" onmouseover="Tip('<div><strong>Model:</strong> {$arr[i].model}</div><div style=color:#FF0000 class=title><strong>{$Price}: {format_number number=$arr[i].price}</strong></div><div>{$Promotion}: {$arr[i].promotion}</div><div class=title>{$Delivery}: {$arr[i].delivery}</div><div>{$arr[i].summary|nl2br}</div>',WIDTH, 350, SHADOW, true, BGCOLOR, '#ffffff',TITLE,'<div><img src={$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_red_right.gif> {$arr[i].name}</div>')"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$arr[i].img}" border="0" /></a>
				{else}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/none.gif" border="0" title="{$arr[i].name}"/></a>
				{/if}			</td>
			</tr>
			<tr>
			<td colspan="2" width="100%" style="padding-left:10px; padding-right:10px">
				<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title" onmouseout="UnTip()" onmouseover="Tip('<div><strong>Model:</strong> {$arr[i].model}</div><div style=color:#FF0000 class=title><strong>{$Price}: {format_number number=$arr[i].price}</strong></div><div>{$Promotion}: {$arr[i].promotion}</div><div class=title>{$Delivery}: {$arr[i].delivery}</div><div>{$arr[i].summary|nl2br}</div>',WIDTH, 350, SHADOW, true, BGCOLOR, '#ffffff',TITLE,'<div><img src={$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_red_right.gif> {$arr[i].name}</div>')">{$arr[i].name}</a>
				<div style="text-decoration:line-through; color:#FF0000">{format_number number=$arr[i].price_old}</div>
				<div style="color:#FF0000"><strong>{format_number number=$arr[i].price}</strong></div>								
				{if $arr[i].promotion}
				<div style="color:#0000FF"><strong>{$Promotion}:</strong> {$arr[i].promotion}</div>				
				{/if}			</td>
		  </tr>
		</table>	</td>	
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
</table>

<!--<div style="text-align:center; padding:10px;">{$sPage}</div>-->