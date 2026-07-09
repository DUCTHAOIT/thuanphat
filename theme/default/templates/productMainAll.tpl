<script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/tooltip.js"></script> 
{literal}{/literal}
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
		<td align="left" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/1.gif" /></td>       
		<td width="100%"  style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/2.gif); background-repeat:repeat-x;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/2.gif" /></td>
		<td align="right" valign="top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/3.gif" /></td>
</tr>  
<tr>
	<td valign="top" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4.gif); background-repeat:no-repeat; background-position:top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4.gif" /></td>
	<td valign="top" width="100%" style="padding:10px; background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4.gif); background-repeat:repeat-x; background-position:top">
		<div class="contentFun">{$nameFun}</div>		
		<div style="padding-top:20px">{product_list_all}</div>
	</td>
	 <td  style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/box/4.gif); background-repeat:no-repeat; background-position:top"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" width="3" height="1" /></td>		       
</tr>
</table>
{literal}
	<script language="javascript" type="text/javascript">
		//
		function addToShoppingCart(id)
		{
			url="/add_basket/"+ id +"/";
			AjaxRequest.get(
				{
				'url':url
				,'onSuccess':function(req){document.getElementById('addToShoppingCart_'+id).innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
			//
			url="/view_basket_count/";
			AjaxRequest.get(
				{
				'url':url
				,'onSuccess':function(req){document.getElementById('div_view_summary_basket').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		}
	</script>
{/literal}