<div class="title" ><h1 class="title" style="text-transform:uppercase">Thông tin tài khoản</h1></div>
<div class="row">
<div class="col-xs-12 col-sm-4 col-md-4">
<div class="content" style="padding:5px; text-transform:uppercase">Họ và tên: <strong>{$arr.name}</strong></div>
<div class="content" style="padding:5px">Email: <strong>{$arr.email}</strong></div>
<div class="content" style="padding:5px">Điện thoại: <strong>{$arr.mobile}</strong></div>
<div class="content" style="padding:5px">Địa chỉ: <strong>{$arr.address}</strong></div>
<div class="content" style="padding:5px">Số CMND: <strong>{$arr.cmt}</strong></div>
<div class="content" style="padding:5px">TK Ngân Hàng: <strong>{$arr.tknh} - {$arr.nganhangtknh} - {$arr.chinhanhtknh}</strong></div>
</div>

</div>
<div class="row">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/user/{$arr.img}" width="300px" /></td>
    <td><img src="{$smarty.const._DOMAIN_ROOT_URL}/images/user/{$arr.img1}" width="300px" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div class="topic">Các hợp đồng giới thiêu</div> 
<div style="text-align:right; padding-bottom:10px"><a href="?m=doitac&op=frmCreate" class="title">{$doitac_create}</a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="right"> Lựa chọn: </td>
    <td nowrap="nowrap" class="title" >Năm: &nbsp;</td>
    <td align="right" nowrap="nowrap">			
    <select name="year" onchange="location = '{$smarty.const._DOMAIN_ROOT_URL}/admin80/?m=doitac&op=frmCreate{if $id}&id={$id}{/if}{if $month}&month={$month}{/if}&year='+ this.options[this.selectedIndex].value;" style="font-size:12px" >
    	<option value="2020" {if $year=="2020"} selected="selected"{/if}>2020</option>
    	<option value="2021" {if $year=='2021'} selected="selected"{/if}>2021</option>                   
        <option value="2022" {if $year=="2022"} selected="selected"{/if}>2022</option>
        <option value="2023" {if $year=="2023"} selected="selected"{/if}>2023</option>
        
        <option value="2024" {if $year=='2024'} selected="selected"{/if}>2024</option>                   
        <option value="2025" {if $year=="2025"} selected="selected"{/if}>2025</option>
        <option value="2026" {if $year=="2026"} selected="selected"{/if}>2026</option>
        
        <option value="2027" {if $year=='2027'} selected="selected"{/if}>2027</option>                   
        <option value="2028" {if $year=="2028"} selected="selected"{/if}>2028</option>
        <option value="2029" {if $year=="2029"} selected="selected"{/if}>2029</option>
        
        <option value="2030" {if $year=='2030'} selected="selected"{/if}>2030</option>  
            
    </select>
    </td>
    <td nowrap="nowrap" class="title">Tháng: &nbsp;</td>
    <td align="right" nowrap="nowrap">			
    <select name="month" onchange="location = '{$smarty.const._DOMAIN_ROOT_URL}/admin80/?m=doitac&op=frmCreate{if $id}&id={$id}{/if}{if $year}&year={$year}{/if}&month='+ this.options[this.selectedIndex].value;" style="font-size:12px" >
        <option value="1" {if $month=="1"} selected="selected"{/if}>1</option>                   
        <option value="2" {if $month=="2"} selected="selected"{/if}>2</option>
        <option value="3" {if $month=="3"} selected="selected"{/if}>3</option>
        
        <option value="4" {if $month=="4"} selected="selected"{/if}>4</option>                   
        <option value="5" {if $month=="5"} selected="selected"{/if}>5</option>
        <option value="6" {if $month=="6"} selected="selected"{/if}>6</option>
        
        <option value="7" {if $month=="7"} selected="selected"{/if}>7</option>                   
        <option value="8" {if $month=="8"} selected="selected"{/if}>8</option>
        <option value="9" {if $month=="9"} selected="selected"{/if}>9</option>
        
        <option value="10" {if $month=="10"} selected="selected"{/if}>10</option>                   
        <option value="11" {if $month=="11"} selected="selected"{/if}>11</option>
        <option value="12" {if $month=="12"} selected="selected"{/if}>12</option>
       
            
    </select>
    </td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  
  <tr class="tr" style="background-color:#CCCCCC">
                    <td  style="vertical-align: middle; text-align:center; padding:5px"><strong>Ngày mua</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Số hợp đồng</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Chủ HĐ</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Số lượng ĐVĐT</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Giá mua 1 ĐVĐT</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Tổng giá trị</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Lãi/ lỗ</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>% Lãi/ lỗ</strong></td>
                    
                  </tr>
{assign var="total" value="0"}
{assign var="hoahong" value="0"}
{assign var="lailo" value="0"}
{foreach key=key item=item from=$arrdoitacHD}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
    <td class="title" style="text-align: center; vertical-align: middle;">{$item.date_create}</td>
    <td class="title" style="text-align: center; vertical-align: middle;">{$item.name}</td>
    <td class="title" style="text-align: center; vertical-align: middle;">{$item.nameuser}</td>
    <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.delivery}</td>
    <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.price}</td>
    <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.promotion}</td>
    <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; text-align: center; vertical-align: middle;" {else} style="color:#FF0000; text-align: center; vertical-align: middle;" {/if}>{format_number number=($arrTSI.giadvdt-$item.price)*$item.delivery}</td>
    <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; text-align: center; vertical-align: middle;" {else} style="color:#FF0000; text-align: center; vertical-align: middle;" {/if}>{format_number2 number=(($arrTSI.giadvdt-$item.price)/$item.price*100)}%</td>
  
  </tr>
 {assign var="total" value="`$total+$item.promotion`"}
{/foreach}

{if $total < 500000000}{assign var="hoahong" value="`$total*0.001`"}{/if}
{if 500000000 < $total && $total < 2000000000}{assign var="hoahong" value="`$total*0.002`"}{/if}
{if 2000000000 < $total && $total < 5000000000}{assign var="hoahong" value="`$total*0.004`"}{/if}
{if 5000000000 < $total && $total < 10000000000}{assign var="hoahong" value="`$total*0.006`"}{/if}
{if 10000000000 < $total}{assign var="hoahong" value="`$total*0.008`"}{/if}

<tr>
	<td colspan="8"  class="title" style="font-size:14px; padding:10px; color:#FF0000" align="right">Tổng giới thiệu trong tháng {$month}/{$year}: {format_number number=$total}</td>
</tr>
<tr>
	<td colspan="8"  class="title" style="font-size:14px; padding:10px; color:#0000FF" align="right">Hoa hồng trong tháng: {format_number number=$hoahong}</td>
</tr>
</table>