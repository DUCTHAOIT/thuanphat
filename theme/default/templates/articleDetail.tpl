<div class="container">
	<div class="namefun text-center">{$nameFun}</div>
	<div class="text-center">
        <h1 class="topiccontent">{$arr.name}</h1>
    </div>
    {if $arr.summary}<div class="title">{$arr.summary}</div>{/if}
    <div class="content">{$arr.content}</div> 
    <div class="clr"></div>
     <div class="topiccontent"><h1>{if $lang=='vn'}Tin liên quan{else}Related news{/if}</h1></div>
    <div>
    {foreach key=key item=item from=$arrrelation}
    {if $item.id<>$arr.id}  
   		<div class="row" style="border-bottom:1px dotted #CCCCCC;padding:0px; padding-top:10px; padding-bottom:10px;">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}{$item.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=400&image={$smarty.const._DOMAIN_ROOT_URL}/images/article/{$item.img}" alt="{$item.name}" title="{$item.name}" border="0" vspace="0"  hspace="0" width="100%"/></a>	
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9" >
                <h3><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}{$item.alias}" class="title"  title="{$title}" >{$item.name}</a></h3>
                <div class="news-day">{$item.date_create}</div>
                <font class="content" style="text-align:justify; font-size:16px">{$item.summary|nl2br}</font>   
            </div>
        </div>           
    {/if}	    
    {/foreach}
    </div>
</div>