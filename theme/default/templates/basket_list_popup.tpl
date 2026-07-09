{literal}
{/literal}
<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="background-color:#CCCCCC">
          	<td width="50px">&nbsp;</td>
            <td width="250px">&nbsp;</td>
            <td class="title" align="right"  nowrap="nowrap" style="padding-right:15px">Giá</td>
            <td  class="title" align="right" nowrap="nowrap" >Số lượng</td>
            <td  class="title" align="right" nowrap="nowrap" >Tổng cộng</td>
          </tr>
    </table>

</div>
<div class="scrollable" style="font-size:12px;">
<table width="100%" border="0" cellspacing="2" cellpadding="2">		
          {assign var="total" value=0}
		  {foreach key=key item=item from=$arrProductBasket}
		   <tr>
           	<td style="padding:5px; border-bottom:1px solid #CCCCCC"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/product/{$item.img}" border="0"  width="50"/></a></td>
			<td style="padding:5px; border-bottom:1px solid #CCCCCC" valign="top" >
			<div class="title"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}" class="title">{$item.name}</a></div>
          
            </td>
            <td style="padding:5px; border-bottom:1px solid #CCCCCC" nowrap="nowrap" align="right" width="100px">{format_number number=$item.price}</td>
            <td style="padding:5px; border-bottom:1px solid #CCCCCC" nowrap="nowrap" align="right" width="60px">{$item.quantity}</td>			
            <td style="padding:5px; border-bottom:1px solid #CCCCCC" nowrap="nowrap" align="right" width="100px">{format_number number=$item.thanhtien}</td>
			
		  </tr>
		  {assign var="total" value=$total+$item.thanhtien}
		  {/foreach}
		
 		</table> 
</div> 
<div style="float:right; font-size:16px; padding:10px; border-bottom:2px solid #CCCCCC" class="title" ><strong>{$Total}: </strong>{format_number number=$total}</div>
<div style="padding:10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" align="left" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/order2.png); background-repeat:no-repeat; background-position:left; padding:20px; text-align:left" > <a  class="close title" data-dismiss="modal" aria-label="Close"  style="color:#ff5c91; font-size:16px; cursor:pointer">Tiếp tục mua hàng</a></td>
        
        <td width="50%" align="right" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/order.png); background-repeat:no-repeat; background-position:right; padding:20px; padding-right:30px;"> <a class="title" style="color:#ff5c91" href="{$smarty.const._DOMAIN_ROOT_URL}/view_basket/">Thanh toán</a></td>
      </tr>
    </table>
</div>