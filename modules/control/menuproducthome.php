<?php	
function menuproducthome(){	
	global $db,$lang;	
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (lang='$lang') AND (img1>'0') ORDER BY sort ASC LIMIT 0, 5";		
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <?php
	$j=0;
	while(!$rs->EOF){
	?>
	<td <?php if($j<>0) {?> style="padding-left:5px" <?php } ?> width="245px" valign="top">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	   <tr>
		<td align="center" style="padding-top:5px; padding-bottom:5px;"><img src="<?php echo _DOMAIN_ROOT_URL?>/img/function/<?php echo $rs->fields("img1");?>" border="0" /></td>
	  </tr>
	  <tr height="40px" >
		<td width="100%" style="" align="center" valign="top"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>" class="title" style="text-transform:uppercase; font-size:16px;"><?php echo $rs->fields("name");?></a></td>
	  </tr>
	 
	</table>
 </td>
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