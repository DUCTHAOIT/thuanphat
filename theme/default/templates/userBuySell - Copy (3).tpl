{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link rel="stylesheet" type="text/css" href="../../jsfile/tabview/tabview.css">
<script type="text/javascript" src="../../jsfile/tabview/yahoo-dom-event.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/element-min.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/tabview-min.js"></script>

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
<div class="col-xs-12 col-sm-12 col-md-12">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
        <td class="yui-skin-sam" style="padding-top:10px">
        <div id="demo" class="yui-navset"> 
			<ul class="yui-nav">   
                 <li><a href="#tab1"><em style="text-transform:uppercase; font-size:14px">TỔNG QUAN TSI-123</em></a></li> 
                 <li  class="selected"><a href="#tab2"><em style="text-transform:uppercase; font-size:14px">Giao dịch</em></a></li>
                 <li><a href="#tab3"><em style="text-transform:uppercase; font-size:14px">BÁO CÁO ĐẦU TƯ</em></a></li>
                 <li><a href="#tab4"><em style="text-transform:uppercase; font-size:14px">Tài khoản</em></a></li>
             </ul>               
             <div class="yui-content">
                 <div id="tab1">
                 	{$tongquan}
                    <div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(1)" class="title" >Chiến lược đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    <div id="1" style="display:none; padding:5px">{$chienluoc}</div>
                    <div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(2)" class="title" >Phương pháp đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    <div id="2" style="display:none; padding:5px">{$phuongphap}</div>
                    <div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(3)" class="title" >Danh mục đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    <div id="3" style="display:none; padding:5px">{$danhmuc}</div>
                    <div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(4)" class="title" >Rủi ro <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    <div id="4" style="display:none; padding:5px">{$ruiro}</div>
                    <div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(5)" class="title" >Ưu điểm <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    <div id="5" style="display:none; padding:5px">{$uudiem}</div>
                 </div>   
                 <div id="tab2">
                 
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
      <div id="tab3">
        <div style="padding-top:10px;" class="row">
        	<div class="col-xs-12 col-sm-12 col-md-4">
                <div class="topicContent"><h1>Danh mục đầu tư</h1></div>
                <div>
                    {inveslistList idF=653}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">    
                <div class="topicContent"><h1>Báo cáo NAV</h1></div>
                <div>
                    {inveslistList idF=652}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
            	<div class="topicContent"><h1>Báo cáo hoạt động đầu tư</h1></div>
                <div>
                	{product_list idF=487}
                </div>
            </div>
            
        </div> 
        <div style="padding-top:10px">
            <div class="topicContent"><h1>Thông tin sở hữu</h1></div>
            <div>{$ndtsohuu}</div>
        </div>  
     </div>  
     <div  id="tab4">
     	<div>{infoMember}</div>
     </div>
      </div>
</div>
</td>
      </tr>
</table> 
</div>

{literal}
<script>
	paintMenuUser(1000);
</script>
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