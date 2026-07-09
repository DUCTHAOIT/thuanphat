<?php
	function getAccessHistory(){
		global $db;
		$sql="SELECT *, DATE_FORMAT(date,'".format_date()." %H:%i:%p ') as date FROM sys_visitor ORDER BY id DESC LIMIT 0,15";		
		return $db->GetAssoc($sql);
		
	}
?>