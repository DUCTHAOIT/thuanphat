<section class="text-center">
    <div class="topic">
        <h2 class="topic">CLB Đầu tư chung</h2>
    </div>
     <div>
        {assign var="i" value="0"}
        {foreach key=key item=item from=$arr}
        <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom:20px;" >
                <div class="boxnoidung" {if $i==0 } style="background-color:#3ca995; color:#FFFFFF" {/if} {if $i==1 } style="background-color:#2f53bd; color:#FFFFFF" {/if}><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}" class="content" {if $i==0 } style="color:#FFFFFF" {/if} {if $i==1 } style="color:#FFFFFF" {/if}>{$item.des}</a></div>
        </div>
        {assign var="i" value=$i+1}
        {/foreach}
        
    </div>   
</section>