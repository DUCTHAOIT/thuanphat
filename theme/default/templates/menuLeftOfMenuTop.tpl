<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr >			  				
       <td width="100%"  class="menuleftoff tieude_tintuc">{$namesub}</td>
    </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0"> 	
   {foreach key=key item=item from=$arr}
      {if $count>1}
      {if $item.level=='0'}
              <tr  height="30px" >
                <td  style="font-size:12px; font-weight:bold;" class="menuleftoffsub" ><a  href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" class="content" style="font-size:12px;"  id="a{$item.id}" >{$item.name}</a></td>
               	
                </td>
              </tr>	
             {if $fidsub==$item.id}
              <tr>							
                <td width="100%" style="padding-left:10px;" nowrap="nowrap">{menuLeftOfMenuTopSub}</td>							
              </tr>	
              {/if}	
            
      {/if}	
  {/if}
  {/foreach}
</table>
    </td>
  </tr>
</table>


