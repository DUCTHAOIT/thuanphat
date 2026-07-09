{literal}
	<script type="text/javascript" src="../../jsfile/flexcroll.js"></script>
	<script type="text/javascript" src="../../jsfile/jquery.js"></script>
	<script type="text/javascript" src="../../jsfile/jquery.galleria.pack.js"></script>
	<script type="text/javascript">	
	jQuery(function($) {		
		$('.gallery_demo_unstyled').addClass('gallery_demo'); // adds new class name to maintain degradability
		$('ul.gallery_demo').galleria({
			history   : true, // activates the history object for bookmarking, back-button etc.
			clickNext : true, // helper for making the image clickable
			insert    : '#main_image', // the containing selector for our main image
			onImage   : function(image,caption,thumb) { // let's add some image effects for demonstration purposes
				// fade in the image & caption
				if(! ($.browser.mozilla && navigator.appVersion.indexOf("Win")!=-1) ) { // FF/Win fades large images terribly slow
					image.css('display','none').fadeIn(1000);
				}
				caption.css('display','none').fadeIn(1000);
				
				// fetch the thumbnail container
				var _li = thumb.parents('li');
				
				// fade out inactive thumbnail
				_li.siblings().children('img.selected').fadeTo(500,0.3);
				
				// fade in active thumbnail
				thumb.fadeTo('fast',1).addClass('selected');
				
				// add a title for the clickable image
				image.attr('title','Next image >>');
			},
			onThumb : function(thumb) { // thumbnail effects goes here
				// fetch the thumbnail container
				var _li = thumb.parents('li');
				
				// if thumbnail is active, fade all the way.
				var _fadeTo = _li.is('.active') ? '1' : '0.3';
				
				// fade in the thumbnail when finnished loading
				thumb.css({display:'none',opacity:_fadeTo}).fadeIn(1500);
				
				// hover effects
				thumb.hover(
					function() { thumb.fadeTo('fast',1); },
					function() { _li.not('.active').children('img').fadeTo('fast',0.3); } // don't fade out if the parent is active
				)
			}
		});
	});	
	</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="center" style="padding-top:10px" colspan="3"><div class="title">{$arr.name}</div></td>
	</tr>
	<tr>
		<td align="center" colspan="3" style="padding-bottom:10px; padding-top:20px"><div id="main_image" align="center"></div></td>
	</tr>
	<tr>
		  <td width="50%" nowrap="nowrap" align="right" valign="top"><a class="linknext" href="#" onclick="$.galleria.prev(); return false;">&laquo; BACK</a></td>
		  <td valign="top" align="center">                    
                    <div>
                    <ul class="gallery_demo_unstyled">
                        <li class="active"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/albums/{$arr.img1}" alt="" title="" /></li>
					   {foreach item=item key=key from=$arrColor}
						<li><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/albums/{$item.img}" alt="" title="" /></li>				
					   {/foreach} 
                    </ul>
                    </div>                  
            </td>
			<td width="50%" nowrap="nowrap" align="left" valign="top"><a class="linknext" href="#" onclick="$.galleria.next(); return false;">NEXT &raquo;</a></td>
	</tr> 
	<tr>
		<td align="center" style="padding-top:10px" colspan="3">&nbsp;</td>
	</tr>  
</table>