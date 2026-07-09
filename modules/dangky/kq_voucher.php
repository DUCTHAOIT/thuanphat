<?php
	$voucher=getParam(voucher);
	$proid=getParam(proid);
	global $db,$lang;
	$sql="SELECT * FROM sys_voucher WHERE (name='$voucher')";	
	$rs=$db->Execute($sql);	
	if($rs->fields("loai")){
		if($rs->fields("trangthai")=='0'){
			echo "giảm ".$rs->fields("loai")." %";
			echo '<input type="hidden" name="khuyenmai" value="'.$rs->fields("loai").'" />';
		}else{
			echo "Mã voucher đã sử dụng";
		}
	}else{
		echo "Mã voucher không tồn tại";
	}
?>
