<?php 
	function menu_button_cuahang(){
?>

<?php 
	global $themeName, $lang, $db;	
	$sql="SELECT * FROM sys_function";
	$sql.=" WHERE ctrl&32=32 AND ctrl&1=1 AND (lang='$lang') AND (module='worldwide')";		
	$sql.=" ORDER BY sort ASC LIMIT 0,17";
	$rs = $db->Execute($sql);
	if (!$rs->RecordCount()) return;
	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
<?php	
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
	if($i==5){
		$i=0;
		echo "</tr><tr>";
	}	
	if($arr[$key]){
	?>
		 
			<div align="left" style="padding-bottom:5px;" class="titlefooter"><h2><?php echo $arr[0][$key]["name"];?></h2></div>
			<tr>
			<?php 
			foreach($arr[$key] as $k=>$v){
				if($j==2){
					$j=0;					
					echo "</tr><tr>";
				}
			?>
				<td nowrap="nowrap" valign="top"  ><div style="padding-top:10px; padding-left:10px;"><img src="<?php echo _DOMAIN_ROOT_URL; ?>/theme_images/icon.png" border="0" />&nbsp;<a class="contentfooter" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a></div></td>		
			<?php
				$j++;
			  }
			?>
		</tr> 
        <tr>
        	<td>&nbsp;</td>
            <td style="padding-top:5px; padding-left:10px"  align="left"><a href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>" class="content" style="float:left; color:#f40008">Xem tất cả</a></td>
         </tr>
		<?php
	
	}
	$i++;	
	$j=$j+1;
	}
	?>	
</table>
<?php 
}	
?>