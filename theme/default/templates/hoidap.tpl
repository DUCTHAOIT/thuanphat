<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="34">
    <td  nowrap="nowrap" align="left" class="titleBlock">Hỏi đáp</td>          
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  {assign var="i" value="0"}
	{foreach item=item key=key from=$arr}	
	<tr>
        <td style="padding-bottom:10px; padding-top:10px; border-bottom:1px dotted #CCCCCC; text-align:justify; line-height:20px; background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/faqhome.png); background-repeat:no-repeat; background-position:left top" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" class="content" >{$item.name}</a></td>
     </tr>
	{assign var="i" value="$i+1"}
	{/foreach}
  
</table>