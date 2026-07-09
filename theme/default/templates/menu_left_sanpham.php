<?php
$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&5=5) AND (module='product') ORDER BY sort";
$rs = $db->Execute($sql);
if (!$rs->RecordCount()) return;
?>
<table id=table1 width="100%" border="0" cellpadding="5" cellspacing="0"> 
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
							<td  nowrap="nowrap"  style="padding-top:8px"  class="menuleftoff" id="left<?php echo $key;?>"><a style="text-transform:uppercase; font-weight:bold; font-size:13px;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"] ?>"  class="title" ><?php echo $arr[0][$key]["name"] ?></a></td>     
						</tr>  
                        
						<tr>
							<td align="left" width="100%">
								<table border=0 cellpadding="0" cellspacing="0" width="100%">
								<?php 
									foreach($arr[$key] as $k=>$v){
									// hien thi menu cap 2
									if($arr[$k]){//menu cap 2 khong co link
								?>
									<tr  height="28" >										
										<td align="left" width="100%"  >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr height="30">											
														
                                             <td  nowrap="nowrap" style="border-bottom:1px solid #e1e1e1; font-size:12px;  font-weight:bold;" id="a<?php echo $k ?>" class="menuleftoff">
												<?php echo $arr[$key][$k]["name"] ?>
											</td>                                           
											</tr>
										</table>	
										</td>
									</tr>
									<tr style="background-color:#f2f2f2">
										<td align="left" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">											  
								<?php		
										foreach($arr[$k] as $k1=>$v1){// hien thi menu cap 3
											?>
											<tr height="28">
												<td align="left" style="border-bottom:1px solid #FFFFFF; padding-left:10px" ><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/menu/iconsub.gif" vspace="0" hspace="0" border="0" /></td>												
												<td align="left" nowrap="nowrap" width="100%" style="padding-left:5px;  border-bottom:1px solid #FFFFFF" >
												<a href="<?php  echo _DOMAIN_ROOT_URL."/".$arr[$k][$k1]["htaccess"] ?>" class="content" style="text-decoration:none; color:#000000" id="a<?php echo $k1?>"><?php echo $arr[$k][$k1]["name"] ?></a>											</td>							
											</tr>											
											
											<?php
										}
									?>
									
											</table>
											</td>
										</tr>
								<?php		
									}else{//hien thi menu cap 2 co link
								?>
									<tr  height="28">										
										<td align="left" width="100%">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td style="font-size:12px; font-weight:bold;" class="menuleftoffsub"><a  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"] ?>" class="content" style="font-size:12px;" id="a<?php echo $k ?>" ><?php echo $arr[$key][$k]["name"] ?></a></td>												
											  </tr>
											</table>
										</td>
									</tr>
								<?php
									}	
								}	
								?>	
								</table>
							</td>							
						</tr>
										
			<?php }else{ // menu cap 1 khong co link?>
					 <tr height="30px">
							<td  class="menuleftoff" id="center<?php echo $key;?>"  nowrap="nowrap"  style="padding-top:10px"><a style="text-transform:uppercase; font-weight:bold; font-size:13px;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"] ?>"  class="title" id="a<?php echo $key ?>"><?php echo $arr[0][$key]["name"] ?></a></td>     
						</tr>  
					<?php 
				}			
		}
		
?>
</table>