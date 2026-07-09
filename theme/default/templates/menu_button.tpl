<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  {assign var="k" value="0"}
	  {foreach key=key item=item from=$arr}	 
         {if $item.level=='0'}
          <tr>
			<td colspan="2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr  height="30">
                       <td  nowrap="nowrap" align="left" style="border-bottom:2px solid #0167b0" class="titleBlock">{$item.name}</td>
                        <td  nowrap="nowrap" width="100%" align="left" style="border-bottom:2px solid #c9cacb;">		
                            <img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" border="0" width="1" height="1" />
                        </td>
                  </tr>
                </table>
            </td>
          </tr>
         {else}
         <tr height="30">
			<td  nowrap="nowrap" align="left" style="border-bottom:1px dotted #c9cacb; padding-right:5px">		
				<img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/footer/iconmenu.gif" border="0" />
			</td>
			<td  nowrap="nowrap" align="left" style="border-bottom:1px dotted #c9cacb" width="100%">		
				<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}"  class="content" id="a{$key}">{$item.name}</a>
			</td>
          </tr>   
          {/if}
      {assign var="k" value="$k+1"}		
	  {/foreach}
 
</table>