{literal}{/literal}
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
<tr>
	 <td style="padding:5px; border-bottom:1px solid #cccccc; color:#0000FF" class="title" align="left">{$Name}</td>
	 <td align="right" style="padding:5px; border-bottom:1px solid #cccccc; color:#0000FF" class="title">Số lượng</td>	 
    <td align="right" style="padding:5px; border-bottom:1px solid #cccccc; color:#0000FF" class="title">Giá</td>
	<td align="right" style="padding:5px; border-bottom:1px solid #cccccc; color:#0000FF" class="title">Thành tiền</td>
	<td align="right" style="padding:5px; border-bottom:1px solid #cccccc; color:#0000FF" class="title">&nbsp;</td>
	
	</tr>
	{foreach key=key item=item from=$arr}	   
	<tr>	
	<td style="padding:5px 5px 5px 5px; border-bottom:1px solid #cccccc"><strong>{$item.name}</strong></td>
	<td align="right" style="padding:5px; border-bottom:1px solid #cccccc">{$item.quanlity}</td>
	<td align="right" style="padding:5px; border-bottom:1px solid #cccccc">{format_number number=$item.price}</td>
	{assign var="totalquanlity" value="$item.price*$item.quanlity"}
	<td align="right" style="padding:5px; border-bottom:1px solid #cccccc">{format_number number=$totalquanlity}</td>    
	</tr>	    
  {assign var="total" value="$total+$totalquanlity"}
{/foreach}
<tr>
	  <td style="padding:5px">&nbsp;</td>
	  <td>&nbsp;</td>
	  <td align="right" bgcolor="#F8EBBA" class="title">{$Total}:</td>
	  <td align="right" bgcolor="#F8EBBA" class="title" style="padding-right:5px;" nowrap="nowrap">{format_number number=$total}</td>
	</tr>
</table>