<div class="container">
    <div class="namefun text-center">{$nameFun}</div>
    <div class="text-center">
        <h1 class="topiccontent">{$name}</h1>
    </div>
    {if $des}<div class="content" >{$des}</div>{/if}
    <div class="row" >
        <div class="col-xs-12 col-sm-4 col-md-4" style="padding-bottom:20px;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/worldwide/{$arr.img}"  border="0" vspace="0"  alt="{$arr.name}" class="img-thumbnail" /></div>
        <div class="col-xs-12 col-sm-8 col-md-8" style="padding-bottom:20px;">
            <p class="title">{$arr.name}</p>
            <p><i>{$arr.address}</i></p>
            <p>{$arr.des}</p>
        </div>

    </div>
</div>