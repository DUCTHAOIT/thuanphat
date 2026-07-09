<!--
Danh sach chuc nang
-->
{literal}
<style>
	.yellow {
		background-color: #f9f9f9 !important;
	}
</style>
<script>


	$(function() {
		$('tr.unselected').hover(function() {
			$(this).addClass('yellow');
		}, function() {
			$(this).removeClass('yellow');
		});
	});
</script>
{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> bản ghi</div>
<div style="padding-top:10px"> 
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="hdmuachung" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table table-striped table-bordered dataTable" style="font-size:11px;">
  <tr class="tr">
    <td class="td">ID</td>
    <td class="td">Học Viên</td>
    <td  style="vertical-align: middle; text-align:center"><strong>Khóa học</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Giá</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Người giới thiệu</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>CK lần 1</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>CK lần 2</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Còn nợ</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Lớp</strong></td>
   <td  style="vertical-align: middle; text-align:center"><strong>Ghi chú</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Trạng thái</strong></td>
    {if $uid=='15'}<td  style="vertical-align: middle; text-align:center"><strong>Sale</strong></td>{/if}
    <td  style="vertical-align: middle; text-align:center" colspan="2"><strong></strong></td>
    </tr>
  {assign var="conno" value="0"} 
  {assign var="tongchietkhau" value="0"}
  {assign var="tongmua" value="0"}
  {assign var="tongck1" value="0"}
  {assign var="tongck2" value="0"}
  {assign var="tongno" value="0"}
  {foreach key=key item=item from=$arr}
  {$conno=$item.tongtien-$item.cklan1-$item.cklan2}
  <tr class="unselected" {if $item.ctrl=='0'} bgcolor="#66FFFF" {else}bgcolor="{cycle values="#FFFFFF,#F7F7F7"}{/if}">
   <td align="left" class="td" nowrap="nowrap" style="vertical-align: middle;">{$key}</td>
    <td class="td" nowrap="nowrap" align="left" style="vertical-align: middle;">
    <strong>Ngày đk:</strong> {$item.date_create}<br />
    <a href="?m=hdmuachung&userid={$item.userid}" class="title" style="text-transform:uppercase">{$item.name}</a><br />{$item.email}<br />{$item.mobile}<br />(<a href="?m=user&op=frmCreate&id={$item.email}" class="content"><i>Thông tin</i></a>)</td>
    <td style="vertical-align: middle; min-width:250px"><a href="?m=hdmuachung&proid={$item.proid}" class="title">{$item.nameproduct}</a></td>
    <td  align="left" style="vertical-align: middle;" nowrap="nowrap">
    	<strong>Giá niêm yết:</strong> {format_number number=$item.price}<br />
        <strong>Giảm:</strong> {if $item.khuyenmai}{$item.khuyenmai}%{else}{format_number number=$item.price-$item.tongtien}{/if}<br />
        <strong>Thành tiền:</strong> {format_number number=$item.tongtien}
    </td>
    <td  align="center"  style="vertical-align: middle;" nowrap="nowrap">
    	<a href="?m=hdmuachung&aff={$item.nguoigioithieu}">{$item.nguoigioithieu}</a><br />
        {if $item.hoahong} Hoa hồng: {format_number number=$item.hoahong}{/if}
        {if $item.voucher} Voucher: {$item.voucher}{/if}
    </td>
    <td  align="left"  style="vertical-align: middle;" nowrap="nowrap">{if $item.ngaycklan1}Ngày: {$item.ngaycklan1}{/if}<br />{if $item.cklan1}Số tiền: {format_number number=$item.cklan1}{/if}</td>
    <td  align="left"  style="vertical-align: middle;" nowrap="nowrap">{if $item.ngaycklan2}Ngày: {$item.ngaycklan2}{/if}<br />{if $item.cklan2}Số tiền: {format_number number=$item.cklan2}{/if}</td>
    <td  align="right"  style="vertical-align: middle; color:#FF0000">{if $conno>0}{format_number number=$conno}{else}{$conno}{/if}</td>
    <td  align="center"  style="vertical-align: middle;" nowrap="nowrap">{nameLop id=$item.lop}</td>
     <td  align="right"  style="vertical-align: middle;" nowrap="nowrap">{$item.content}</td>
    <td nowrap="nowrap" class="td" align="center" style="vertical-align: middle;">{if $conno>0}<font style="color:#FF0000">Chưa chuyển khoản</font><br /><a href="#" onclick="goEdit({$key})" class="title"><button class="btn btn-primary" style="padding:5px">Cập nhật chuyển khoản</button></a>{else}<font style="color:#0000FF">Đã thanh toán hết</font>{/if}</td>
    {if $uid=='15'}
  	<td  style="vertical-align: middle;" nowrap="nowrap"><div class="btn btn-success text-white show" style="width:120px;">
     <select  onChange="callSale(this.options[this.selectedIndex].value,'{$key}')"  style="background-color:#28b779; color:#FFFFFF; border:0px">
     <option value="0" >--Chọn Sale--</option>
     {foreach key=k item=v from=$arrsale}
    	{if $k==$item.sale}
     	 <option value="{$k}" selected="selected" >{$v.fistname}</option>
    	{else}
		<option value="{$k}" >{$v.fistname}</option>
    	{/if}
	{/foreach}
     </select>
     </div></td>
    {/if} 
    <td align="center"  id="lock_{$key}" onclick="callLock({$key})" style="vertical-align: middle;" ><img src="images/{$item.ctrl}.gif"  /></td>
    <td align="center" style="vertical-align: middle;"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" /></td>
    </tr>
    {if $item.ctrl=='1'}
   
    {assign var="tongmua" value="`$tongmua+$item.tongtien`"}
    {assign var="tongck1" value="`$tongck1+$item.cklan1`"}
    {assign var="tongck2" value="`$tongck2+$item.cklan2`"}
    {assign var="tongno" value="`$tongno+$conno`"}
    {/if}
  {/foreach}
  <tr>
  		
    	<td class="title" colspan="3" align="right">Tổng cộng</td>
        <td class="title" align="right" >{format_number number=$tongmua}</td>
        <td></td>
        <td class="title"  align="right">{format_number number=$tongck1}</td>
        <td class="title"  align="right">{format_number number=$tongck2}</td>
        <td class="title"  align="right">{format_number number=$tongno}</td>
        <td class="title" colspan="5" align="right"></td>
    </tr>
</table>
</form>
{$sPage}
</div>