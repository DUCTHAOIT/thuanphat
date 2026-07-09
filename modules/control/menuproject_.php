<?php	
	function menuproject(){	
	global $db,$lang;
		$fid=getparamFID(getParam("idF"));			
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&5=5) AND (parent=$fid) ORDER BY sort";		
		$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
	<td align="left" valign="top"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/Left.gif" /></td>       
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb.gif); background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/iconMenu.gif" border="0" ></td>
			<td class="titleBlock" width="100%" align="left" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb.gif); background-repeat:repeat-x;"><?php if($lang='vn'){echo "Sản phẩm";}else{ echo "Products";}?></td>
		  </tr>
		</table>
	</td>	
	<td align="left" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb.gif); background-repeat:repeat-x;"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb2.gif" /></td>
  </tr>
  <tr>
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgLeft.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgLeft.gif" /></td>		
	<td style="padding-left:10px; padding-bottom:0px; padding-top:10px" bgcolor="#F2F2F2" width="100%">			 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php
		$j=0;
		while(!$rs->EOF){
		?>
		<tr>
			<td valign="top" style="padding-right:10px" width="100%">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr style="cursor:pointer;">
					<td align="left" style="padding-left:0px; padding-right:5px; padding-bottom:2px; border-bottom:1px dotted #000000"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/iconTopic.gif" vspace="10" hspace="0" border="0" /></td>
					<td width="100%" style="color:#005B91; border-bottom:1px dotted #000000" nowrap="nowrap" class="title" id="a<?php echo $rs->fields("id");?>">
						<?php echo $rs->fields("name");?>	
					</td>
				  </tr>
				</table></td>        
		</tr>	
		<?php
			$sql="SELECT id,name";
			$sql.=" FROM sys_product";
			$sql.=" WHERE (sys_product.catID =  ".$rs->fields("id").") AND (sys_product.ctrl&1=1)";
			$sql.=" ORDER BY date_create DESC";			
			$arrproduct=$db->GetAssoc($sql);
			if(count($arrproduct)){	
			?>
			<tr>
				<td valign="top" style="padding-left:10px; padding-right:10px" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php			
			foreach($arrproduct as $k=>$v){			
			?>
				
						  <tr>							
							<td width="100%" style="color:#990000; border-bottom:1px dotted #000000; padding:5px; padding-left:0px" nowrap="nowrap" >
								<?php 
										echo "<a id=a".$k." href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."f=detail&"._ID_PRODUCT."=".$k."&submenu=".$rs->fields("id")."\" class=\"content\" style=\"color:#005B91\"><li>".$v."</a";
								 ?>	
							</td>
						  </tr>
						
			<?php			
				}
			?>
			</table></td>        
			</tr>
			<?php
			}	
	
	$j++;
	$rs->MoveNext();
	}		
 ?>
 </table>
	</td>
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgRight.gif);; background-repeat:repeat-y"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgRight.gif" /></td>
  </tr>			 			 
  <tr>
	<td valign="top" align="left"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/LeftB.gif" /></td>
	 <td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgB.gif);; background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/spacer.gif" width="180" height="1"  /></td>
    <td valign="top" align="right"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/RightB.gif" /></td>
  </tr>
</table>
<?php
	}
}	
?>