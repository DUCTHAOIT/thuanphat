<?php	
	$fid=getParam("fid");
	$id_product=getParam("id_product");	
	if(!$fid) return;
		
	if($id_product){
		$sql="SELECT * FROM sys_product WHERE id='$id_product'";
		$rs=$db->Execute($sql);
		$search_criteria=$rs->fields("search_criteria");
		$search_criteria=explode(":", $search_criteria);		
		if($search_criteria){
			foreach($search_criteria as $keys=>$values){
				$arr_search_criteria[$values]=$values;
			}
		}
	}	
	loadClass("menuLevel");
	$obj=new menuLevel();
	$obj->sql="SELECT * FROM sys_product_search WHERE catID='$fid' ORDER BY order_number";
	$arr=$obj->orderMenu();		
	
	if(!$arr) return;
	
	foreach($arr as $key=>$value){
		if($value["root"]==true){
			$output.='<div><b>'.$value["name"].'</b></div>';
		}else{
			if($arr_search_criteria[$value["id"]])	
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="search_criteria[]" value="'.$value["id"].'" checked="checked" />'.$value["name"].'</div>';
			else 
				$output.='<div style="padding-bottom:5px; padding-top:5px; padding-left:15px"><input type="checkbox" name="search_criteria[]" value="'.$value["id"].'" />'.$value["name"].'</div>';
		}
	}	
	echo $output;
?>