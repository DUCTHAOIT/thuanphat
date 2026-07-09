<div><h2 class="title"><a href="{$smarty.const._DOMAIN_ROOT_URL}/vn/video/" style="font-size:16px; text-transform:uppercase">VIDEO</a></h2></div>
{assign var="i" value="0"}
{foreach item=item key=key from=$arr}					
 {if $i=='0'}
    
    <div class="video__hig">
        {if $item.youtube}					
        <iframe  width="100%" height="260px" src="http://www.youtube.com/embed/{$item.youtube}?modestbranding=1&autoplay=0" frameborder="0" allowfullscreen></iframe>
        
        {else}
            <video controls>
                <source src="{$smarty.const._DOMAIN_ROOT_URL}/img/video/{$item.img1}" type="video/mp4">
            </video>
         {/if}   
    </div>					
 
{else}
     {if $i=='1'}<div class="video__list">{/if}
        <article class="post post--video flex">
            <a href="{$smarty.const._DOMAIN_ROOT_URL}/video/" class="post__thumb"><img src="http://img.youtube.com/vi/{$item.youtube}/default.jpg" alt=""></a>
            <div class="post__content">
                <p>{$item.name}</p>
            </div>
        </article>
     {if $i=='3'}</div>{/if}
{/if}

{assign var="i" value=$i+1}				
{/foreach}	