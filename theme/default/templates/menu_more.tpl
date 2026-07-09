<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr height="25px">
	  {assign var="k" value="1"}
	  {foreach key=key item=item from=$arr}	
			<td style="padding-left:5px; padding-right:5px;" nowrap="nowrap" align="center">		
				<div><i class="fa fa-angle-right" aria-hidden="true" style="color:#FFFFFF"></i>&nbsp;<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}" style="font-size:12px; color:#FFFFFF" class="contentfooter" >{$item.name}</a></div>
			</td>
      {assign var="k" value="$k+1"}		
	  {/foreach}    
  </tr>
</table>