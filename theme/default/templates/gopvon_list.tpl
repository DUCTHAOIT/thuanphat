{assign var="k" value="1"}
<div class="container" style="padding:0px">
{section name=i loop=$arr start=$pageID max=$limit}
<div class="col-xs-12 col-sm-6 col-md-6" style="padding-bottom:30px;">
        <div class="img-thumbnail">
       		<div class="containerimage" align="center" style="width:100%; background-image:url('{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=800&image={$smarty.const._DOMAIN_ROOT_URL}/images/gopvon/{$arr[i].img}')">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/null64.png" border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  class="image" /></a>
           <div class="middle">           		
            	<a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><i class="fa fa-eye" style="font-size:25px; color:#FFFFFF"></i></a>
          </div>
        </div>  
        
      </div> 
        <div style="text-align:justify; padding-top:10px">
               <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title"  title="{$arr[i].name}" style="font-size:18px"  >{$arr[i].name}</a>
               <p class="content" style="text-align:justify;">{strstrimtemp str=$arr[i].summary|nl2br}</p>
                
               <p style="padding-top:10px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"  title="{$arr[i].name}" ><button class="btn_viewmore">Chi tiết dự án</button></a></p>    
        </div> 
</div>     
{if $k=='2'}
  <div class="clearfix"></div>
  {assign var="k" value="0"}
{/if}  
{assign var="k" value=$k+1}
{/section}
</div>
<div class="container text-center" style="padding-top:15px">{$sPage}</div>