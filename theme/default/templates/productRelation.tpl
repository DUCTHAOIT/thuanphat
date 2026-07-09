{literal}
{/literal}
<div class="row" style="padding:10px; text-align:center">
    {assign var="k" value="0"}
    {section name=i loop=$arr start=$pageID max=$limit}
        {if $arr[i].id<>$idPro}
            <div class="col-xs-6 col-sm-4 col-md-3" style="padding-bottom:20px;">
                <div class="item-recruit">
                    <div class="avarta">
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr[i].img}"  border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  class="image" width="100%"/></a>
                    </div>
                    <div>
                        <h3 class="content" align="left">
                            <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}">{$arr[i].name}</a>
                        </h3>
                        <p class="font-weight-bold"><span class="font-weight-bold">
                            {if $arr[i].price>0}
                                {format_number number=$arr[i].price}
                            {else}
                                Liên hệ
                            {/if}
                                {if $arr[i].price_old>0}
                                    <font align="center" style="padding:5px;    color:#999999; text-decoration:line-through;" class="content">{format_number number=$arr[i].price_old}</font>
                                {/if}
         </span></p>

                    </div>
                </div>
            </div>
            {assign var="k" value=$k+1}
        {/if}
    {/section}
</div>