<table border="0" width="100%"  cellpadding="0" cellspacing="0">
  <tr>
  {foreach key=key item=item from=$arr} 
     <td  nowrap="nowrap" align="center">
        <div>
        	<a href="skype:{$item.skype}?chat"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/support/skype.png" title="{$value}" border="0"></a>
        </div>
        <div class="title" style="font-size:11px;">{$item.nick}</div>      
     </td>
	{/foreach}        
	</tr>	
</table>