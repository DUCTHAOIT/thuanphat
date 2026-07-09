<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>

<link rel="stylesheet"  href="js/tabview2/tab/css/webwidget_tab.css" type="text/css" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type='text/javascript' src='js/tabview2/tab/js/webwidget_tab.js'></script>

<script type="text/javascript">// <![CDATA[
            $(function() {
                $(".webwidget_tab").webwidget_tab({
                    window_padding: '10',
                    head_text_color: '#666',
                    head_current_text_color: '#ffffff'
                });
            });
// ]]></script>


<form name="frmmain" action="?m=gopvon" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addgopvon" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="imgsmall" value="{$arr.img}" />
<input type="hidden" name="imgbig" value="{$arr.img1}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />

<div class="topic">{$Create}</div>

		<table border="0" cellspacing="5" cellpadding="0" width="100%">
	  <tr>
		<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Đầu mục: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;" onchange="technical();">			
		{foreach key=key item=item from=$arrTopicgopvon}
		{if $item.id==$arr.catID}  			
		  <option value="{$key}" selected="selected" >{if $item.level=='1'}&nbsp; &nbsp; {elseif $item.level=='2'}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
		{else}
			<option value="{$key}"  style="padding-left:15px; padding-right:10px">{if $item.level=='1'} &nbsp; &nbsp; {elseif $item.level=='2'}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
		{/if}	
		{/foreach}
		</select>		</td>
	    <td width="25%" rowspan="3" valign="bottom" style="padding-top:10px">
		<div>Ảnh đại diện (kích thước khuyến nghị w:1000px - h:600px)<br />
		  <em style="color:#666666"></em></div>
		<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img src="{$arr.imgs_view}" border="0" style="max-width:300px" /></a></div><label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label>			</td>
	    <!--
        <td width="25%" rowspan="6" valign="bottom" style="padding-top:10px"><div><strong>{$Photo_big_size}</strong><br />
	      <em style="color:#666666">(w: 270px - h: 180px)</em></div>
		<div id="imgbigv"><a href="#" onclick="WindowUpload('imgbig')"><img src="{$arr.imgb_view}" border="0" /></a></div><label style="cursor:pointer" onclick="removeImg2()"><strong>Remove photo</strong></label></td>
        -->
	  </tr>
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Tiêu đề: </td>
		<td><input name="name" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.name}" /></td>
	  </tr>
      <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Tóm tắt</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.promotion}" /></td>
	    </tr>
      
	  <tr>	 
		<td align="right" style="padding-right:10px; text-decoration:line-through" nowrap="nowrap">Giá cũ:</td>
		<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20" value="{$arr.price_old}" /></td>
	  </tr> 
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Giá:</td>
	    <td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20" value="{$arr.price}" /></td>
	  </tr>
      <!--
       
        <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Hãng:</td>
	    <td><input name="delivery" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.delivery}" /></td>
	    </tr> 
         <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Xuất xứ</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.promotion}" /></td>
	    </tr>
      
		
	  <tr> 
	  <tr>  
	  
      -->
      <!--  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Bảo hàng:</td>
	    <td><input name="baohanh" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.baohanh}" /></td>
	    </tr>
         <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Chứng chỉ chất lượng:</td>
	    <td><input name="product_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.product_in}" /></td>
	    </tr>
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Đơn vị:</td>
	    <td><input name="delivery" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.delivery}" /></td>
	    </tr>	
        
       <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Drive mode:</td>
	    <td>
		<select name="dongsp" style="border:1px solid #cccccc;">		
		{foreach key=key item=item from=$arr_dongsp}
		{if $key==$arr.dongsp}  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>	
		</td>
	    </tr>   
       
         <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Rated power :</td>
	    <td>
		<select name="loai" style="border:1px solid #cccccc;">		
		{foreach key=key item=item from=$arr_loai}
		{if $key==$arr.loai}  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>	
		</td>
	    </tr> 
        <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Operating Weight (kg):</td>
	    <td><input name="product_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.product_in}" /></td>
	    </tr>
       -->
	    <!--
         <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">lĩnh vực:</td>
	    <td>
		<select name="linhvuc" style="border:1px solid #cccccc;">		
		{foreach key=key item=item from=$arr_linhvuc}
		{if $key==$arr.linhvuc}  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>	
		</td>
	    </tr> 
       
       
      
	  <tr>	 
		<td align="right" style="padding-right:10px; text-decoration:line-through; color:#FF0000" nowrap="nowrap">{$Price_old}:</td>
		<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20" value="{$arr.price_old}" /></td>
	    </tr>
      
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Price_new}:</td>
	    <td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20" value="{$arr.price}" /></td>
	  </tr>
	
	  
	  <tr>
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Link báo giá:</td>
	    <td><input name="product_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.product_in}" />(http://www.linkwebsite.com)</td>
	    </tr>
	  <tr>
	
	 <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Tình trạng:</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.promotion}" /></td>
	    </tr>
	  
	  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Tình Trạng:</td>
	    <td>
		<select name="tinh_trang" style="border:1px solid #cccccc;">		
		{foreach key=key item=item from=$arr_tinh_trang}
		{if $key==$arr.tinh_trang}  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>	
		</td>
	    </tr>
	 
	     <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">{$Manufacturers}:</td>
	    <td>
		<select name="hang_san_xuat" style="border:1px solid #cccccc;" onchange="logo_hang_san_xuat()">		
		{foreach key=key item=item from=$arr_hang_san_xuat}
		{if $key==$arr.hang_san_xuat}
  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
		<div id="div_logo_hang_san_xuat"></div>
		</td>
	    </tr>
	
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$gopvons_sold_in}:</td>
	    <td><input name="product_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.product_in}" /></td>
	    </tr>	  
	 
	</table>	</td>
    </tr>
	

  	 
  	<tr>
	<td align="right" style="padding-right:10px" nowrap="nowrap">{$gopvon_Focus}</td>
	<td>
	<input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} />
	</td>
	</tr>  
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"></td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
            <td id="filePDFv">
			{if $arr.pdf}<img src="images/_.pdf.gif" />{/if}			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">Upload file</a></td>
          </tr>
        </table></td>
  </tr>--> 
 <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Ghi chú</td>
    <td width="100%" colspan="3"><textarea name="summary" class="textarea" style="height:100">{$arr.summary}</textarea></td>
  </tr>
 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Nội dung: </td>
    <td colspan="3">{viewFckeditor content=$arr.content}</td>
  </tr>
  
  <!--
  
    <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Tiến độ dự án:</td>
    <td  colspan="3">{viewFckeditors contents=$arr.vitri}</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Quy trình & pháp lý: </td>
    <td colspan="3">{viewFckeditor1 content1=$arr.tienich}</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Kết quả hoạt động: </td>
    <td colspan="3">{viewFckeditor2 content2=$arr.chinhsach}</td>
  </tr>
   <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Màu sắc:</td>  
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"> </td>
    <td  colspan="3"><div id="div_manufacturers"></div></td>
  </tr>
 
   <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Kích cỡ:</td>  
  </tr> 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"> </td>
    <td  colspan="3"><div id="div_xuatsu"></div></td>
  </tr>
 -->
  <!--  
     <tr>
        <td align="right" style="padding-right:10px; " nowrap="nowrap" valign="top"></td>
        <td>
        {foreach key=key item=item from=$arr_xuatsu}
        {if $key==$arr.xuatsu}  			
          <div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="xuatsu[]" value="{$item.id}" checked="checked" />{$item.name}</div>
         
        {else}
           <div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="xuatsu[]" value="{$item.id}"  />{$item.name}</div>
        {/if}
        {/foreach}     
        </td>
    </tr>
  <tr>
        <td align="right" style="padding-right:10px; " nowrap="nowrap"></td>
        <td>
        {foreach key=key item=item from=$arr_manufacturers}
        {if $key==$arr.manufacturers}  			
          <div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="manufacturers[]" value="{$item.id}" checked="checked" />&nbsp;<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$item.logo}" width="20px" />	&nbsp;{$item.name}</div>
         
        {else}
           <div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="manufacturers[]" value="{$item.id}"  />&nbsp;<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$item.logo}" width="20px" />&nbsp;{$item.name}</div>
        {/if}
        {/foreach}     
        </td>
    </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"> </td>
    <td  colspan="3"><div id="div_technical"></div></td>
  </tr>
  -->
    <!--
  <tr>
  	<td colspan="4">
    	<div class="webwidget_tab" id="webwidget_tab">
            <div class="tabContainer">
                <ul class="tabHead">
                    <li class="currentBtn" style="margin-right:2px; margin-bottom:2px"><a href="javascript:;"><i class="fa fa-calendar"></i> Thông tin giao dịch</a></li>
                    
                </ul>
            </div>
            <div class="tabBody">
                <ul>
                    <li class="tabCot">
                        <p>
                        	<table width="100%" border="0" cellspacing="5" cellpadding="0">
                              <tr>
                                <td align="right" style="padding-right:10px; " nowrap="nowrap">Diện tích và quy mô:</td>
                                <td width="100%"><input name="tengiaidoan1" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.tengiaidoan1}" /></td>
                                </tr>
                                <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Hình thức đầu tư:</td>
                                <td><input name="hinhthuc1" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.hinhthuc1}" /></td>
                                </tr> 
                                 <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Vốn pháp định</td>
                                <td><input name="tongvondautu1" id="tongvondautu1" type="text" style="width:50%" class="text" maxlength="50" value="{$arr.tongvondautu1}" /></td>
                                </tr>
                              <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Tổng số cổ phần:</td>
                                <td><input name="soxuatdautu1" id="soxuatdautu1" style="width:50%" type="text" class="text" maxlength="50" value="{$arr.soxuatdautu1}" /></td>
                              </tr>
                              <tr>	 
                                <td align="right" style="padding-right:10px;" nowrap="nowrap">Giá trị / 1 cổ phần:</td>
                                <td><input name="sotienmotxuat1" id="sotienmotxuat1" type="text" style="width:50%" class="text" maxlength="50" value="{$arr.sotienmotxuat1}" /></td>
                              </tr>
                              <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Số cổ phần đã bán:</td>
                                <td><input name="soxuatdakeugoi1" id="soxuatdakeugoi1" type="text" style="width:50%" class="text" maxlength="50" value="{$arr.soxuatdakeugoi1}" /></td>
                                </tr>
                                <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Số tiền đầu tư tối thiểu:</td>
                                <td><input name="sotientoithieu" id="sotientoithieu" type="text" style="width:50%" class="text" maxlength="50" value="{$arr.sotientoithieu}" /></td>
                                </tr>
                                 <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Số tiền đầu tư tối đa:</td>
                                <td><input name="sotientoida" id="sotientoida" type="text" style="width:50%" class="text" maxlength="50" value="{$arr.sotientoida}" /></td>
                                </tr> 
                               <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Số lượng cổ đông tối đa:</td>
                                <td><input name="codongtoida" id="codongtoida" type="text" style="width:50%" class="text" maxlength="20" value="{$arr.codongtoida}" /></td>
                                </tr>  
                              
                              
                              <tr>
                                <td align="right" style="padding-right:10px" nowrap="nowrap">Tình trạng dự án:</td>
                                <td><input name="tinhtrangduan1" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.tinhtrangduan1}" /></td>
                                </tr>
                             
                            </table>

                        	
                        </p>
                    </li>
                </ul>
                <div style="clear:both"></div>
            </div>
            
        </div>
    </td>
  </tr>
    -->
  <!-- <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Thông tin hỗ trợ SEO</td>  
  </tr>
  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Title</td>
    <td width="100%" colspan="3"><textarea name="title" class="textarea" style="height:100">{$arr.title}</textarea></td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Description</td>
    <td width="100%" colspan="3"><textarea name="description" class="textarea" style="height:100">{$arr.description}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Keywords</td>
    <td width="100%" colspan="3"><textarea name="keywords" class="textarea" style="height:100">{$arr.keywords}</textarea></td>
  </tr>
  
 
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Mô tả 4: </td>
    <td colspan="3">{viewFckeditor2 content2=$arr.baiviet}</td>
  </tr>
 
 
 <tr>
	<td align="right" style="padding-right:10px" nowrap="nowrap">Hiển thị trên trang chủ:</td>
	<td>
	<input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} />
	</td>
	</tr>
    
    <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Hiển thị giai đoạn:</td>
	    <td>
		<select name="giaidoan" style="border:1px solid #cccccc;">	
		  <option value="1" style="padding-right:10px" {if $arr.giaidoan=='1'} selected="selected" {/if} >&nbsp; &nbsp;Giai đoạn 1</option>
		  <option value="2" style="padding-right:10px" {if $arr.giaidoan=='2'} selected="selected" {/if}>&nbsp; &nbsp;Giai đoạn 2</option>
          <option value="3" style="padding-right:10px" {if $arr.giaidoan=='3'} selected="selected" {/if}>&nbsp; &nbsp;Giai đoạn 3</option>
		</select>
		</td>
	 </tr>
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Thứ tự:</td>
    <td><input type="text" class="text" name="sort" style="width:40" value="{if !$arr.sort}1{else}{$arr.sort}{/if}" /></td>
  </tr>
  
  
   
   <tr>
        <td align="right" style="padding-right:10px; " nowrap="nowrap">Link tư vấn:</td>
        <td><input name="product_in" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.product_in}" /></td>
    </tr>
    <tr>
        <td align="right" style="padding-right:10px; " nowrap="nowrap">Điện thoại liên hệ:</td>
        <td><input name="model" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.model}" /></td>
    </tr> 
  
  <tr>
    <td align="right" style="padding-right:10px">Gán quyền quản trị hợp đồng:</td>
    <td  colspan="3">
     
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
       {foreach key=key item=item from=$arrTopicAdmin}
          <tr>
            <td align="center" class="td">
            <input type="checkbox" value="{$key}" name="groupID[]"  {$item.select}/>
            </td>
            <td class="td title" width="100%">{$item.fullname}</td>
          </tr>
     {/foreach}
     </table>
    </td>
  </tr>
  -->
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Ngày cập nhật: </td>
    <td  colspan="3"><input type="text" name="date" id="date" style="width:20%" class="text" value="{if $arr.date_create}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td  colspan="3"><input type="submit" class="button" value="{$Update}" /></td>
  </tr>
