<?php	
function menuproject(){	
	global $db,$lang;
		//$fid=getparamFID(getParam("idF"));			
		//$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&5=5) AND (parent=$fid) ORDER BY sort";		
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&5=5) AND (parent<>0) ORDER BY sort";		
		$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>
	
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		document.frmTemp.objdrop.value = obj.id;
	}
}

</script>	
<table width="100%" border="0" cellpadding="0" cellspacing="0"  bgcolor="#13893d">
 <tr>
	<td valign="top">&nbsp;</td>	
  </tr>
  <tr>
	<td style="" width="100%">			 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php
		$j=0;
		while(!$rs->EOF){
		?>
		<tr onClick="JavaScript:dropCategory(<?php echo $rs->fields("id"); ?>);">
			<td valign="top" width="100%">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/menu/bg.gif); background-repeat:repeat-x;">
					<td width="100%" style="color:#FFFFFF; cursor:pointer; padding-left:10px" nowrap="nowrap" class="title" id="a<?php echo $rs->fields("id");?>"><?php echo $rs->fields("name");?>					</td>
					<td align="right" style="padding-right:5px"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/menu/icon2.gif" vspace="0" hspace="0" border="0" /></td>
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
			<tr id="<?php echo $rs->fields("id"); ?>" height="28" style="display: none;">
				<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php			
			foreach($arrproduct as $k=>$v){			
			?>
				
						  <tr style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/menu/bg.gif); background-repeat:repeat-x;">	
						  	<td align="right" style="padding-right:5px; padding-left:10px"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/menu/icon2.gif" vspace="0" hspace="0" border="0" /></td>						
							<td width="100%" nowrap="nowrap" >
								<?php 
										echo "<a id=a".$k." href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."f=detail&"._ID_PRODUCT."=".$k."&submenu=".$rs->fields("id")."\" class=\"content\" style=\"color:#FFFFFF\">".$v."</a>";
								 ?>							</td>
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
 </table>	</td>
  </tr>			 			 
  <tr>
	<td style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/BgB.gif);; background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/spacer.gif" width="200" height="1"  /></td>
  </tr>
</table>
<script language="javascript">
<?php
	$submenu=getParam("submenu");
	if($submenu){					
		echo "dropCategory(".$submenu.");\n";	
	}
?>
</script>	
<?php
	}
}	
?>