{literal}
<style type="text/css">
	.button3 {
	background-color: #f37022; 
	color: #006633; 
	border: 1px solid #666666;
	border-radius: 4px;
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding-left:10px;
	padding-right:10px;
}

.button3:hover {
	background-color: #FFFFFF;
	color: #006633;
	border-radius: 4px;
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding-left:10px;
	padding-right:10px;
}
</style>
{/literal}
<div class="container" style="padding:10px">
	<div class="namefun text-center">Tìm kiếm</div>
	<div class="text-center">
        <h1 class="topiccontent">Kết quả tìm kiếm</h1>
    </div>
    <div class="content" >
    	{assign var="k" value="1"}
{section name=i loop=$arr start=$pageID max=$limit}	
  <div style="position:relative; padding-bottom:50px" class="row notemb"  >
  	{if $k%2} 
   	  <div class="listsanphamphai" >
        <div class="containerimage listsanphamphaiimg img-thumbnail" align="center" style="background-image:url('{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=1200&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr[i].img}')">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/null64.png" border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  class="image" /></a>
           <div class="middle">           		
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><i class="fa fa-eye" style="font-size:25px; color:#FFFFFF"></i></a>
          </div>
       </div> 
     </div>
     <div class="tomtatsanphamphai" style="padding:10px; text-align:justify">
            <p align="center" style="padding-bottom:0px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title" style="text-transform:uppercase; color:#FFFFFF; font-size:20px">{$arr[i].name}</a></p>
            <p><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" style="font-size:18px; color:#FFFFFF">{$arr[i].summary}</a></p>
            <p><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="btn_chitiet flex-center js-animation fadeup fadeInUp" tabindex="0" >Chi tiết dự án</a></p>
     </div>
     {else}
     <div class="listsanphamtrai" >
        <div class="containerimage listsanphamtraiimg img-thumbnail" style="background-image:url('{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=1200&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr[i].img}')">
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/null64.png" border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  class="image" /></a>
           <div class="middle">           		
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><i class="fa fa-eye" style="font-size:25px; color:#FFFFFF"></i></a>
          </div>
       </div> 
     </div>
     <div class="tomtatsanphamtrai" style="padding:10px; text-align:justify">
            <p align="center" style="padding-bottom:0px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title" style="text-transform:uppercase; color:#FFFFFF; font-size:20px">{$arr[i].name}</a></p>
            <p><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" style="font-size:18px; color:#FFFFFF">{$arr[i].summary}</a></p>
            <p><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="btn_chitiet flex-center js-animation fadeup fadeInUp" tabindex="0" >Chi tiết dự án</a></p>
     </div>
     {/if} 
 </div>
 

       <div style="position:relative; margin-bottom:50px" class="notepc">
       <div class="img-thumbnail" style="margin-bottom:80px;">
                                     
            <div class="containerimage" align="center" style="width:100%; background-image:url('{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=1200&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr[i].img}')">
                    <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/null.gif" border="0" alt="{$arr[i].name}" title="Chi tiết" hspace="0" vspace="0"  class="image" /></a>
               <div class="middle">           		
                    <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}"><i class="fa fa-eye" style="font-size:25px; color:#FFFFFF"></i></a>
              </div>
           
            
           </div> 
           <div class="tomtatsp" style="text-align:justify">
                <p align="center" style="padding-bottom:0px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="title" style="text-transform:uppercase; color:#FFFFFF">{$arr[i].name}</a></p>
                <p><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" style="color:#FFFFFF">{$arr[i].summary}</a></p>
                <p align="center"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arr[i].url}{$arr[i].alias}" class="btn_chitiet flex-center js-animation fadeup fadeInUp" tabindex="0" >Chi tiết dự án</a></p>
            </div> 
         </div>
         </div>
   
	{assign var="k" value=$k+1}		
{/section}
<div style="text-align:right; padding:10px;">{$sPage}</div>
    </div>
</div>


