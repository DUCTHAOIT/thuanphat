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
                    head_current_text_color: '#f1592a'
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
{if $moduleName=='user'}<div class="hidden-md-up" style="padding-top:50px">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr height="40px">
        <td nowrap  id="center2000" style="padding-left:10px; padding-right:10px;" align="center"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_buy_sell/"  style="font-size:12px"><strong>ĐẦU TƯ TĂNG TRƯỞNG - TSTT</strong></a></td>
        <td nowrap id="center2001" style="padding-left:10px; padding-right:10px;" align="center"><a style="font-size:12px" href="{$smarty.const._DOMAIN_ROOT_URL}/user_buy_sell456/"><strong>ĐT BỀN VỮNG - TSBV</strong></a></td>
      </tr>
    </table>
 </div>{/if}
<div>
<div class="webwidget_tab" id="webwidget_tab">
    <div class="tabContainer">
        <ul class="tabHead">
            <li class="currentBtn"><a href="javascript:;"><i class="fa fa-calendar"></i> Giao dịch</a></li>
             <li ><a href="javascript:;"><i class="fa fa-heart"></i> Tổng quan TSBV</a></li>
            
            <li><a href="javascript:;"><i class="fa fa-book"></i> Báo cáo đầu tư</a></li>
            <li><a href="javascript:;"><i class="fa fa-cog"></i> Tài khoản</a></li>
            <span style="float:right"><i>Đơn vị số lượng 1 ĐVĐT – Đơn vị tiền: đồng</i></span>
        </ul>
    </div>
    <div class="tabBody">
        <ul>
            <li class="tabCot" style="display: list-item;">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="4" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin đầu tư bền vững - Ngày {$arrTSI.date}</td>
                  </tr>
                  <tr>
                    <td align="center" class="title">Tài sản ròng</td>
                    <td align="center" class="title">Tổng số lượng ĐVĐT</td>
                    <td align="center" class="title">Giá 1 ĐVĐT</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="title" align="center" style="text-align: center; vertical-align: middle;" >{format_number number=$arrTSI.taisan}</td>
                    <td class="title" align="center" style="text-align: center; vertical-align: middle;">{format_number number=$arrTSI.khoiluong}</td>
                    <td class="title" align="center" style="text-align: center; vertical-align: middle;">{format_number number=$arrTSI.giadvdt}</td>
                    <td align="center" width="145px" style="text-align: center; vertical-align: middle;">
                     {if $cmt}<button class="button2" width="120px"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt mua</a></button>{else}<button class="button2" width="120px"><a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=userinfo" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt mua</a></button>{/if}
                     
                    </td>
                  </tr>
                </table>
            
            
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin Tài khoản nhà đầu tư - {$MemberName}</td>
                  </tr>
                  <tr>
                    <td>Ngày mua</td>
                    <td>Số hợp đồng</td>
                    <td>Số lượng ĐVĐT</td>
                    <td>Giá mua 1 ĐVĐT</td>
                    <td>Tổng giá trị mua</td>
                    <td>Lãi/ lỗ</td>
                    <td>%</td>
                    <td></td>
                  </tr>
                  {foreach key=key item=item from=$arrUserorder}
                    {if $item.model>0}
                      <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
                        <td class="title" style="text-align: center; vertical-align: middle;">{$item.date_create}</td>
                        <td class="title" style="text-align: center; vertical-align: middle;">{$item.name}</td>
                        <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.model}</td>
                        <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.price}</td>
                        <td class="title" align="right" style="text-align: center; vertical-align: middle;">{format_number number=$item.price_old}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; text-align: center; vertical-align: middle;" {else} style="color:#FF0000" {/if}>{format_number number=($arrTSI.giadvdt-$item.price)*$item.model}</td>
                        <td class="title" align="right" {if ($arrTSI.giadvdt-$item.price)>0} style="color:#0000CC; text-align: center; vertical-align: middle;" {else} style="color:#FF0000; text-align: center; vertical-align: middle;" {/if}>{format_number2 number=((($arrTSI.giadvdt-$item.price)*$item.model)/$item.price_old*100)}%</td>
                        <td align="center" width="145px" style="text-align: center; vertical-align: middle;">  
                        <button class="button1" width="120px">
                        {if $ngayban=='1'}
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_sell&id={$key}&loai=0" rel="modal:open" class="title" style="font-size:14px; color:#006633">Đặt bán</a>
                        {else}
                        <a href="#" onClick="alert('Quý khách vui lòng đặt lệnh vào khoảng thời gian từ  0h ngày Thứ 2 đến 0h ngày thứ 5 hàng tuần')" class="title" style="font-size:14px; color:#006633">Đặt bán</a>
                        {/if}
                        </button></td>
                      </tr>
                      {/if} 
                   {/foreach}
                </table>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Giao dịch mua</div>
                	<div style="padding:5px">{userxacthucmua456}</div>
                </div>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Giao dịch bán</div>
                	<div style="padding:5px">{userxacthucban456}</div>
                </div>
                <div class="row">
                	<div class="title" style="text-transform:uppercase; font-size:14px; padding-left:20px">Thông tin tài khoản giới thiệu</div>
                	<div style="padding:5px">{usergioithieu456}</div>
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
                	<div style="padding-top:10px">{hieuquabv}</div>
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
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(111456)">Báo cáo đầu tư tuần</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(111456)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
                 </div>
                <div id="111456" style="display:none; padding:10px">  
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="topicContent"><h1>Danh mục đầu tư</h1></div>
                        <div>
                            {inveslistList idF=655}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">    
                        <div class="topicContent"><h1>Báo cáo NAV</h1></div>
                        <div>
                            {inveslistList idF=656}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="topicContent"><h1>Báo cáo hoạt động đầu tư</h1></div>
                        <div>
                            {product_list idF=658}
                        </div>
                    </div>
                </div>
                
                <div style="padding:10px;"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(112456)">Báo cáo đầu tư tháng</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(112456)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
                 </div>
                <div id="112456" style="display:none; padding:10px">  
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
            <div style="padding-top:10px; padding-bottom:10px"> 
                              	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#014922">
                      <tr>
                        <td style="padding:5px; " width="100%">
                            <span  class="inveslist" style="cursor:pointer; color:#FFFFFF" onClick="JavaScript:dropCategory(113)">Thông tin sở hữu</span>
                        </td>  
                        <td nowrap="nowrap"><button class="button2"><span  class="content" style="cursor:pointer;" onClick="JavaScript:dropCategory(113)">Chi tiết</span></button>
                        </td>      
                        <td style="padding:5px;  color:#FFFFFF" class="collapse-icon" nowrap="nowrap"> +</td>
                      </tr>
                    </table>
              </div>
                 
            <div id="113" style="display:none; padding:10px">
                <div>{$ndtsohuu}</div>
            	<div class="row" style="-webkit-overflow-scrolling: touch; overflow: auto;">
                 <iframe src="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$ndtsohuupdf}" width="100%" height="600px"></iframe>
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