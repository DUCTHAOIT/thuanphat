<div class="row">
 {section name=i loop=$arr start=$pageID max=$limit}
{if $k==1}
    {assign var="k" value="0"}

 {/if}

    <div class="col-xs-12 col-sm-4 col-md-4" style="padding-bottom:20px;">
        <div class="item-recruit-khoahoc">
        <div class="avarta">
            {if $arr[i].img}
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}">
                    <img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=1000&image=images/worldwide/{$arr[i].img}" class="img-fluid w-100" alt="{$arr[i].name}" title="{$arr[i].name}">
                </a>
            {/if}
        </div>


            <div class="info" style="padding-top: 10px; padding-bottom: 10px">
                <h3 style="margin-bottom:0px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title"  title="{$arr[i].name}" style="font-size:18px; font-weight:600" >{$arr[i].name}</a></h3>
                <div class="news-day">{$arr[i].address}</div>
                <div class="desc" style="text-align:justify">{$arr[i].des}</div>
            </div>
        </div>
              
     </div> 

{assign var="i" value="$i+1"}
{assign var="k" value="$k+1"}
{/section}
 </div>
<div style="text-align:right; padding:10px;">{$sPage}</div>