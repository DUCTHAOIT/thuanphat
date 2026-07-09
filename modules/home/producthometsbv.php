<?php
function producthometsbv(){
	global $db,$lang;
	?>    
  
	  <ul class="report__list">          
		 <?php
		 	$sql="SELECT sys_product.*, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, TO_DAYS(sys_product.date_create) as today, sys_function.htaccess as url";
			$sql.=" FROM sys_product,sys_function";
			$sql.=" WHERE (sys_product.catID =  '658') AND (sys_product.catID=sys_function.id) AND (sys_product.ctrl&1=1)";
			
			$sql.=" ORDER BY";
			$sql.=" today DESC LIMIT 0,10";
			
			//$sql="SELECT * FROM sys_product WHERE (sys_product.catID = ".$rs->fields("id").") ORDER BY date_create DESC LIMIT 0,4";		
			//$sql="SELECT sys_product.*,sys_function.htaccess FROM sys_product,sys_function WHERE (sys_function.ctrl&1=1) AND (sys_product.ctrl&1=1)  AND (sys_function.module='product') AND (sys_product.catID = sys_function.id) AND ((sys_function.parent=".$rs->fields("id").") OR (sys_function.id=".$rs->fields("id").")) ORDER BY sys_product.date_create DESC LIMIT 0,5";		
			$arr_product=$db->GetAssoc($sql);
			if(count($arr_product)){
			$i=0;
			foreach($arr_product as $k=>$v){
			?>
            <li>
                <h5><?php echo $v["name"]; ?></h5>
                <a href="<?php echo _DOMAIN_ROOT_URL."/lib/".$v["pdf"]; ?>" class="btn_download flex-center" target="_blank">Tải về</a>
            </li>
			<?php 
				$i=$i+1;
				}	
		  	}
		  ?>
  </ul>
<?php	
	}
?>