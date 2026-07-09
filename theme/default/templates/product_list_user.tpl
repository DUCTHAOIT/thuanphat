{literal}
<style type="text/css">
	.button3 {
	background-color: #f37022; 
	color: #006633; 
	border: 1px solid #666666;
	border-radius: 4px;
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding-left:10px;
	padding-right:10px;
}

.button3:hover {
	background-color: #FFFFFF;
	color: #006633;
	border-radius: 4px;
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding-left:10px;
	padding-right:10px;
}
</style>
{/literal}
{if $des}
<div class="content"><h3>{$des}</h3></div>
{/if}

{assign var="k" value="0"}
{section name=i loop=$arr start=$pageID max=$limit}	
  
    <div style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon-pdf.png); background-repeat:no-repeat; background-position:left; padding-left:40px">
    	  <h3><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$arr[i].pdf}" class="title"  title="{$title}" >{$arr[i].name}</a></h3>
           <div><button class="button3"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="content" >{if $lang=='vn'}Tải về{else}Download{/if}</a></button></div>  
    </div>       
  
    <div style="height:10px; border-top:1px solid #CCCCCC; margin-top:10px"></div>    
	{assign var="k" value="$k+1"}		
{/section}