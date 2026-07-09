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
    	{if $numberUserorder>0}
        <div class="clearfix" style="height:25px"></div>
        <div class="titledaotao">Thông tin khóa học</div>
        <div class="box-table" style="padding-top:10px"> 
        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table" style="border:1px solid #CCCCCC">
          <tr style="background-color:#0b7a62">
         
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Tên khóa học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Số giờ học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Số giờ đã học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Giá khóa học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Ưu đãi</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Thành tiền</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>HLV</strong></td>
            <td  style="vertical-align: middle; text-align:cente; color:#FFFFFF; font-size:0.8rem;"><strong>Điểm danh</strong></td>
          </tr>
          {foreach key=key item=item from=$arrUserorder}
              <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
              	
                
                <td style="text-align: justify; vertical-align: middle;"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}&aff={$affiliate_id}" >{$item.nameproduct}</a></td>
                <td  style="text-align: center; vertical-align: middle;">{$item.sogiodahoc}</td>
                <td  style="text-align: center; vertical-align: middle;">{$item.promotion}</td>
                <td  style="text-align: right; vertical-align: middle;">Giảm: {if $item.khuyenmai}{$item.khuyenmai}%{else}{format_number number=$item.price-$item.tongtien}{/if}</td>
                <td  align="center" style="vertical-align: middle;">Giảm {$item.khuyenmai}%</td>
                <td  align="right" style="vertical-align: middle;">{format_number number=$item.tongtien}</td>
                <td  align="center" style="vertical-align: middle;">{nameHlv id=$item.lop}</td>
                
                <td align="center" style="cursor:pointer; vertical-align: middle; color:#FF0000" onClick="JavaScript:dropCategory({$key})">Chi tiết</td>
              </tr>
              <tr id="{$key}" style="display:none;">
              	<td colspan="9">
                	<div id="diemdanh_{$key}">{diemdanh id=$key}</div>
                </td>
              </tr>
           {/foreach}
        </table>
        </div>
        {/if}
        
           
		</div>
	</div>
</div>