{literal}{/literal}

{assign var="k" value="0"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td  style="padding-left:2px; padding-right:2px;"><div class="title" style="background-color:#f1592a; font-size:16px; color:#FFFFFF; padding:7px;">{if $lang=='vn'}Sản phẩm cùng loại{else}Products Relation{/if}</div></td>
  </tr>
  <tr>    
{section name=i loop=$arr start=$pageID max=$limit}
 	{if $k==1}
		{assign var="k" value="0"}
		</tr><tr>		
	{/if}
	<td valign="top" align="left">
    <div class="ProductList">
        {if $arr[i].img}
            <div style="border-bottom:1px solid #ebebeb">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=226&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr[i].img}" border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  width="226" height="176px"  /></a>
             </div> 							
        {/if}        
        <div class="title" style="padding:5px; padding-top:10px;"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title" style="text-transform:uppercase">{$arr[i].name}</a></div>
        <div class="content" style="text-align:justify; padding:5px;">{strstrimtemp str=$arr[i].summary}</div>
        <div style="padding:5px;">
        	<div style="float:left; color:#990000; font-size:14px" class="title">{format_number number=$arr[i].price}/{$arr[i].delivery}</div>      
            <div style="float:right; width:30px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" title="Chi tiết"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/detail.png" vspace="0" hspace="0" border="0" alt="Chi tiết"/></a></div>
     </div>    
	</td>
	{assign var="k" value="$k+1"}		
{/section}
  </tr>
  <tr>
  	<td  style="padding:2px;"><div style="background-color:#8d8d8d"><a href="{$url}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/xemthemsp.jpg" border="0" /></a></td>
  </tr>
  
</table>
<!--
<div style="text-align:right; padding:10px;">{$sPage}</div>
-->