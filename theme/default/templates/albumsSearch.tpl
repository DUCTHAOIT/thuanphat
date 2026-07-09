<script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/tooltip.js"></script> 
{literal}{/literal}
{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==2}
		{assign var="k" value="0"}
		</tr>
			<tr><td colspan="2" width="10px">&nbsp;</td>
		</tr>
		<tr>		
	{/if}
	<td style="border:1px solid #D4D4D4; width:50%; padding:10px">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" style="padding-left:10px;">
				{if $arr[i].logo}
				<div><a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$arr[i].logo}" border="0" /></a></div>
				{/if}
				<div>
				{if $arr[i].img}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"  onmouseout="UnTip()" onmouseover="Tip('<div><strong>Model:</strong> {$arr[i].model}</div><div style=color:#FF0000 class=title><strong>{$Price}: {format_number number=$arr[i].price}</strong></div><div>{$Promotion}: {$arr[i].promotion}</div><div class=title>{$Delivery}: {$arr[i].delivery}</div><div>{$arr[i].summary|nl2br}</div>',WIDTH, 350, SHADOW, true, BGCOLOR, '#ffffff',TITLE,'<div><img src={$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_red_right.gif> {$arr[i].name}</div>')"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$arr[i].img}" border="0" /></a>
				{else}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/none.gif" border="0" title="{$arr[i].name}"/></a>
				{/if}</div>
			</td>
			<td width="100%" style="padding-left:10px; padding-right:10px">
				<div><a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title" onmouseout="UnTip()" onmouseover="Tip('<div><strong>Model:</strong> {$arr[i].model}</div><div style=color:#FF0000 class=title><strong>{$Price}: {format_number number=$arr[i].price}</strong></div><div>{$Promotion}: {$arr[i].promotion}</div><div class=title>{$Delivery}: {$arr[i].delivery}</div><div>{$arr[i].summary|nl2br}</div>',WIDTH, 350, SHADOW, true, BGCOLOR, '#ffffff',TITLE,'<div><img src={$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_red_right.gif> {$arr[i].name}</div>')">{$arr[i].name}</a></div>
				<div style="text-decoration:line-through; color:#FF0000">{format_number number=$arr[i].price_old}</div>
				<div style="color:#FF0000"><strong>{format_number number=$arr[i].price}</strong></div>				
				<div><strong>{$Delivery}:</strong> {$arr[i].delivery}</div>
				<div style="color:#0000FF"><strong>{$Promotion}:</strong> {$arr[i].promotion}</div>
				<div style="padding-top:5px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_buy_now.gif" onclick="javascript:addToShoppingCart({$arr[i].id})" style="cursor:pointer"></div>
				<div id="addToShoppingCart_{$arr[i].id}"></div>
			</td>
		  </tr>
		</table>
	</td>
	{if $k==0}
		<td>&nbsp;</td>
	{/if}
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
</table>
<div style="text-align:center; padding:10px;">{$sPage}</div>