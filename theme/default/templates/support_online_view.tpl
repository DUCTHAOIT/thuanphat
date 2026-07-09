<table border="0"  width="100%" cellpadding="0" cellspacing="0">
  {foreach key=key item=item from=$arr}
  <tr>
     <td  width="100%" nowrap="nowrap" style="padding:5px; border-bottom:1px dotted #CCCCCC" valign="top" align="center">
        <div>
        	<a href="skype:{$item.skype}?chat"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/support/skype.png" title="{$value}" border="0"></a>
        </div>
        <div class="title" style="font-size:11px;">{$item.nick}</div>  
     </td>
   </tr>   
{/foreach}
</table>