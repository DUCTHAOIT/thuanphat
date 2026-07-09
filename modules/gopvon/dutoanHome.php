<?php 
	function dutoanHome(){
	global $smarty, $lable,$arr_info_page,$db,$lang;
?>
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

<table width="100%" height="80px" border="0" cellspacing="5" cellpadding="0" style="background-color:#f55d2d">
<tr>
 	<td rowspan="2" style="padding:10px; border-right:1px solid #FFFFFF">
    	<table width="150px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="topic" style="font-size:20px" nowrap="nowrap" align="center"><?php if($lang=='vn'){ echo "Dự toán chi phí"; }else{ echo "COST ESTIMATES";}?></td>
          </tr>
          <tr>
            <td class="content" style="font-size:11px; color:#FFFFFF" nowrap="nowrap" align="center"><?php if($lang=='vn'){ echo "(Giá thực tế có thể khác so với dự toán)"; }else{ echo "(Actual cost may be different from the estimated cost)";}?></td>
          </tr>
        </table>

    </td>
	<td class="content" style="color:#FFFFFF; padding:10px; padding-bottom:5px" width="25%">
    	<?php if($lang=='vn'){ echo "Diện tích tường cần xây (m2)"; }else{ echo "Wall area needs tobe built (m2)";}?>:    </td>
    <td class="content" style="color:#FFFFFF; padding:10px; padding-bottom:5px" width="25%">
    	<?php if($lang=='vn'){ echo "Chiều dày gạch (mm)"; }else{ echo "Brick thickness (mm)";}?>:    </td>
    <td colspan="2"  class="content" style="color:#FFFFFF; padding:10px; padding-bottom:5px" width="25%"><?php if($lang=='vn'){ echo "Tổng chi phí Nguyên vật liệu"; }else{ echo "Total cost of materials";}?></td>	
</tr>
<tr valign="top">
 <td class="content" style="color:#FFFFFF; padding:10px; padding-top:0px" width="25%">
<input style="width:180px; height:30px;" type="text" id="input_dttuong" class="text"
	onkeypress="return isNumberKey(event)" name="key" onchange="Cal()"
	onkeyup="Cal()" onblur="if (this.value=='') this.value='<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>';"
	onfocus="if (this.value=='<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>') this.value='';" value="<?php if($lang=='vn'){ echo "Nhập số"; }else{ echo "Enter the number";}?>"> </td>
<td class="content" style="color:#FFFFFF; padding:10px; padding-top:0px" width="25%">
	<select style="width:180px; height:30px;" name="" id="select_gach"
	onchange="Cal()">
	<option><?php if($lang=='vn'){ echo "Vui lòng chọn"; }else{ echo "Please select";}?></option>
								
	<option value="75">75</option>					
	
	<option value="100">100</option>					
	
	<option value="125">125</option>					
	
	<option value="150">150</option>					
	
	<option value="200">200</option>					
</select></td>
<td class="content" style="color:#FFFFFF; padding:10px; padding-top:0px" width="25%">
	<table class="table" border="0" cellpadding="2" cellspacing="2" width="100%">		
    <tr height="30px">
		<td class="result" id="tongchiphi" width="100%" style="background-color:#FFFFFF">000</td>
		<td style="background-color:#FFFFFF">VNĐ</td>
	</tr>
</table></td>
</tr>
</table>
<?php 	
	}
?>