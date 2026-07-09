{assign var="k" value="1"}
<div class="container" style="padding:0px">
{section name=i loop=$arr start=$pageID max=$limit}
<div class="col-xs-12 col-sm-4 col-md-3" style="padding:30px">
		<div class="item-recruit-tron">
            <div class="avarta-tron">
                    {if $arr[i].img}
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=800&image={$smarty.const._DOMAIN_ROOT_URL}/images/partner/{$arr[i].img}" class="img-fluid"  alt="{$arr[i].name}" title="{$title}" border="0" vspace="0"  hspace="0" width="100%" /></a>	
                    {/if}               
            </div>
        </div>    
        <div style="text-align:center; padding-top:10px">
               <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].htaccess}{$arr[i].alias}" class="title"  title="{$arr[i].name}" style="font-size:18px"  >{$arr[i].name}</a><br />
               <font class="content" style="text-align:center;">{$arr[i].summary|nl2br}</font>     
        </div> 
</div>     
{if $k=='4'}
  <div class="clearfix"></div>
  {assign var="k" value="0"}
{/if}  
{assign var="k" value=$k+1}
{/section}
</div>
<div class="container text-center" style="padding-top:15px">{$sPage}</div>