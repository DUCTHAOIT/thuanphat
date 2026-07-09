<?php
	function getBasketList($limit,$pageID=0){
		global $db;
		if($limit=="all") $sql="SELECT *, DATE_FORMAT(sdate, '".format_date()."') as sdate FROM sys_order ORDER BY id DESC";
		else  $sql="SELECT *, DATE_FORMAT(sdate, '".format_date()."') as sdate FROM sys_order ORDER BY id DESC LIMIT $pageID,15";	
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	function getDetailBasket($basketID){		
		global $db;
		$sql="SELECt * FROM sys_order_detail WHERE basketID=$basketID";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
?>