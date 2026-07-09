<?php
	global $db,$lang;
	
	$pol_id = getParamPost("pol_id");
	
	$sql = "UPDATE polls
						   SET pol_hits = (pol_hits + 1)
						   WHERE pol_id = ".$pol_id."";
	$rs=$db->Execute($sql);		 
	header("location: " .$_SERVER['HTTP_REFERER']."");
?>