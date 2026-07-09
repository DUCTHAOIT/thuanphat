<?php	
function menuproduct(){	
	global $db,$lang,$themeName;	
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (lang='$lang') AND (img1>'0') AND (parent=0) ORDER BY sort ASC LIMIT 0, 5";		
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme/<?php echo $themeName;?>/images/menuproduct/2b.gif); background-repeat:repeat-x;" >
  <?php
	$j=1;
	while(!$rs->EOF){
	?>
		<td style="padding-left:10px" align="right"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme/<?php echo $themeName;?>/images/menuproduct/r<?php echo $j;?>.gif" /></td>
		<td width="25%" style="color:#FFFFFF; text-transform:uppercase; background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme/<?php echo $themeName;?>/images/menuproduct/2.gif); background-repeat:repeat-x;" nowrap="nowrap" class="title" align="center"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>" class="title" style="color:#FFFFFF; text-decoration:none;"><?php echo $rs->fields("name");?></a></td>
		<td style="padding-right:10px" align="left"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme/<?php echo $themeName;?>/images/menuproduct/3.gif" /></td>
	 <?
	 $j++;
		$rs->MoveNext();
		}		
	 ?>
  </tr>			 			  
</table>
<?php
	}
}	
?>