{literal}{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FFFFFF">
<TABLE WIDTH=80% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD>
			<IMG SRC="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_01.gif" WIDTH=42 HEIGHT=62 ALT=""></TD>
		<TD style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_02.gif); background-repeat:repeat-x; padding-top:20px; color:#993300"><div style="padding-top:10px; text-transform:uppercase; color:#8D0100"><strong>{$Hello}:</strong><font class="title">&nbsp;{$fullname}</font></div>	<strong>Danh sách các đơn hàng bạn đã đặt mua</strong></TD>
		<TD>
			<IMG SRC="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_03.gif" WIDTH=42 HEIGHT=62 ALT=""></TD>
	</TR>
	<TR>
		<TD style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_04.gif); background-repeat:repeat-y"></TD>
		<TD width="100%" style="padding-top:20px; padding-bottom:20px">			
			<table cellpadding=4 cellspacing=0 border=1 bordercolor=#CCCCCC style="border-collapse:collapse;" width="95%">
			  <tr height="25">
				<td class="tr">ID</td>
				<td class="tr">Ngày đặt hàng</td>
				<td class="tr">Vận chuyển</td>
				<td class="tr">Phương thức thanh toán</td>
				<td class="tr">Trạng thái</td>
				<td class="tr">&nbsp;</td>
			  </tr>
			  {foreach key=key item=item from=$arr}
			  <tr>
				<td class="td">{$key}</td>
				<td class="td"><strong>{$item.sdate}</strong></td>
				<td class="td">{$item.shippingMethod}</td>
				<td class="td">{$item.method}</td>
				<td class="td">{$item.ctrl}</td>
				<td class="td"><a href="/user_detail_basket/{$item.id}/">Chi tiết</a></td>
			  </tr>
			  {/foreach}
			</table>
			<div style="text-align:right">{$sPage}</div>
		</TD>
		<TD style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_06.gif); background-repeat:repeat-y"></TD>
	</TR>
	<TR>
		<TD>
			<IMG SRC="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_07.gif" WIDTH=42 HEIGHT=45 ALT=""></TD>
		<TD style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_08.gif); background-repeat:repeat-x"></TD>
		<TD>
			<IMG SRC="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_09.gif" WIDTH=42 HEIGHT=45 ALT=""></TD>
	</TR>
</TABLE>
</td>
  </tr>
</table>