<ul class="navbar-nav">
<?php	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
		$rs->MoveNext();
	}
	?>
	<li><a id="a<?php echo $key;?>"  href="<?php echo _DOMAIN_ROOT_URL; ?>/"><i class="fa fa-home" style="font-size:18px"></i></a></li>
    <?php
	foreach($arr[0] as $key=>$value){
	$j==1;	
	if($arr[$key]){
	?>
		 
         <li><a id="a<?php echo $key;?>" href="#"><?php echo $arr[0][$key]["name"];?></a>
         	<ul  class="sub-menu">
            	<?php 
				foreach($arr[$key] as $k=>$v){
				if($arr[$k]){//menu cap 2 khong co link
								// hien thi menu cap 2
				?>
					 <li><a   href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>	
                     
                    <ul  class="sub-menu">
						<?php 
						foreach($arr[$k] as $k1=>$v1){// hien thi menu cap 3
						?>
						<li><a href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$k][$k1]["htaccess"] ?>"  ><?php echo $arr[$k][$k1]["name"]; ?></a></li>
						<?php					  
						  }
						?>
                     </ul>   
					</li>	
				  <?php
					}else{
					?>
					<li><a  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>	</li>			
				<?php
					}					
				  }
				?>
             </ul>
          </li>      
                
        		
		<?php
	$j=$j+1;
	}else{?>
		 <li><a id="a<?php echo $key;?>"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a></li>
	<?php	
	}		
	$j=$j+1;
	}
	?>	
 </ul>