<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
	<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/Left.gif" /></td>       
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>			
			<td class="titleblock" width="100%" align="left" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb.gif); background-repeat:repeat-x;">{$News}</td>
		  </tr>
		</table>
	</td>	
	<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb2.gif" /></td>
  </tr>
  <tr>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgLeft.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgLeft.gif" /></td>		
	<td style="padding:5px" width="100%" valign="top">		
		<table width="100%" border="0" cellspacing="0" cellpadding="0"> 	
			{assign var="i" value="0"}
			{foreach key=key item=item from=$arr}  			
				 <tr>
  				  <td width="100%" class="content" style="text-align:justify; padding-top:5px">
					{if $item.img}
						<table border="0" style="border:0px solid #993300"  align="left" cellpadding="0" cellspacing="0">
			 			 <tr>
							<td style="padding-right:10" align="center">					
							<a href="{$url}op=detail&{$smarty.const._ID_ARTICLE}={$arr.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/article/{$item.img}" border="0"  width="120" vspace="2" hspace="2" /></a>			</td>
						  </tr>
			  			</table>
					{/if}
					 <font class="title"><a href="{$url}op=detail&{$smarty.const._ID_ARTICLE}={$item.alias}" class="title">{$item.name}</a></font><br />
					<font class="content" style="text-align:justify">{$item.summary|nl2br}</font><br />
					<div><a href="{$url}op=detail&{$smarty.const._ID_ARTICLE}={$item.alias}" style="color:#FF0000" class="content">{$Detail} >></a></div>			
					</td>
				  </tr>  
				  <tr>
					<td width="100%" style="border-bottom:1px dotted #333333" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" width="1" height="5"  /></td>
				  </tr>	
			{/foreach}	
	</table>	
	</td>
	<td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgRight.gif);; background-repeat:repeat-y"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgRight.gif" /></td>
  </tr>			 			 
  <tr>
	<td valign="top" align="left"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/LeftB.gif" /></td>
	 <td style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgB.gif);; background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/BgB.gif" /></td>
    <td valign="top" align="right"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/RightB.gif" /></td>
  </tr>
</table>	