<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
        <td align="left" style="padding-top:10px; border-bottom:1px solid #CCCCCC; color:#666666" class="topic">Các bài viết khác</td>
      </tr>
	  {foreach key=key item=item from=$arr}
      {if $item.parent<>0}     
      <tr>
          <td width="100%" style="padding:5px; padding-top:10px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  id="a{$item.id}" class="contentChitiet">{$item.name}</a></td>  
        </tr>      
      {/if}	 
      {/foreach}
	   <tr><td height="10">&nbsp;</td></tr>	 
    </table>
