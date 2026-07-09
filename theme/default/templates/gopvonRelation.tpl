{literal}{/literal}
{assign var="k" value="0"}
<div class="col-xs-12 col-sm-12 col-md-12 title" style="background-color:#e7e7e7; font-size:16px; color:#2f2f2f; padding:10px; text-transform:uppercase">{if $lang=='vn'}Báo cáo khác{else}Relation{/if}</div>
{section name=i loop=$arr start=$pageID max=$limit}	
<div class="col-xs-12 col-sm-12 col-md-12"  style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon-pdf.png); background-repeat:no-repeat; background-position:left; padding-left:40px">
      <h3><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$arr[i].pdf}" class="title"  title="{$title}" >{$arr[i].name}</a></h3>
       <div><button class="button3"><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$arr[i].pdf}" class="content" >{if $lang=='vn'}Tải về{else}Download{/if}</a></button></div>  
       <div style="height:10px; border-top:1px solid #CCCCCC; margin-top:10px"></div>   
</div>         
        
	{assign var="k" value="$k+1"}		
{/section}
