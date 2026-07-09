{literal}{/literal}
{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==3}
		{assign var="k" value="0"}
		</tr>
			<tr><td colspan="3" width="10px">&nbsp;</td>
		</tr>
		<tr>		
	{/if}
	<td style="border:0px solid #D4D4D4; width:30%; padding:10px">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" style="padding-left:10px;">				
				<div style="padding-bottom:5px"><a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title">{$arr[i].name}</a></div>
				<div>
				{if $arr[i].img}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}" class="title"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/albums/{$arr[i].img}" border="0" width="150" /></a>
				{else}
					<a href="{$arr[i].url}f=detail&{$smarty.const._ID_PRODUCT}={$arr[i].id}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/none.gif" border="0" title="{$arr[i].name}"/></a>
				{/if}</div>
			</td>			
		  </tr>
		</table>
	</td>
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
</table>
<div style="text-align:center; padding:10px;">{$sPage}</div>