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
{/if}

{if $moduleName=='user'}<div class="row hidden-md-up" style="background-color:#CCCCCC">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr height="40px">
        <td width="50%" nowrap="nowrap" id="center2000" style="padding-left:5px; padding-right:5px;" align="center"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_buy_sell/"  style="font-size:11px"><strong>ĐẦU TƯ TĂNG TRƯỞNG - TSTT</strong></a></td>
        <td width="50%" nowrap="nowrap"  id="center2001" style="padding-left:5px; padding-right:5px;" align="center"><a style="font-size:11px" href="{$smarty.const._DOMAIN_ROOT_URL}/user_buy_sell456/"><strong>ĐẦU TƯ BỀN VỮNG - TSBV</strong></a></td>
      </tr>
    </table>
 </div>{/if}
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
                    <td colspan="5" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin đầu tư tăng trưởng - Ngày {$arrTSI.date}</td>
                  </tr>
                  <tr>
                    <td align="center" class="td"><strong>Tài sản ròng</strong></td>
                    <td align="center" class="td"><strong>Tổng số lượng ĐVĐT</strong></td>
                    <td align="center" class="td"><strong>Giá 1 ĐVĐT</strong></td>
                    <td align="center" class="td"><strong>Tăng/giảm (%)</strong></td>
                    <td align="center" class="td"><strong>Lệnh</strong></td>
                  </tr>
                  <tr>
                    <td class="td" style="text-align: center; vertical-align: middle;"><strong>{format_number number=$arrTSI.taisan}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle;"><strong>{format_number number=$arrTSI.khoiluong}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle;"><strong>{format_number number=$arrTSI.giadvdt}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle;">{if (($arrTSI.giadvdt-$arrTSITangGiam.giadvdt))>0}<strong style="color:#0000CC">{else}<strong style="color:#FF0000">{/if}{format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}%</strong></td>
                    <td align="center" nowrap="nowrap" style="max-width:145px">
                    {if $cmt}<button class="button2" style="width:100%"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="title" style="color:#006633">Đặt mua</a></button>{else}<button class="button2" style="width:100%"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=userinfo" rel="modal:open" class="title" style="color:#006633">Đặt mua</a></button>{/if}
                    </td>
                  </tr>
                </table>
            
            
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
                    <td  {if ($arrTSI.giadvdt-($tonggiatrimua/$tongsoluongdvdt))>0} style="color:#0000CC; text-align: right; vertical-align: middle;" {else} style="color:#FF0000; text-align: right; vertical-align: middle;" {/if} ><strong>{format_number2 number=(($arrTSI.giadvdt-($tonggiatrimua/$tongsoluongdvdt))/$item.price*100)}%</strong></td>
                    <td  style="vertical-align: middle; text-align:center"></td>
                  </tr>
                </table>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Giao dịch mua</div>
                	<div>{userxacthucmua}</div>
                </div>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Giao dịch bán</div>
                	<div class="hidden-sm-down">{userxacthucbanpc}</div>
                    <div class="hidden-md-up">{userxacthucban}</div>                    
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
               
              
              <div>{HDcuadoitacPro}</div>
                <div style="padding-top:10px; padding-bottom:10px"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(113)">Thông tin các hợp đồng đầu tư</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(113)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
              </div>
                 
            <div id="113" style="display:none;">
            	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  
                  <tr class="tr">
                    <td  style="vertical-align: middle; text-align:center">Ngày mua</td>
                    <td  style="vertical-align: middle; text-align:center">Số hợp đồng</td>
                    <td  style="vertical-align: middle; text-align:center">Số lượng ĐVĐT</td>
                    <td  style="vertical-align: middle; text-align:center">Giá mua 1 ĐVĐT</td>
                    <td  style="vertical-align: middle; text-align:center">Tổng giá trị mua</td>
                    <td  style="vertical-align: middle; text-align:center">Lãi/ lỗ</td>
                    <td  style="vertical-align: middle; text-align:center">% Lãi/ lỗ</td>
                  </tr>
                   {assign var="totalmodel" value="0"}
                   {assign var="totalprice_old" value="0"}
                   {assign var="lailo" value="0"}
                  {foreach key=key item=item from=$arrUserSohuu}
                  	
                    	{assign var="model" value="`$item.model+$item.product_in`"}
                        {assign var="price_old" value="`$item.price_old`"}
                        
                      <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
                        <td class="title" style="vertical-align: middle;">{$item.date_create}</td>
                        <td class="title" style="vertical-align: middle;">{$item.name}</td>
                        <td class="title" align="right" style="vertical-align: middle;">{format_number number=$model}</td>
                        <td class="title" align="right" style="vertical-align: middle;">{format_number number=$item.price}</td>
                        <td class="title" align="right" style="vertical-align: middle;">{format_number number=$price_old}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; vertical-align: middle;" {else} style="color:#FF0000; vertical-align: middle;" {/if}>{format_number number=(($arrTSI.giadvdt-$item.price)*$model)}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; vertical-align: middle;" {else} style="color:#FF0000; vertical-align: middle;" {/if}>{format_number2 number=(($arrTSI.giadvdt-$item.price)/$item.price*100)}%</td>
                      </tr>
                    
                      {assign var="totalmodel" value="`$totalmodel+$model`"}
                      {assign var="totalprice_old" value="`$totalprice_old+$price_old`"}
                      {assign var="lailo" value="`$lailo+(($arrTSI.giadvdt*$model)-($price_old))`"}
                    
                   {/foreach}
                   
                   <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}" height="46px">
                        <td class="title" style="vertical-align: middle;" colspan="2" align="center"><strong>Tổng:</strong></td>
                        <td class="title" align="right" style="vertical-align: middle;"><strong>{format_number number=$totalmodel}</strong></td>
                        <td class="title" align="right" style="vertical-align: middle;"><strong>{format_number number=$totalprice_old/$totalmodel}</strong></td>
                        <td class="title" align="right" style="vertical-align: middle;"><strong>{format_number number=$totalprice_old}</strong></td>
                        <td class="title" align="right" {if ($lailo)>0} style="color:#0000CC; vertical-align: middle;" {else} style="color:#FF0000; vertical-align: middle;" {/if}><strong>{format_number number=$lailo}</strong></td>
                        <td class="title" align="right" {if ($lailo)>0} style="color:#0000CC; vertical-align: middle;" {else} style="color:#FF0000; vertical-align: middle;" {/if}><strong>{format_number2 number=(($lailo/$totalprice_old)*100)}%</strong></td>
                      </tr>
                   
                </table>
            </div>
            <div style="padding-top:10px; padding-bottom:10px"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(114)">Lịch sử giao dịch</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(114)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
              </div>
              <div id="114" style="display:none;">
              	<div  id="lichsugiaodich" >{lichsugiaodich}</div>
              </div>
            </li>
            <li class="tabCot">             
             <div  style="padding-top:10px;">
             	<div class="col-xs-12 col-sm-12 col-md-5">
                	<div class="titleBlock" style="padding-top:10px;" align="center">Tổng quan</div>
                	<div style="padding-top:10px">{$tongquan}</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7">
                	<div class="titleBlock" style="padding-top:10px;" align="center">Hiệu quả đầu tư</div>
                	<div style="padding-top:10px">{hieuqua}</div>
                </div>
                
            </div>
            <div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(8)" class="title" >Giới thiệu <i class="fa fa-angle-down" aria-hidden="true"></i></div>
            <div id="8" style="display:none; padding:5px">{$gioithieu}</div>
            <div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(7)" class="title" >Thành tựu <i class="fa fa-angle-down" aria-hidden="true"></i></div>
            <div id="7" style="display:none; padding:5px">{$thanhtuu}</div>
            <div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(6)" class="title" >Điều khoản dịch vụ <i class="fa fa-angle-down" aria-hidden="true"></i></div>
            <div id="6" style="display:none; padding:5px">{$dieukhoan}</div>
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
            
            <div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(9)" class="title" >Câu hỏi thường gặp <i class="fa fa-angle-down" aria-hidden="true"></i></div>
            <div id="9" style="display:none; padding:5px">{$cauhoi}</div>
            </li>
            
            <li class="tabCot">
            {if $cmt}
                <div style="padding-top:10px;" class="row">
                {literal}
                    <style>
					.collapse-icon {
						font-size: 20px;
						width: 25px;
						float: right;
						font-weight: normal;
					}
					basedcustom.css:188
					.collapse-icon {
						font-size: 20px;
						width: 50px;
						float: right;
						font-weight: normal;
					}
					.inveslist{
						font-weight:bold;padding-bottom:5px; padding-top:5px; color:#212121; font-size: 16px;		
					}
					.inveslist:hover{ color:#006633; text-decoration: none; cursor:pointer; font-size: 16px;	}
				  </style> 
                  {/literal} 
                	<div style="padding:10px;"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(111)">Báo cáo đầu tư tuần</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(111)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
                 </div>
                <div id="111" style="display:none; padding:10px">  
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
                
                <div style="padding:10px;"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(112)">Báo cáo đầu tư tháng</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(112)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
                 </div>
                <div id="112" style="display:none; padding:10px">  
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="topicContent"><h1>Danh mục đầu tư</h1></div>
                        <div>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">    
                        <div class="topicContent"><h1>Báo cáo NAV</h1></div>
                        <div>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="topicContent"><h1>Báo cáo hoạt động đầu tư</h1></div>
                        <div>
                           
                        </div>
                    </div>
                </div>
            </div> 
            
             {else}
              	<div align="center" style="padding-top:60px; padding-bottom:10px">Bạn cần hoàn thiện thông tin cá nhân để sử dụng chức năng này</div>
                <div align="center" style="padding-bottom:60px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" class="title">Click vào đây để hoàn thiện thông tin cá nhân</a></div>
              {/if}  
            </li>
            <li class="tabCot">
                <div>{infoMembersanvl}</div>
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