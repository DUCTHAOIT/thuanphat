<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>			
		<td nowrap="nowrap" align="left" valign="bottom" style="padding:5px; padding-bottom:0px; color:#0064ac;" class="title" >Sản phẩm liên quan</td>
		<td align="left" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/title_bg.gif); background-repeat:repeat-x; background-position:bottom" valign="bottom"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/title_icon.gif" /></td>
		<td width="100%" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/title_bg.gif); background-repeat:repeat-x; background-position:bottom">&nbsp;</td>
	</tr>
	<td colspan="3" width="100%" style="padding-top:5px; padding-left:5px; padding-bottom:5px; border:1px solid #999999" align="left" valign="bottom" >
	<marquee behavior="Scroll" direction="left" scrolldelay="20" scrollamount="2" onmouseout="this.start()" onmouseover="this.stop()">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr><td valign="top" style="padding-left:5px; padding-right:5px">
				{foreach key=key item=item from=$arrRelation}
					{if $item.alias<>$idProduct}
						<div align="center">
						<a href="{$item.url}f=detail&{$smarty.const._ID_PRODUCT}={$key}">
							<img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$item.img}" border="0"/>							
						</a>
						</div>
						<div class="content" align="center" style="padding-left:5px; padding-right:5px">
						<a href="{$item.url}f=detail&{$smarty.const._ID_PRODUCT}={$key}" class="content">
							{$item.name}					
						</a>
						</div>
					</td><td valign="top" style="padding-left:5px; padding-right:5px">
					{/if}
				{/foreach}			
		</td></tr>
		</table>
		</marquee>
	</td>
	</td>  
</table>
