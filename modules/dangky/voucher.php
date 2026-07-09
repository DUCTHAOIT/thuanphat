<?php
	global $db,$lang;
	$voucher=getParam(voucher);
	$price=getParam(price);
	$sql="SELECT * FROM sys_voucher WHERE (name='$voucher')";	
	$rs=$db->Execute($sql);	
	$loai=$rs->fields("loai");
	
	if($rs->fields("loai")){
		if($rs->fields("trangthai")=='0'){
			$tong=$price*(100-$loai)/100;
			echo number_format($tong, 0, '.', ',')." đ";
			echo '<input type="hidden" id="inputtong" name="tong" value="'.$tong.'" />';
		}else{
			echo number_format($price, 0, '.', ',')." đ";
			echo '<input type="hidden" id="inputtong" name="tong" value="'.$price.'" />';
		}
	}else{
		echo number_format($price, 0, '.', ',')." đ";
		echo '<input type="hidden" id="inputtong" name="tong" value="'.$price.'" />';
	}
	
	
?>
