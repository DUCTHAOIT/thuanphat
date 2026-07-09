<?php 
	include_once("header.php");
	global $smarty, $lable,$arr_info_page,$db;
?>
<script src="<?php echo _DOMAIN_ROOT_URL; ?>/jsfile/jquery.min.js" type="text/javascript"></script>
﻿<script>
	$(function(){
		$(".item_tab").click(function(){
			$(".item_content").fadeOut();
			$("#content_"+$(this).attr('id')).fadeIn();
		})
	});	
		$arrDM = new Array();
		            $arrDM['75'] = new Array('1.875', '20');
                     $arrDM['100'] = new Array('2.5', '20');
                     $arrDM['125'] = new Array('3.125', '20');
                     $arrDM['150'] = new Array('3.75', '20');
                     $arrDM['200'] = new Array('5', '20');
           
		function Cal(){		
			$chieuDay = $("#select_gach").val();
			$dienTich = $("#input_dttuong").val();
			if(!isNaN($chieuDay) && $dienTich !=0  && $dienTich !=''  && !isNaN($dienTich)){
			$dinhMucVuaXay = $arrDM[$chieuDay][0];
			$dinhMucVuaTo = $arrDM[$chieuDay][1];
			$giaGach = 1350000;
			$giaVuaXay = 110000;
			$giaVuaTo = 90000;
			$m3 = $chieuDay * $dienTich / 1000;
			$pallet = Math.ceil($m3 / 1.2);
			$vuaXay = Math.ceil($dinhMucVuaXay * $dienTich/40);
			$vuaTo =  $dinhMucVuaTo * $dienTich/40;
			$thanhTien =($m3 * $giaGach) + ($vuaXay * $giaVuaXay) + ( $vuaTo * $giaVuaTo);
			$chiPhi = $thanhTien / $dienTich;
			$("#m3").text(formatCurrency($m3));
			$("#pallet").text(formatCurrency($pallet));
			$("#vuaxay").text(formatCurrency($vuaXay));
			$("#vuato").text(formatCurrency($vuaTo));
			$("#tongchiphi").text(formatCurrency(Math.round($thanhTien)));
			$("#chiphi").text(formatCurrency(Math.round($chiPhi)));
			} else{
				$("#m3").text("000");
				$("#pallet").text("000");
				$("#vuaxay").text("000");
				$("#vuato").text("000");
				$("#tongchiphi").text("000");
				$("#chiphi").text("000");
			}		
		}
		function formatCurrency(num) 
		{
			num = num.toString().replace(/\$|\,/g,'');
			if(isNaN(num))
			num = "0";
			sign = (num == (num = Math.abs(num)));
			num = Math.floor(num*100+0.50000000001);
			num = Math.floor(num/100).toString();
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
				num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
			return (((sign)?'':'-') + num);
		}
		
		function isNumberKey(evt)
		 {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			 return true;
		 }

</script>

