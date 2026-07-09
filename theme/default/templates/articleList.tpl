{assign var="k" value="0"}
{assign var="i" value="0"}
{assign var="j" value="0"}
<div class="container">
{section name=i loop=$arr start=$pageID max=$limit}
{if $k==1}
    {assign var="k" value="0"}

 {/if}	

     <div class="row article">
        <div class="col-xs-12 col-sm-4 col-md-4">
                {if $arr[i].img}
                    <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=600&image={$smarty.const._DOMAIN_ROOT_URL}/images/article/{$arr[i].img}" class="img-fluid"  alt="{$arr[i].name}" title="{$title}" border="0" vspace="0"  hspace="0" width="100%" /></a>	
                {/if}               
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8">
               <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}" class="title"  title="{$arr[i].name}" style="font-size:18px"  >{$arr[i].name}</a>
               <div class="news-day">{$arr[i].date_create}</div>
               <font class="content" style="text-align:justify;">{$arr[i].summary|nl2br}</font>     
        </div>       
      </div>   
      <div style="height:10px; border-top:1px dotted #3ca995; margin-top:10px"></div> 
    
{assign var="i" value="$i+1"}
{assign var="k" value="$k+1"}
{/section}
</div>
<div class="container text-center"" style="padding-top:15px">{$sPage}</div>