{literal}{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> Hợp đồng</div>
<div class="box-table" style="padding-top:10px"> 
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="2" cellpadding="2" class="table" style="border:1px solid #CCCCCC">
  <tr class="tr">
    <td class="td">Số HĐ</td>
    <td class="td">Ngày mua</td>
    <td class="td">Người mua</td>
    <td  style="vertical-align: middle; text-align:center"><strong>Dự án</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Số cổ phần</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Số tiền / 1 cổ phần</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Tổng giá trị vốn góp</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>CK lần 1</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Ngày ck lần 1</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>CK lần 2</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Ngày ck lần 2</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Còn nợ</strong></td>
     <td  style="vertical-align: middle; text-align:center"><strong>File</strong></td>
    <td  style="vertical-align: middle; text-align:center"><strong>Ghi chú</strong></td>
   
    <td  style="vertical-align: middle; text-align:center"><strong>Trạng thái</strong></td>
    <td  style="vertical-align: middle; text-align:center" colspan="3" nowrap="nowrap"><strong>HOÀN CỌC</strong></td>
    <td  style="vertical-align: middle; text-align:center" colspan="3"><strong></strong></td>
    </tr>
  {assign var="conno" value="0"} 
  {assign var="tongchietkhau" value="0"}
  {assign var="tongmua" value="0"}
  {assign var="tongck1" value="0"}
  {assign var="tongck2" value="0"}
  {assign var="tongno" value="0"}
  {foreach key=key item=item from=$arr}
  {$conno=$item.tongtien-$item.cklan1-$item.cklan2}
  <tr  {if $item.hoancoc=='1'}bgcolor="#FFFF00"{else}bgcolor="{cycle values="#ffffff,#F4F4F4"}"{/if}>
   <td align="left" class="td" nowrap="nowrap">GV-{$item.id}</td>
    <td align="left" class="td">{$item.date_create}</td>
    <td class="td" nowrap="nowrap" align="center"><a href="?m=hdgopvon&userid={$item.userid}" class="title">{$item.name}</a><br />(<a href="?m=user&op=frmCreate&id={$item.email}" class="content"><i>Thông tin</i></a>)</td>
    <td style="text-align: center; vertical-align: middle; min-width:150px"><a href="?m=hdgopvon&proid={$item.proid}" class="title">{$item.nameproduct}</a></td>
   
    <td  style="text-align: center; vertical-align: middle;">{$item.soxuatdautu}</td>
    <td  align="right" style="vertical-align: middle;">{format_number number=$item.sotienmotxuat}</td>
    <td  align="right" style="vertical-align: middle;">{format_number number=$item.tongtien}</td>
    <td  align="right"  style="vertical-align: middle;">{format_number number=$item.cklan1}</td>
    <td  align="right"  style="vertical-align: middle;" nowrap="nowrap">{$item.ngaycklan1}</td>
    <td  align="right"  style="vertical-align: middle;">{format_number number=$item.cklan2}</td>
    <td  align="right"  style="vertical-align: middle;" nowrap="nowrap">{$item.ngaycklan2}</td>
    <td  align="right"  style="vertical-align: middle; color:#FF0000">{if $conno>0}{format_number number=$conno}{else}{$conno}{/if}</td>
     <td  align="left"  style="vertical-align: middle;" nowrap="nowrap">{danhsachhdmuachungListFile fid=$item.id}</td>
    <td  align="right"  style="vertical-align: middle;" nowrap="nowrap">{$item.content}</td>
    
    <td nowrap="nowrap" class="td" align="center">{if $item.tienhoancoc>0}Yêu cầu hoàn cọc{else}{if $conno>0}<font style="color:#FF0000">Chưa chuyển khoản</font><br /><button class="btn_viewmore" style="padding:5px"><a href="#" onclick="goEdit({$key})" class="title">Cập nhật chuyển khoản</a></button>{else}<font style="color:#0000FF">Đã hoàn thành</font>{/if}{/if}</td>
    
    <td  align="right"  style="vertical-align: middle;">{if $item.tienhoancoc}{format_number number=$item.tienhoancoc}{/if}</td>
     <td  align="right"  style="vertical-align: middle;">{if $item.tienhoancoc}{format_number number=$item.phihoancocxacthuc}%{else}{format_number number=$item.phihoancoc}%{/if}</td>
    <td  align="center"  style="vertical-align: middle;">{if $item.tienhoancoc}{if $item.hoancoc=='0'}<a href="#" id="hc_{$key}" onclick="callHC({$key})" style="cursor:pointer;" title="Click để xác nhận đã chuyển khoản hoàn cọc"><img src="images/daban{$item.hoancoc}.gif" alt="Click để xác nhận đã chuyển khoản hoàn cọc" /></a>{else}<img src="images/daban{$item.hoancoc}.gif"  />{/if}{else}{if $item.ngayhoancoc}Hạn được phép hoàn cọc:<br /><strong>{$item.ngayhoancoc}</strong>{/if}{/if}</td>
    
    <td align="center" class="td"  style="cursor:pointer;" ><a href="#" class="title" onclick="goEdit({$key})"><img src="images/edit.gif"  /></a></td>
    <td align="center" class="td" id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer;" ><img src="images/{$item.ctrl}.gif"  /></td>
    <td align="center" class="td"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" /></td>
    </tr>
    {if $item.ctrl=='1'}
    {assign var="tongchietkhau" value="`$tongchietkhau+$item.chietkhau`"}
    {assign var="tongmua" value="`$tongmua+$item.tongtien`"}
    {assign var="tongck1" value="`$tongck1+$item.cklan1`"}
    {assign var="tongck2" value="`$tongck2+$item.cklan2`"}
    {assign var="tongno" value="`$tongno+$conno`"}
    {/if}
  {/foreach}
  <tr>
  		
    	<td class="title" colspan="5" align="right">Tổng cộng</td>
        <td class="title">{format_number number=$tongchietkhau}</td>
        <td class="title" >{format_number number=$tongmua}</td>
        <td class="title">{format_number number=$tongck1}</td>
        <td></td>
        <td class="title">{format_number number=$tongck2}</td>
        <td></td>
        <td class="title">{format_number number=$tongno}</td>
        <td class="title" colspan="5" align="right"></td>
    </tr>
</table>
</form>
{$sPage}
</div>