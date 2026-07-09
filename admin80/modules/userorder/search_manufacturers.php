<?php	
	$fid=getParam("fid");
	$id_product=getParam("id_product");	
	if(!$fid) return;
		
	if($id_product){
		$sql="SELECT * FROM sys_product WHERE id='$id_product'";
		$rs=$db->Execute($sql);
		$manufacturers=$rs->fields("manufacturers");
		$manufacturers=explode(":", $manufacturers);		
		if($manufacturers){
			foreach($manufacturers as $keys=>$values){
				$arr_manufacturers[$values]=$values;
			}
		}
	}	
	$sql="SELECT * FROM hang_san_xuat ORDER BY sort ASC";
	$arr=$db->GetAssoc($sql);	
	
	if(!$arr) return;
	
	foreach($arr as $key=>$value){
		
			if($arr_manufacturers[$value["id"]])	
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="manufacturers[]" value="'.$value["id"].'" checked="checked" />&nbsp;<img src="'._DOMAIN_ROOT_URL.'/images/logo/'.$value["logo"].'" width="20px" />&nbsp;'.$value["name"].'</div>';
			else 
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="manufacturers[]" value="'.$value["id"].'" />&nbsp;<img src="'._DOMAIN_ROOT_URL.'/images/logo/'.$value["logo"].'" width="20px" />&nbsp;'.$value["name"].'</div>';
		
	}	
	echo $output;
?>