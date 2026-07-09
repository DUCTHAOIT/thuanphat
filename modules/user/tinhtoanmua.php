<?php
	global $db, $lable;
	$giatri=getParam("giatri");
	$giadvdt=getParam("giadvdt");	
	
	$tong=$giatri/$giadvdt;
	echo "<div >";
	echo "<font style=\"color:#FF0000\">".number_format($tong, 0, '.', ',')."đ</font>";
	echo "</div>";
	
?>