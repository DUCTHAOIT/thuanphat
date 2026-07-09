<section class="text-center">
    <div class="topic">
        <h2 class="topic">Lĩnh vực đầu tư</h2>
    </div>
     <div>
        {assign var="i" value="0"}
        {foreach key=key item=item from=$arr}
        <div class="col-xs-12 col-sm-12 col-md-4" >
            
                <div align="center"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/function/{$item.img1}" vspace="0" hspace="0" border="0" /></a></div>
                <div  align="center" class="title"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  class="title" style="text-transform:uppercase; font-size:16px">{$item.name}</a></div>  
                <div align="center" ><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" class="content">{strstrimtemp str=$item.des}</a></div>
                
        </div>
        {assign var="i" value="$i+1"}
        {/foreach}
        
    </div>   
</section>