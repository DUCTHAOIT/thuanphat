<?php
$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&5=5) AND (module='product') ORDER BY sort";
$rs = $db->Execute($sql);
if (!$rs->RecordCount()) return;
?>
<script type="text/javascript" src="../../js/menudrop/jquery.fixedMenu.js"></script>
<link rel="stylesheet" type="text/css" href="../../js/menudrop/fixedMenu_style1.css" />
<script>
$('document').ready(function(){
	$('.menu').fixedMenu();
});
</script>
<div class="menu">
         <ul>
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
	$j==1;	
	if($arr[$key]){
	?>
		 
         <li id="center<?php echo $key;?>"><a  href="#"><img src="../../theme_images/menu/topdrop.gif" />&nbsp;</a>
         	<ul style="background-color:#efefef; padding-bottom:10px; z-index:8999">
            	<?php 
				foreach($arr[$key] as $k=>$v){
				?>
					<li  style="width:150px; padding-left:10px;"><a  style="text-decoration:none;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>	</li>			
				<?php
					
				  }
				?>
             </ul>
          </li>      
                
        		
		<?php
	$j=$j+1;
	}else{?>
		 <li id="center<?php echo $key;?>"><a id="a<?php echo $key;?>"  style="text-decoration:none" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a></li>
	<?php	
	}		
	$j=$j+1;
	}
	?>	
 </ul>
</div>