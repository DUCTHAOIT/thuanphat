<?php
$idF=getparamFID(getParam(idF),false);
$sql="SELECT sys_function.*,COUNT(sys_product.id) as sosp FROM sys_function,sys_product WHERE (sys_function.lang='$lang') AND (sys_function.ctrl&5=5) AND (sys_function.module='product') AND (sys_function.id=sys_product.catID) GROUP BY sys_function.id ORDER BY sys_function.sort LIMIT 0,6";

$rs = $db->Execute($sql);
if (!$rs->RecordCount()) return;
?>
<table  width="100%" border="0" cellpadding="0" cellspacing="0"> 
	<?php	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
			$rs->MoveNext();		
	}
	foreach($arr[0] as $key=>$value){
		if($arr[$key]){// menu cap 1 co menu con
					// hien thi menu cap 1 khong co link
					
	?>				
											
                   
						 <tr height="30px">
							<?php if($idF=='287'){ ?>
                            <td  nowrap="nowrap" align="center" id="left<?php echo $key;?>"><a style="font-weight:bold; text-transform:none; font-size:13px;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"] ?>"  class="title" id="aleft<?php echo $key ?>">Tất cả</a></td>
                            <?php }else{?>
                            <td  nowrap="nowrap" align="center"><a style="font-weight:bold; text-transform:none; font-size:13px;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"] ?>"  class="title" >Tất cả</a></td><div style="width:0px; height:0px; display:none" id="left<?php echo $key;?>"><a href="#"  id="aleft<?php echo $key ?>"></a></div>
                            <?php }?>
						
								<?php 
									foreach($arr[$key] as $k=>$v){
									// hien thi menu cap 2
									if($arr[$k]){//menu cap 2 khong co link
								?>
									
								<?php		
									}else{//hien thi menu cap 2 co link
								?>
																	
								<td  nowrap="nowrap" align="center"  id="left<?php echo $k;?>" style="padding:10px; padding-right:20px; font-size:12px; font-weight:bold;"><a  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"] ?>" class="title" style="font-size:12px; text-transform:none" id="a<?php echo $k ?>" ><?php echo $arr[$key][$k]["name"] ?> (<?php echo $arr[$key][$k]["sosp"] ?>)</a></td>
									
								<?php
									}	
								}	
								?>														
						</tr>
										
			<?php }else{ // menu cap 1 khong co link?>
				
					<?php 
				}			
		}
		
?>
</table>