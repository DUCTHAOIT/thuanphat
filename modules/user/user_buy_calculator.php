<?php
	global $db, $lable;
	$giatri=getParam("giatri");
	$giadvdt=getParam("giadvdt");	
	$soxuatconlai=getParam("soxuatconlai");
	$conlai=$soxuatconlai-$giatri;
	$tong=$giatri*$giadvdt;
		echo '<input type="hidden" name="conlai" value="'.$conlai.'" />';
	if(($conlai)<0){
		echo "<div >";
		echo "<font style=\"color:#FF0000\">Bạn không được đăng ký quá số xuất còn lại</font>";
		echo "</div>";
	}else{
		echo '<input type="hidden" name="tong" value="'.$tong.'" />';
		echo "<div >";
		echo "<font style=\"color:#FF0000\">".number_format($tong, 0, '.', ',')."đ</font>";
		echo "</div>";
	}
	
?>