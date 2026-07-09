{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<link rel="stylesheet"  href="../../js/tabview2/tab/css/webwidget_tab.css" type="text/css" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type='text/javascript' src='../../js/tabview2/tab/js/webwidget_tab.js'></script>
<script type="text/javascript">// <![CDATA[
            $(function() {
                $(".webwidget_tab").webwidget_tab({
                    window_padding: '10',
                    head_text_color: '#666',
                    head_current_text_color: '#ffffff'
                });
            });
// ]]></script>

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
{if !$cmt}
{literal}
<style>
	#popup_this {
    top: 50%;
    left: 50%;
    text-align:center;
    margin-top: -50px;
   
    position: fixed;
    background: #fff;
      padding: 20px;
	padding-top:30px;
	width:380px;
}
.b-close {
    position: absolute;
    right: 0;
    top: 0;
    cursor: pointer;
    color: #fff;
    background: #ff0000;
    padding: 5px 10px;
}
</style>
<script src="../../js/bpopup-master/jquery.bpopup.min.js"></script>
<script>
$( document ).ready(function() {
    $('#popup_this').bPopup();
});
</script>
{/literal}
<div id="popup_this">
    <span class="button b-close">
        <span>X</span>
    </span>
    <h2>Để có thể giao dịch ngay</h2>
    <p>Quý khách vui lòng <a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" class="title">Click vào đây</a> cập nhật thông tin tài khoản</p>
</div>

<div class="row" style="padding:5px; padding-top:10px; padding-bottom:10px">
<div class="webwidget_tab" id="webwidget_tab">
    <div class="tabContainer">
        <ul class="tabHead">
            <li class="currentBtn" style="margin-right:2px; margin-bottom:2px"><a href="javascript:;"><i class="fa fa-calendar"></i> Giao dịch</a></li>
            <li style="margin-right:2px; margin-bottom:2px"><a href="javascript:;"><i class="fa fa-heart"></i> Tổng quan TSTT</a></li>
            
            <li style="margin-right:2px; margin-bottom:2px"><a href="javascript:;"><i class="fa fa-book"></i> Báo cáo đầu tư</a></li>
            <li style="margin-right:2px; margin-bottom:2px"><a href="javascript:;"><i class="fa fa-cog"></i> Tài khoản</a></li>
            <span style="float:right"><i>Đơn vị số lượng 1 ĐVĐT – Đơn vị tiền: đồng</i></span>
        </ul>
    </div>
    <div class="tabBody">
        <ul>
            <li class="tabCot" style="display: list-item;">
                
            
            
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin Tài khoản nhà đầu tư - {$MemberName}</td>
                  </tr>
                  <tr>
                    <td  style="vertical-align: middle; text-align:center"><strong>Ngày mua</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Số hợp đồng</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Số lượng ĐVĐT</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Giá mua 1 ĐVĐT</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Tổng giá trị mua</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Lãi/ lỗ</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>% Lãi/ lỗ</strong></td>
                    <td  style="vertical-align: middle; text-align:center"><strong>Lệnh</strong></td>
                  </tr>
                  {assign var="tongsoluongdvdt" value="0"}
                  {assign var="tonggiatrimua" value="0"}
                  {assign var="tonglailo" value="0"}
                  {foreach key=key item=item from=$arrUserorder}
                    {if $item.model>0}
                      <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
                        <td class="title" style="text-align: center; vertical-align: middle;">{$item.date_create}</td>
                        <td class="title" style="text-align: center; vertical-align: middle;">{$item.name}</td>

                        <td class="title" align="right" style="vertical-align: middle;">{format_number number=$item.model}</td>
                        <td class="title" align="right" style="vertical-align: middle;">{format_number number=$item.price}</td>
                        <td class="title" align="right" style="vertical-align: middle;">{if ($item.delivery-$item.model)>0}{format_number number=$item.model*$item.price}{else}{format_number number=$item.price_old}{/if}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; vertical-align: middle;" {else} style="color:#FF0000; vertical-align: middle;" {/if}>{format_number number=($arrTSI.giadvdt-$item.price)*$item.model}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC;  vertical-align: middle;" {else} style="color:#FF0000;  vertical-align: middle;" {/if}>{format_number2 number=(($arrTSI.giadvdt-$item.price)/$item.price*100)}%</td>
                        <td align="center" style="max-width:145px; text-align: center; vertical-align: middle;" nowrap="nowrap">  
                        <button class="button1" style="width:100%">
                        {if $ngayban=='1'}
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_sell&id={$key}&loai=0" rel="modal:open" class="title" style="color:#006633">Đặt bán</a>
                        {else}
                        <a href="#" onClick="alert('Quý khách vui lòng đặt lệnh vào khoảng thời gian từ  0h ngày Thứ 2 đến 0h ngày thứ 5 hàng tuần')" class="title" style="color:#006633">Đặt bán</a>
                        {/if}
                        </button></td>
                      </tr>
                      	{assign var="tongsoluongdvdt" value="`$tongsoluongdvdt+$item.model`"}
                        
                        {if ($item.delivery-$item.model)>0}{$giatrimua=$item.model*$item.price}{else}{$giatrimua=$item.price_old}{/if}
                        
                        {assign var="tonglailo" value="`$tonglailo+($arrTSI.giadvdt-$item.price)*$item.model`"}
                        
                         {assign var="tonggiatrimua" value="`$tonggiatrimua+$giatrimua`"}
                     {/if} 
                   {/foreach}
                   <tr height="50px">
                    <td  style="vertical-align: middle; text-align:left;" colspan="2"><strong>Tổng cộng:</strong></td>
                    <td  style="vertical-align: middle; text-align:right;"><strong>{format_number number=$tongsoluongdvdt}</strong></td>
                    <td  style="vertical-align: middle; text-align:right;"><strong>{format_number number=$tonggiatrimua/$tongsoluongdvdt}</strong></td>
                    <td  style="vertical-align: middle; text-align:right;"><strong>{format_number number=$tonggiatrimua}</strong></td>
                    <td  {if ($arrTSI.giadvdt-($tonggiatrimua/$tongsoluongdvdt))>0} style="color:#0000CC; text-align: right; vertical-align: middle;" {else} style="color:#FF0000; text-align: right; vertical-align: middle;" {/if}><strong>{format_number number=$tonglailo}</strong></td>
                    <td  {if ($arrTSI.giadvdt-($tonggiatrimua/$tongsoluongdvdt))>0} style="color:#0000CC; text-align: right; vertical-align: middle;" {else} style="color:#FF0000; text-align: right; vertical-align: middle;" {/if} ><strong>{format_number2 number=($tonglailo/$tonggiatrimua*100)}%</strong></td>
                    <td  style="vertical-align: middle; text-align:center"></td>
                  </tr>
                </table>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Giao dịch mua</div>
                	<div>{userxacthucmua}</div>
                </div>
               
                <div style="padding-top:10px; padding-bottom:10px"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(199)">Thông tin tài khoản giới thiệu</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(199)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
              </div>
                <div class="row" id="199" style="display:none;">
                	<div >{usergioithieu}</div>
                </div>
             
                
         
            </li>
           
        </ul>
        <div style="clear:both"></div>
    </div>
    <div class="modBottom">
        <span class="modABL"> </span><span class="modABR"> </span>
    </div>
</div>    <div style="clear:both;"></div>
<br/>
<div>
</div>
</div>
{literal}

<style>
@media only screen and (max-width: 1000px){
.webwidget_tab .tabHead li{
    width:49.4%;
}
}
</style>
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