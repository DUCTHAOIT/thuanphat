<script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/tooltip.js"></script>
{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==2}
		{assign var="k" value="0"}
		</tr><tr>		
	{/if}
	<td style="border:1px solid #D4D4D4; width:40%; padding:10px" valign="top" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td style="padding-left:10px;" valign="top">
				{if $arr[i].logo}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$arr[i].logo}" border="0" width="100" /></a>
				{/if}			</td>
		    <td width="30%" rowspan="2" align="center" valign="top" style="padding-left:10px;">								
				{if $arr[i].img}
					<div><a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$arr[i].img}" border="0" width="140" /></a>
				{else}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/none.gif" border="0" title="{$arr[i].name}"/></a>
			{/if}			</td>
	      </tr>
		  <tr>
		  	<td style="padding-left:10px;" valign="top" width="70%">
				<div><a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title">{$arr[i].name}</a></div>
				{if $arr[i].model}<div style="" class="content">Xuất xứ: {$arr[i].model}</div>{/if}
				<div style="text-decoration:line-through; color:#FF0000">{format_number number=$arr[i].price_old}</div>
				{if $arr[i].price}<div style="color:#FF0000"><strong>Giá: 	{format_number number=$arr[i].price}</strong></div>
				{else}<div style="color:#FF0000"><strong>Giá: [Xin liên hệ]</strong></div>{/if}			</td>
			</tr>
			<tr>			
		  </tr>
		</table>
	</td>	
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
</table>

<!--<div style="text-align:center; padding:10px;">{$sPage}</div>-->