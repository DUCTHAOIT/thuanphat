<div class="contentFun">{$nameFun}</div>		
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 {assign var="k" value="0"}
 {assign var="j" value="0"}
   <tr>
   {section name=i loop=$arr start=$pageID max=$limit}
    {if $j==2}
        {assign var="j" value="0"}
        </tr><tr>		
    {/if}
    <td width="50%" style="padding-top:15px; padding-bottom:20px; border-bottom:1px solid #CCCCCC"  valign="top">					
        <table border="0"  align="center" cellpadding="0" cellspacing="0">
         <tr>
            <td valign="top">
            	<div align="center">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$url}&id={$arr[i].id}" class="title"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=490&image={$smarty.const._DOMAIN_ROOT_URL}/images/photo/thumbs/{$arr[i].img1}" border="0"  width="490" height="325" vspace="0" hspace="0"  />
				</a>
             	</div>					
             </td>
		</tr>
		<tr>	 
			 <td width="100%"  align="left" valign="top" style="padding-top:5px;">
			 	 <h2><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$url}&id={$arr[i].id}" class="title" style="font-size:13px">{$arr[i].name}</a></h2>		 	
			 </td>
          </tr>
      </table>					
    </td>			 			  
    {assign var="j" value="$j+1"}
  {/section}
  </tr>
</table>
<div style="text-align:right; padding:15px; border-top:1px solid #CCCCCC">{$sPage}</div>
