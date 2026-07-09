{literal}
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		document.frmTemp.objdrop.value = obj.id;
	}
}


</script>
{/literal}
<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-3 col-md-3"  style="padding-bottom:30px">
    	<div class="room-sidebar">
        	 <div>{usermenu2}</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9">
    	{if $numberUserGioithieu>0}
        <div class="clearfix" style="height:25px"></div>
        <div class="titledaotao">Khách hàng giới thiệu</div>
        <div class="box-table" style="padding-top:10px"> 
        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table" style="border:1px solid #CCCCCC">
          <tr style="background-color:#0b7a62">
         	<td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Stt</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Tên học viên</strong></td>
            
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Ngày đăng ký<br />Tên khóa học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Giá khóa học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Ưu đãi</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Thành tiền</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Thanh toán lần 1</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Thanh toán lần 2</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Hoa hồng</strong></td>
            <td  style="vertical-align: middle; text-align:cente; color:#FFFFFF; font-size:0.8rem;"><strong>Tình trạng</strong></td>
          </tr>
          {assign var="i" value=1}
          {assign var="tongcong" value=0}
          {foreach key=key item=item from=$arrUserGioithieu}
              <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
              	
                <td  style="text-align: center; vertical-align: middle;">{$i}</td>
                <td  style="text-align: center; vertical-align: middle;">{$item.name}</td>
                
                <td style="text-align: justify; vertical-align: middle; min-width:200px">
                <strong>Ngày đăng ký:</strong> {$item.date_create}<br />
                <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}&aff={$affiliate_id}" >{$item.nameproduct}</a>
                </td>
                <td  style="text-align: right; vertical-align: middle;">{format_number number=$item.price}</td>
                <td  align="center" style="vertical-align: middle;">Giảm: {if $item.khuyenmai}{$item.khuyenmai}%{else}{format_number number=$item.price-$item.tongtien}{/if}</td>
                <td  align="right" style="vertical-align: middle;">{format_number number=$item.tongtien}</td>
                <td  align="right" style="vertical-align: middle;">{format_number number=$item.cklan1}</td>
                <td  align="right" style="vertical-align: middle;">{format_number number=$item.cklan2}</td>
                <td  align="right" style="vertical-align: middle;">{format_number number=$item.hoahong}</td>
                <td  align="center" style="vertical-align: middle;">{if $item.ctrl=='1'}Đang học{else}<font style="color:#FF0000">Mới đăng ký</font>{/if}</td>
               
              </tr>
              
              {assign var="i" value=$i+1}
              {assign var="tongcong" value=$tongcong+$item.tongtien}
              {assign var="tongthanhtoanlan1" value=$tongthanhtoanlan1+$item.cklan1}
              {assign var="tongthanhtoanlan2" value=$tongthanhtoanlan2+$item.cklan2}
              {assign var="tonghoahong" value=$tonghoahong+$item.hoahong}
           {/foreach}
           	  <tr>
              	<td colspan="5" class="title">Tổng cộng:</td>
                <td>{format_number number=$tongcong}</td>
                <td>{format_number number=$tongthanhtoanlan1}</td>
                <td>{format_number number=$tongthanhtoanlan2}</td>
                <td>{format_number number=$tonghoahong}</td>
                <td></td>
              </tr>	
        </table>
        </div>
        {/if}
        
           
		</div>
	</div>
</div>