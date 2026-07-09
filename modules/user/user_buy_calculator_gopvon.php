<?php
	global $db, $lable;
	$giatri=getParam("giatri");
	$sotienmotcophan=getParam("sotienmotcophan");	
	$sotientoithieu=getParam("sotientoithieu");
	$sotientoida=getParam("sotientoida");
	$tong=$giatri/$sotienmotcophan;
	
		echo '<input type="hidden" name="tong" value="'.$tong.'" />';
		echo "<div >";
		echo "<font style=\"color:#FF0000\">".number_format($tong, 0, '.', ',')." cổ phần</font>";
		echo "</div>";
	
	
?>