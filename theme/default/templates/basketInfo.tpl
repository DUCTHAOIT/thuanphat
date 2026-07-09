<table cellspacing="1" bordercolor="#c0c0c0" border="1" width="100%"  class="table">	
  <tr class="tr">
    <td class="title td" nowrap="nowrap" >Tên sản phẩm</td>   
    <td class="title td" align="right">Đơn giá</td>
    <td class="title td" align="right">Số lượng</td>
    <td class="title td" align="right">Thành tiền</td>
  </tr>
  {assign var="total" value=0}
  {assign var="totalquantity" value=0}
  {foreach key=key item=item from=$arrProductBasket}
   <tr>
    <td class="td" >
    <div class="title">{$item.name}</div>
     <div class="content">MSP: {$item.model}</div>
    </td>
    <td class="td" nowrap="nowrap" align="right">{format_number number=$item.price}</td>
    <td align="center" class="td" width="60px">
    
    <div style="float:left; width:60px">{$item.quantity}</div>
    </td>
    <td class="td" nowrap="nowrap" align="right">{format_number number=$item.price*$item.quantity}</td>			
  </tr>
  {assign var="total" value=$total+$item.price*$item.quantity}
  {assign var="totalquantity" value=$totalquantity+$item.quantity}
  {/foreach}
   <tr>
    <td style="padding-right:10px" nowrap="nowrap" colspan="7" align="right">
    <div class="title" style="font-size:16px; color:#000066">Số lượng sản phẩm: {$totalquantity}</div>
    <div style="float:right"><strong style="font-size:16px; color:#FF0000">Tổng tiền thanh toán: &nbsp;&nbsp;{format_number number=$total}</strong></div></td>			
  </tr>
</table> 