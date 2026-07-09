{literal}
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td class="yui-skin-sam" style="padding-top:10px">
    <div id="demo" class="yui-navset">   
         <ul class="yui-nav">   
             <li class="selected"  style="font-size:13px; margin:0"><a href="#tab4"><em>ĐT tăng trưởng TSTT</em></a></li>  
             <li  style="font-size:13px; margin:0"><a href="#tab5"><em>ĐT bền vững TSBV</em></a></li>
         </ul>               
         <div class="yui-content">   
             <div id="tab4">
                   <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="5" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin đầu tư tăng trưởng - Ngày {$arrTSI.date}</td>
                  </tr>
                  <tr>
                    <td align="center" class="td" style="font-size:12px"><strong>Tài sản ròng</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Tổng số lượng ĐVĐT</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Giá 1 ĐVĐT</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Tăng/giảm (%)</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Lệnh</strong></td>
                  </tr>
                  <tr height="60px">
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI.taisan}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI.khoiluong}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI.giadvdt}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px">{if (($arrTSI.giadvdt-$arrTSITangGiam.giadvdt))>0}<strong style="color:#0000CC">{else}<strong style="color:#FF0000">{/if}{format_number2 number=($arrTSI.giadvdt-$arrTSITangGiam.giadvdt)/$arrTSITangGiam.giadvdt*100}%</strong></td>
                    <td align="center" nowrap="nowrap"  class="buttonlogin">
                    {if $username}<a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI.id}" rel="modal:open" class="title" style="color:#FFFFFF; font-size:14px">Đặt mua</a>{else}<a  class="title" style="color:#FFFFFF; font-size:14px" href="javascript:alert('Bạn cần đăng nhập thể thực hiện chức năng này')">Đầu tư</a>{/if}
                    </td>
                  </tr>
                </table>							
             </div>   
             <div id="tab5">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
                  <tr>
                    <td colspan="5" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin đầu tư Bền Vững - Ngày {$arrTSI.date}</td>
                  </tr>
                  <tr>
                    <td align="center" class="td" style="font-size:12px"><strong>Tài sản ròng</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Tổng số lượng ĐVĐT</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Giá 1 ĐVĐT</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Tăng/giảm (%)</strong></td>
                    <td align="center" class="td" style="font-size:12px"><strong>Lệnh</strong></td>
                  </tr>
                  <tr height="60px">
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI2.taisan}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI2.khoiluong}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px"><strong>{format_number number=$arrTSI2.giadvdt}</strong></td>
                    <td class="td" style="text-align: center; vertical-align: middle; font-size:14px">{if (($arrTSI2.giadvdt-$arrTSITangGiam2.giadvdt))>0}<strong style="color:#0000CC">{else}<strong style="color:#FF0000">{/if}{format_number2 number=($arrTSI2.giadvdt-$arrTSITangGiam2.giadvdt)/$arrTSITangGiam2.giadvdt*100}%</strong></td>
                    <td align="center" nowrap="nowrap"  class="buttonlogin">
                    {if $username}<a href="{$smarty.const._DOMAIN_ROOT_URL}?m=user&f=user_buy&id={$arrTSI2.id}" rel="modal:open" class="title" style="color:#FFFFFF; font-size:14px">Đặt mua</a>{else}<a style="color:#FFFFFF; font-size:14px"  class="title" href="javascript:alert('Bạn cần đăng nhập thể thực hiện chức năng này')">Đầu tư</a>{/if}
                    </td>
                  </tr>
                </table>
             </div>
         </div>
     </div>
     </td>
   </tr>
   </table>