{literal}
<link rel="stylesheet" type="text/css" href="js/gallerystyle.css" />
      
<!-- Do not edit IE conditional style below -->
<!--[if gte IE 5.5]>
<style type="text/css">
#motioncontainer {
width:expression(Math.min(this.offsetWidth, maxwidth)+'px');
}
</style>
<![endif]-->
<!-- End Conditional Style -->

<script type="text/javascript" src="js/motiongallery.js">

/***********************************************
* CMotion Image Gallery- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
* Modified by Jscheuer1 for autowidth and optional starting positions
***********************************************/

</script>
{/literal}
<body>
<div id="motioncontainer" style="position:relative;overflow:hidden;">
<div id="motiongallery" style="position:absolute;left:0;top:0;white-space: nowrap;">

<nobr id="trueContainer"><a href="javascript:enlargeimage('dynamicbook1.gif')"><img src="dynamicbook1.gif" border=1></a> <a href="javascript:enlargeimage('dynamicbook1.gif', 300, 300)"><img src="dynamicbook1.gif" border=1></a> <a href="http://www.dynamicdrive.com"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a> <a href="#"><img src="dynamicbook1.gif" border=1></a></nobr>

</div>
</div>
</body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	{assign var="i" value="0"}
  	{foreach key=key item=item from = $arr}
	{if $i==2}
		</tr><tr>
		{assign var="i" value="0"}
	{/if}
    <td align="center" style="padding:5px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/san_pham_hang_{$key}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/logo/{$item.logo}" border="0" title="{$item.name}" /></a></td>
	{assign var="i" value="$i+1"}
	{/foreach}
  </tr>

</table>
