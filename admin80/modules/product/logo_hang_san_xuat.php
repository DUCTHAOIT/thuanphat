<?php	
	$id_hang_san_xuat=getParam("id_hang_san_xuat");	
	if(!$id_hang_san_xuat) return;
		
	$sql="SELECT logo FROM hang_san_xuat WHERE id='$id_hang_san_xuat'";
	$rs=$db->Execute($sql);
	
	if(strlen($rs->fields("logo")) >0){
		$output = '<img src="'._DOMAIN_ROOT_URL.'/images/logo/'.$rs->fields("logo").'" />';
		echo $output;
	}
	
?>