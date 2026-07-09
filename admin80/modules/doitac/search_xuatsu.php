<?php	
	$fid=getParam("fid");
	$id_product=getParam("id_product");	
	if(!$fid) return;
		
	if($id_product){
		$sql="SELECT * FROM sys_product WHERE id='$id_product'";
		$rs=$db->Execute($sql);
		$xuatsu=$rs->fields("xuatsu");
		$xuatsu=explode(":", $xuatsu);		
		if($xuatsu){
			foreach($xuatsu as $keys=>$values){
				$arr_xuatsu[$values]=$values;
			}
		}
	}	
	
	$sql="SELECT * FROM xuat_su ORDER BY sort ASC";
	$arr=$db->GetAssoc($sql);
	
	if(!$arr) return;
	
	foreach($arr as $key=>$value){
		
			if($arr_xuatsu[$value["id"]])	
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="xuatsu[]" value="'.$value["id"].'" checked="checked" />'.$value["name"].'</div>';
			else 
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="xuatsu[]" value="'.$value["id"].'" />'.$value["name"].'</div>';
	
	}	
	echo $output;
?>