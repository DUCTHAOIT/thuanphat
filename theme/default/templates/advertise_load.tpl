<marquee behavior="Scroll" direction="left" scrolldelay="10" scrollamount="2" onmouseout="this.start()" onmouseover="this.stop()">
<div style="width:925px; overflow:hidden">
<table border="0" cellspacing="0" cellpadding="0" width="925px">
<tr><td valign="top" style="padding-left:5px; padding-right:5px">
		{foreach item=item key=key from=$arr}
				<a href="{$item.website}" target="_blank" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/advertise/{$item.img}" border="0" vspace="0"  hspace="0" /></a>
		</td><td valign="top" style="padding-left:5px; padding-right:5px">
		{/foreach}			
</td></tr>
</table>
</div>
</marquee>