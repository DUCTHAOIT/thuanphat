<div class="title"><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
			<TR>
			<TD>
			<IMG SRC="http://www.facom.com.vn/theme_images/box_block_01.gif" WIDTH=6 HEIGHT=2 ALT=""></TD>
			<TD style="background-image:url(http://www.facom.com.vn/theme_images/box_block_02.gif); background-repeat:repeat-x"></TD>
			<TD>
			<IMG SRC="http://www.facom.com.vn/theme_images/box_block_03.gif" WIDTH=26 HEIGHT=2 ALT=""></TD>
			<TD width="100%"></TD>
			</TR>
			<TR>
			<TD>
			<IMG SRC="http://www.facom.com.vn/theme_images/box_block_05.gif" WIDTH=6 HEIGHT=18 ALT=""></TD>
			<TD bgcolor="#004A89" style="padding-left:5px; padding-right:15px; color:#FFFFFF;background-image:url(http://www.facom.com.vn/theme_images/box_block_06.gif); background-repeat: repeat-x" nowrap="nowrap"><strong>{$Products_you_have_viewed}</strong></TD>
			<TD>
			<IMG SRC="http://www.facom.com.vn/theme_images/box_block_07.gif" WIDTH=26 HEIGHT=18 ALT=""></TD>
			<TD style="background-image:url(http://www.facom.com.vn/theme_images/box_block_08.gif); background-repeat:no-repeat"></TD>
			</TR>
			<TR>
			<TD COLSPAN="4" style="background-image:url(http://www.facom.com.vn/theme_images/box_block_09.gif); background-repeat:no-repeat"></TD>
			</TR>
			</TABLE></div>
{assign var="order" value="1"}
{foreach key=key item=item from = $arr_product_review}
	<div style="float:left; width:15px; color:#666666; padding-bottom:5px; padding-left:10px;"><strong>{$order}.</strong></div>
	<div style="padding-bottom:5px;"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}" onmouseout="UnTip()" onmouseover="Tip('<div style=width:400px><div style=float:left; width:100px><div><img src={$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$item.logo} /></div><div style=padding-right:10px><img src={$smarty.const._DOMAIN_ROOT_URL}/img/product/{$item.img} /></div></div></div><div style=padding-top:10px><strong>Model:</strong> {$item.model}</div><div style=color:#FF0000 class=title><strong>{$Price}: {format_number number=$item.price}</strong></div><div class=title><strong>{$Delivery}:</strong> {$item.delivery}</div><div>{$item.summary|nl2br}</div></div></div>',SHADOW, true, BGCOLOR, '#ffffff',TITLE,'<div><img src={$smarty.const._DOMAIN_ROOT_URL}/theme_images/icon_red_right.gif> {$item.name}</div>')">{$item.name}</a></div>
	{assign var="order" value="$order+1"}
{/foreach}