<?php
function poll(){
	global $db, $smarty, $lang, $lable;	
	$sql="SELECT * FROM polls WHERE (pol_active = 1) AND (pol_parent_id = 0) AND (lang='$lang')";	
	$rs=$db->Execute($sql);		
	if(!$rs->Recordcount()) return;	
	 
?>
<script language="javascript">
	function checkpoll(){
		 timeWin();
		 poll.submit();
		
	}
</script>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="poll" method="post" action="/?m=poll&f=poll_update">   
  <tr>  
    <td colspan="3" class="content">
     	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb.gif); background-repeat:repeat-x"><img src="<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/iconOther.gif" border="0" ></td>
			<td class="titleBlock" width="100%" align="left" nowrap="nowrap" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/block/titlebb.gif); background-repeat:repeat-x; padding-left:10px" valign="top"><?php echo $lable->_("Poll")?></td>
		  </tr>
		</table>
	 </td>
    </tr>  
  <tr>
  	<td style="border-left:0px solid #0000FF"><img src="<?php echo _DOMAIN_ROOT_URL?>/img/poll/spacer.gif" width="1" height="1" /></td>
    <td style="padding-left:5; padding-right:5; padding-top:5; padding-bottom:5" class="content" align="left"><?php echo $rs->fields("pol_name"); ?></td>
	<td style="border-right:0px solid #0000FF"><img src="<?php echo _DOMAIN_ROOT_URL?>/img/poll/spacer.gif" width="1" height="1" /></td>
  </tr>  
   <?php
	$sql_row = "SELECT * FROM polls WHERE pol_parent_id = " .$rs->fields("pol_id") . " ORDER BY pol_order ASC";																		
	$rs_row=$db->Execute($sql_row);			
	while(!$rs_row->EOF){
	?>
  <tr  style="padding-top:10px">
  	<td colspan="3" style="padding-left:10px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		 <td><input name="pol_id" type="radio" value="<?php echo  $rs_row->fields("pol_id");?>"/></td>
  	  <td align="left" width="90%"><?php echo $rs_row->fields("pol_name");?></td>
	  </tr>
	</table>	</td>
  </tr>
  <?php
	$rs_row->MoveNext();
	}
	?>
  <tr>
    <td colspan="3" style="padding-top:5; padding-right:5; padding-bottom:5; padding-left:10px" align="left">
	<input type="button" class="button2" onclick="checkpoll()" value="<?php echo $lable->_("Poll")?>" />
	<input class="button2" type="button" value="<?php echo $lable->_("Result")?>" onclick="timeWin()" />	</td>
  </tr>  
  </form>
</table>
<br>
<script language="JavaScript">
	function timeWin(url) {
     remote=window.open('/poll_result/','timelineWin', 'width = 500, height = 270, alwaysLowered=0, alwaysRaised=0, channelmode=0, dependent=1, directories=0, fullscreen=0, hotkeys=1, location=0, menubar=0, resizable=0, scrollbars=1, status=0, titlebar=0, toolbar=0, z-lock=0');
     if (!remote.opener) 
				remote.opener = self;
		 if (window.focus)
				remote.focus();  
	}
</script>
<?php
}
?>