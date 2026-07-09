<?php
	global $db, $lable;
	$soluong=getParam("soluong");
	$soluongban=getParam("soluongban");	
	
	if($soluongban>$soluong){
		echo "<font style=\"color:#FF0000\">B?n không th? bán</font>";
	}	
?>