<style>
.item_content {
	display: none
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="topic" align="center" style="padding:10px; font-size:20px; color:#000000"><?php if($lang=='vn'){ echo "Dự toán chi phí vật liệu"; }else{ echo "COST ESTIMATES";}?></td>
  </tr> 
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10"  style="border:2px solid #fa5e2d; background-color:#fbead8">
  <tr>
  	<td colspan="4"><img src="../../images/spacer.gif" height="5px" width="1px" /></td>
  </tr>
  <tr>
    <td class="title" align="right">
    	<div><?php if($lang=='vn'){ echo "Diện tích tường cần xây"; }else{ echo "Wall area needs tobe built";}?>:</div>
        <div><?php if($lang=='vn'){ echo "(ĐVT: m2)"; }else{ echo "(m2)";}?></div>
    </td>
    <td >
    	<input style="width:180px; height:35px;" type="text" id="input_dttuong" class="text"
	onkeypress="return isNumberKey(event)" name="key" onchange="Cal()"
	onkeyup="Cal()" onblur="if (this.value=='') this.value='<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>';"
	onfocus="if (this.value=='<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>') this.value='';" value="<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>">    </td>
    <td align="right" class="title">
    	<div><?php if($lang=='vn'){ echo "Chiều dày gạch"; }else{ echo "Brick thickness";}?>:</div>
        <div><?php if($lang=='vn'){ echo "(ĐVT: mm)"; }else{ echo "(mm)";}?></div>
     </td>
    <td>
    	<select style="width:180px; height:35px;" name="" id="select_gach"
	onchange="Cal()">
	<option><?php if($lang=='vn'){ echo "Vui lòng chọn"; }else{ echo "Please select";}?></option>
								
	<option value="75">75</option>					
	
	<option value="100">100</option>					
	
	<option value="125">125</option>					
	
	<option value="150">150</option>					
	
	<option value="200">200</option>					
				
	
</select>
    </td>
  </tr>
 
  <tr>
  	<td colspan="4">
    	
<table border="0" cellpadding="2" cellspacing="2" width="100%">
	<tr>
		<td width="360px"><?php if($lang=='vn'){ echo "Số m<sup>3</sup> Gạch"; }else{ echo "Number m<sup>3</sup> of Brick";}?></td>
		<td class="result" id="m3" width="150px">000</td>
		<td width="100px">m<sup>3</sup></td>
	</tr>
	<tr>
		<td><?php if($lang=='vn'){ echo "Số pallet Gạch (1pallet = 1.2m<sup>3</sup>)"; }else{ echo "Number pallet of Brick (1pallet = 1.2m<sup>3</sup>)";}?></td>
		<td class="result" id="pallet">000</td>
		<td>pallet</td>
	</tr>
	<tr>
		<td><?php if($lang=='vn'){ echo "Số bao Vữa xây(40kg/bao)"; }else{ echo "Number of cement (40kg/bag)";}?></td>
		<td class="result" id="vuaxay">000</td>
		<td><?php if($lang=='vn'){ echo "bao"; }else{ echo "bag";}?> </td>
	</tr>
    <!--
	<tr>
		<td>Số bao Vữa tô(40kg/bao)</td>
		<td class="result" id="vuato">000</td>
		<td>bao</td>
	</tr>
    -->
	<tr>
		<td><?php if($lang=='vn'){ echo "Chi phí Nguyên vật liệu / m<sup>2</sup> tường"; }else{ echo "Material Costs/ m<sup>2</sup> wall";}?></td>
		<td class="result" id="chiphi">000</td>
		<td>vnđ</td>
	</tr>
	<tr>
		<td style="height: 60px"><?php if($lang=='vn'){ echo "Tổng chi phí Nguyên vật liệu"; }else{ echo "Total cost of materials";}?></td>
		<td class="result" id="tongchiphi">000</td>
		<td>vnđ</td>
	</tr>
	</table>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td style="padding:10px">
    <?php if($lang=='vn'){?>
    <div class="title">
    <div class="title" style="color:#FF0000">Ghi chú:</div>
    <p>Giá trên đã bao gồm VAT 10%.</p>
    <p>Khối lượng vữa tô tính cho 1 mặt, độ dày 10mm.</p>
    <p>Giá trên chưa bao gồm giá vận chuyển.</p>
    <p>Địa chỉ Nhà máy: xã Kim Bình, huyện Kim Bảng, tỉnh Hà Nam</p>
    <p>Giá trên chỉ mang tính tham khảo, vui lòng liên hệ để biết thêm chi tiết.</p>
    </div>

	<?php }else{?>
    <div class="title">  
    <p>The above price included 10% VAT. </p>
    <p>Volume of cement calculated for one side, 10mm thickness.</p>
    <p>The price excluded shipping cost.</p>
    <p>Factory Address: Kim Binh Commune, Kim Bang District, Ha Nam Province </p>
    <p>The price for reference only, please contact us for more details.</p>
    </div>
    
    <?php }?>
    </td>
</tr>
</table>

<?php 
	include_once("footer.php");
?>