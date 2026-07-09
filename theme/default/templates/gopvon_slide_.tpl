<!--Carousel Wrapper-->
<div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
  <!--Slides-->
  <div class="carousel-inner" role="listbox">
 
  {if $arrColor}
        {assign var="i" value="0"}
        {foreach item=item key=key from=$arrColor}
    <div {if $i=='0'}class="carousel-item active" {else}class="carousel-item"{/if}>
      <img class="d-block w-100" src="{$smarty.const._DOMAIN_ROOT_URL}/images/gopvon/{$item.img}" style="max-height:500px;">
    </div>
    {assign var="i" value=$i+1}
     {/foreach}
    {/if}
  </div>
  <!--/.Slides-->
  <!--Controls-->
  <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <!--/.Controls-->
  <ol class="carousel-indicators" style="margin-bottom:30px">
 
     {if $arrColor}
        {assign var="i" value="0"}
        {foreach item=item key=key from=$arrColor}
        <li data-target="#carousel-thumb" data-slide-to="{$i}" {if $i=='0'} class="active"{/if} style="width:104px; height:61px; margin:2px; text-align:center"> <img class="d-block" src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=200&image={$smarty.const._DOMAIN_ROOT_URL}/images/gopvon/{$item.img}"  style="width:100px; max-height:60px; border-radius:10%; " vspace="1" hspace="1"></li>
        
  
    {assign var="i" value=$i+1}
     {/foreach}
    {/if}
   
  </ol>
</div>
<!--/.Carousel Wrapper-->