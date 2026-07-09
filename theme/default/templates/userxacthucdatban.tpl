{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
{/literal}
<div class="col-xs-12 col-sm-12 col-md-9">
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
                    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">THÔNG TIN ĐẶT BÁN</td>
                  </tr>
                 
                  {foreach key=key item=item from=$arrxacthucdatban}
                  		
                         <tr>
                            <td colspan="2"><strong>Thông tin giao dịch</strong></td>
                          </tr>	
                          <tr>
                            <td>Hợp đồng muốn rút vốn:</td>
                            <td>Mã HĐ - {$item.hdban}</td>
                          </tr>
                           <tr>
                            <td>Ngày đặt lệnh:</td>
                            <td>{$item.date_create}</td>
                          </tr>
                           <tr>
                            <td>Số lượng ĐVĐT muốn bán:</td>
                            <td>{format_number number=$item.model}</td>
                          </tr>
                           <tr>
                            <td>Giá bán 1 ĐVĐT:</td>
                            <td>{if $item.price}{format_number number=$item.price}{else}Giá ĐVĐT rút vốn là giá trị đóng cửa (sau 15h30) ngày thứ 5 hàng tuần{/if}</td>
                          </tr>
                           <tr>
                            <td>Tổng giá trị bán:</td>
                            <td>{format_number number=$item.price_old}</td>
                          </tr>
                          <tr>
                            <td>Lãi/Lỗ:</td>
                            <td>{format_number number=$item.price_old}</td>
                          </tr>
                          <tr>
                            <td>Phí hợp tác đầu tư:</td>
                            <td>{format_number number=$item.price_old}</td>
                          </tr>
                          <tr>
                            <td>Phí hợp tác đầu tư:</td>
                            <td>{format_number number=$item.price_old}</td>
                          </tr>
                          <tr>
                            <td colspan="2">
                                
                                   {if $item.price}<button class="button1"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_sell&id={$key}&loai=1" rel="modal:open" class="title" style="font-size:14px; color:#006633">Xác thực</a></button>{else}<button class="button1"  class="title" style="font-size:14px; color:#FFFFFF; background-color:#CCCCCC; border:2px solid #CCCCCC" title="chưa thể xác thực">Xác thực</button>{/if}
                                
                            </td>
                          </tr>	
                    
                     
                   {/foreach}
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