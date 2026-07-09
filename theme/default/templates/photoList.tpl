{literal}
 <link rel="stylesheet" href="../../js/static/js/prettyPhoto_compressed_3.1.5/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="../../js/static/js/prettyPhoto_compressed_3.1.5/js/jquery-1.6.1.min.js" type="text/javascript" ></script>
<script src="../../js/static/js/prettyPhoto_compressed_3.1.5/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

{/literal}

 <div class="contentFun">{$nameFun}</div>	

 <div class="topicContent"><h1>{$name}</h1></div>
  <div class="content" style="text-align:justify; padding:10px">{$des}</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 {assign var="k" value="0"}
 {assign var="j" value="0"}
   <tr>

   {section name=i loop=$arr start=$pageID max=$limit}
    {if $j==4}
        {assign var="j" value="0"}
        </tr><tr>		
    {/if}
    <td width="25%" class="content" style="padding:10px;" valign="top">	
    <div class="gallery">			
        <table border="0"  align="center" cellpadding="0" cellspacing="0">
         <tr>
            <td align="center" valign="top">           
            	<div style="border:1px solid #CCCCCC; padding:2px; background-color:#FFFFFF; width:212px; background-image:url(); background-repeat:no-repeat" align="center">
            	<a href="{$smarty.const._DOMAIN_ROOT_URL}/images/photo/{$arr[i].img}" rel="prettyPhoto[gallery2]" title="{$arr[i].name}"  >
                
                 {if $arr[i].img1}<img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=205&image={$smarty.const._DOMAIN_ROOT_URL}/images/photo/thumbs/{$arr[i].img1}" border="0"  width="205" height="136" vspace="2"  hspace="2"/>
                 {else}
                 <img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=205&image={$smarty.const._DOMAIN_ROOT_URL}/images/photo/{$arr[i].img}" border="0"  width="205" height="136"  vspace="2"  hspace="2"/>
                 {/if}
				</a>
             	</div>		
              		
             </td>
          </tr>
          <tr>
          	<td align="center" valign="top" style="padding-top:5px; font-size:13px" class="title">{$arr[i].name}</td>
          </tr>
      </table>	
    </div>  				
    </td>			 			  
    {assign var="j" value="$j+1"}
  {/section}
  </tr>
</table>
<div style="text-align:right; padding:15px; border-top:1px solid #CCCCCC">{$sPage}</div>
{literal}
 <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $("area[rel^='prettyPhoto']").prettyPhoto();
            $(".gallery a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:3000, autoplay_slideshow: false});
        });
    </script>
{/literal}