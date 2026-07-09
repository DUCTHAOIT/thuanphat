{literal}{/literal}
{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==3}
		{assign var="k" value="0"}
		</tr><tr>		
	{/if}
	<td style="width:25%; padding:5px" valign="top" align="center">
		<table border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="center">
					{if $arr[i].img}	
						<table border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #d3d3d3;" bgcolor="#FFFFFF">
						  <tr>
							<td>
								<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}"  title="{$title}">						
									<img src="{$smarty.const._DOMAIN_ROOT_URL}/img/gopvon/{$arr[i].img}" border="0" vspace="1px" hspace="1px" width="200px" height="200px" alt="{$arr[i].name}" title="{$title}" /></a>
							</td>
						  </tr>
						</table>						
					{/if}
					</td>
				  </tr>
				  <tr>				    
				    <td valign="top" align="center" style="padding:10px">
						<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}" class="title"  title="{$title}">{$arr[i].name}</a>
				   </td>
	      		 </tr>				                 
				</table>			
	</td>	
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
</table>
<div style="text-align:center; padding:10px;">{$sPage}</div>