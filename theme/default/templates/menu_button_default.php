<?php 
	function menu_button_default(){
?>

<?php 
	global $themeName, $lang, $db;	
	$sql="SELECT * FROM sys_function";
	$sql.=" WHERE ctrl&32=32 AND ctrl&1=1 AND (lang='$lang')";
	$sql.=" ORDER BY sort ASC";
	$rs = $db->Execute($sql);
	if (!$rs->RecordCount()) return;
	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
		$rs->MoveNext();
	}
	?>
    	
	<?php
	foreach($arr[0] as $key=>$value){
	$j==0;	
	if($i==4){
		$i=0;
		
	}	
	if($arr[$key]){
	?>
		 <div style="padding-top:20px">
         	<h4><?php echo $arr[0][$key]["name"];?></h4>
			
			<ul class="link">	
			<?php 
			foreach($arr[$key] as $k=>$v){
			
			?>
				<li><a class="content" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" style="color:#FFFFFF" ><?php echo $arr[$key][$k]["name"];?></a></li>
			<?php
			
			  }
			?>
            </ul>			
		</div>
		<?php
	
	}else{?>
		<div >
			<a class="title" style="text-decoration:none; color:#FFFFFF; font-size:0.8rem" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a>			
		</div>
		
	<?php	
	}	
	$i++;	
	$j=$j+1;
	}
	?>	
<?php 
}	
?>