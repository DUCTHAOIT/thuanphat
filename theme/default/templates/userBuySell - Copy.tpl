{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link rel="stylesheet" type="text/css" href="../../jsfile/tabview/tabview.css">
<script type="text/javascript" src="../../jsfile/tabview/yahoo-dom-event.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/element-min.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/tabview-min.js"></script>
{/literal}
<div class="col-xs-12 col-sm-12 col-md-9">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
        <td class="yui-skin-sam" style="padding-top:10px">
        <div id="demo" class="yui-navset"> 
			<ul class="yui-nav">   
                 <li class="selected"><a href="#tab1"><em style="text-transform:uppercase; font-size:14px">ĐẦU TƯ BỀN VỮNG - TSI 123</em></a></li> 
                 
                 <li><a href="#tab2"><em style="text-transform:uppercase; font-size:14px">ĐẦU TƯ TĂNG TRƯỞNG - TSI 123</em></a></li>
             </ul>               
             <div class="yui-content">   
                 <div id="tab1">
                 
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="4" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin TSI đầu tư bền vững - Ngày {$arrTSI.date}</td>
                  </tr>
                  <tr>
                    <td>Tài sản ròng</td>
                    <td>Tổng số lượng ĐVĐT TSI</td>
                    <td>Gía 1 ĐVĐT</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="title" align="right">{format_number number=$arrTSI.taisan}</td>
                    <td class="title" align="right">{format_number number=$arrTSI.khoiluong}</td>
                    <td class="title" align="right">{format_number number=$arrTSI.giadvdt}</td>
                    <td align="center" width="120px">
                    <button class="button2"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt mua</a></button>
                    </td>
                  </tr>
                </table>
            
            
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin Tài khoản nhà đầu tư - {$MemberName}</td>
                  </tr>
                  <tr>
                    <td>Ngày mua</td>
                    <td>Số Hợp Đồng</td>
                    <td>Số lượng ĐVĐT</td>
                    <td>Giá mua 1 ĐVĐT bình quân</td>
                    <td>Tổng giá trị mua</td>
                    <td>Lãi/ lỗ</td>
                    <td>%</td>
                    <td></td>
                  </tr>
                  {foreach key=key item=item from=$arrUserorder}
                    
                      <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
                        <td class="title">{$item.date_create}</td>
                        <td class="title">{$item.name}{$item.id}</td>
                        <td class="title" align="right">{format_number number=$item.model}</td>
                        <td class="title" align="right">{format_number number=$item.price}</td>
                        <td class="title" align="right">{format_number number=$item.price_old}</td>
                        <td class="title" align="right">{format_number number=($arrTSI.giadvdt-$item.price)*$item.model}</td>
                        <td class="title" align="right">{format_number number=(($arrTSI.giadvdt-$item.price)*$item.model)/$item.price_old*100}%</td>
                        <td align="center">  
                        <button class="button1"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_sell&id={$key}&loai=0" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt bán</a></button></td>
                      </tr>
                   {/foreach}
                </table>
                </div>
      <div id="tab2">
        <div style="padding-top:10px;">
        	<div>
            	Chiến lược đầu tư	
<li>Loại hình đầu tư	Quỹ huy động vốn góp để…</li>
<li>Mục tiêu đầu tư	Tối đa hóa lợi nhuận…</li>
<li>Danh mục đầu tư	Cổ phiếu niêm yết…</li>
<li>Thời điểm đầu tư	Khi thị trường xuất hiện các cơ hội…</li>
<li>Phương pháp đầu tư	Giải ngân với tỷ trọng cao vào những cổ phiếu đang trong chu kỳ tăng trưởng, sử dụng đòn bẩy tài chính (margin)</li>
<li>Ưu điểm	Gia tăng lợi nhuận nhanh trong thời gian ngắn…</li>
<li>Hạn Chế	Trong trường hợp có diễn biến tiêu cực bất ngờ nếu không thoát trạng thái sớm có thể rủi ro cao…</li>

            </div>
        	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="4" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin TSI đầu tư tăng trưởng - Ngày {$arrTSI2.date}</td>
                  </tr>
                  <tr>
                    <td>Tài sản ròng</td>
                    <td>Tổng số lượng ĐVĐT TSI</td>
                    <td>Gía 1 ĐVĐT</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="title" align="right">{format_number number=$arrTSI2.taisan}</td>
                    <td class="title" align="right">{format_number number=$arrTSI2.khoiluong}</td>
                    <td class="title" align="right">{format_number number=$arrTSI2.giadvdt}</td>
                    <td align="center" width="120px">
                    <button class="button2"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI2.id}" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt mua</a></button>
                    </td>
                  </tr>
                </table>
            
            
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin Tài khoản nhà đầu tư - {$MemberName}</td>
                  </tr>
                  <tr>
                    <td>Ngày mua</td>
                    <td>Số Hợp Đồng</td>
                    <td>Số lượng ĐVĐT</td>
                    <td>Giá mua 1 ĐVĐT bình quân</td>
                    <td>Tổng giá trị mua</td>
                    <td>Lãi/ lỗ</td>
                    <td>%</td>
                    <td></td>
                  </tr>
                  {foreach key=key item=item from=$arrUserorder2}
                    
                      <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
                        <td class="title">{$item.date_create}</td>
                        <td class="title">{$item.name}{$item.id}</td>
                        <td class="title" align="right">{format_number number=$item.model}</td>
                        <td class="title" align="right">{format_number number=$item.price}</td>
                        <td class="title" align="right">{format_number number=$item.price_old}</td>
                        <td class="title" align="right">{format_number number=($arrTSI2.giadvdt-$item.price)*$item.model}</td>
                        <td class="title" align="right">{format_number number=(($arrTSI2.giadvdt-$item.price)*$item.model)/$item.price_old*100}%</td>
                        <td align="center">  
                        <button class="button1"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_sell&id={$key}&loai=1" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt bán</a></button></td>
                      </tr>
                   {/foreach}
                </table>
        </div>   
     </div>  
     
      </div>
</div>
</td>
      </tr>
</table> 
</div>
<div class="col-xs-12 col-sm-12 col-md-3">{usermenu}</div>
{literal}
<script type="text/javascript">
	var tabView = new YAHOO.widget.TabView('demo');  
</script>
<script>
$('#manual-ajax').click(function(event) {
  event.preventDefault();
  this.blur(); // Manually remove focus from clicked link.
  $.get(this.href, function(html) {
    $(html).appendTo('body').modal();
  });
});

</script> 
{/literal}