</table>
</form>
{literal}
<script language="Javascript1.2">
	$("#tongvondautu1,#sotienmotxuat1,#chietkhau12,#chietkhau1,#codongtoida,#soxuatdakeugoi1,#sotientoithieu,#sotientoida").on('keyup', function(){
		var n = parseInt($(this).val().replace(/\D/g,''),10);
		$(this).val(n.toLocaleString());
	});
	
	Calendar.setup(
		{
			inputField  : "date",         // ID of the input field
			ifFormat    : "%Y-%m-%d",    // the date format
			button      : "btndate",       // ID of the button
			showsTime	  :	true
		}
	);		
	//
	//
	function removeImg(){
		document.getElementById('imgsmallv').innerHTML="";
		document.frmmain.imgsmall.value="";
	}	
	//	
	function removeImg2(){
		document.getElementById('imgbigv').innerHTML="";
		document.frmmain.imgbig.value="";
	}
	//
	
	//
	//
	function manufacturers(){		
		AjaxRequest.get(
			{
			'url':'?m=gopvon&f=search_manufacturers&fid='+document.frmmain.catID.value + '&id_gopvon=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_manufacturers').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	//
	function xuatsu(){		
		AjaxRequest.get(
			{
			'url':'?m=gopvon&f=search_xuatsu&fid='+document.frmmain.catID.value + '&id_gopvon=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_xuatsu').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function technical(){		
		AjaxRequest.get(
			{
			'url':'?m=gopvon&f=search_criteria&fid='+document.frmmain.catID.value + '&id_gopvon=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_technical').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function logo_hang_san_xuat(){		
		AjaxRequest.get(
			{
			'url':'?m=gopvon&f=logo_hang_san_xuat&id_hang_san_xuat='+document.frmmain.hang_san_xuat.value
			,'onSuccess':function(req){document.getElementById('div_logo_hang_san_xuat').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	manufacturers();
	xuatsu();
	//technical();
	//logo_hang_san_xuat();
</script>
{/literal}