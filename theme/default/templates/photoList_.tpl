{literal}
<script type="text/javascript" src="../../js/highslide/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="../../js/highslide/highslide.css" />

<!--
	2) Optionally override the settings defined at the top
	of the highslide.js file. The parameter hs.graphicsDir is important!
-->

<script type="text/javascript">
hs.graphicsDir = '../../js/highslide/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.numberPosition = 'caption';
hs.dimmingOpacity = 0.75;

// Add the controlbar
if (hs.addSlideshow) hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});
</script>
{/literal}

 <div class="contentFun">{$nameFun}</div>	

 <div class="topicContent"><h1>{$name}</h1></div>
  <div class="content" style="text-align:justify; padding:10px">{$des}</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 {assign var="k" value="0"}
 {assign var="j" value="0"}
   <tr>
   {foreach item=item key=key from=$arrphoto}	
  
    {if $j==3}
        {assign var="j" value="0"}
        </tr><tr>		
    {/if}
    <td width="33%" class="content" style="padding:10px;" valign="top">					
        <table border="0"  align="center" cellpadding="0" cellspacing="0">
         <tr>
            <td align="center" valign="top">           
            	<div style="border:1px solid #CCCCCC; padding:2px; background-color:#FFFFFF; width:212px" align="center">
            	<a href="{$smarty.const._DOMAIN_ROOT_URL}/modules/photo/newgallery/thumbs/{$item.img}" class="highslide" onclick="return hs.expand(this)" title="{$item.name}" name="{$item.name}" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=205&image={$smarty.const._DOMAIN_ROOT_URL}/modules/photo/newgallery/thumbs/{$item.img}" border="0"  width="205" height="136"  vspace="2"  hspace="2" title="{$item.name}" alt="{$item.name}"  />
				</a>
             	</div>		
              		
             </td>
          </tr>
          <tr>
          	<td align="center" valign="top" style="padding-top:5px">  <div align="center" class="title" style="font-size:13px">{$item.name}</div>	</td>
          </tr>
      </table>					
    </td>			 			  
    {assign var="j" value="$j+1"}
  
  {/foreach}
  </tr>
</table>