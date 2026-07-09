<?php
function poll(){
	global $db, $lang, $theme_name;
	$lang=get_current_language();
	$sql="SELECT * FROM polls WHERE pol_active = 1 AND pol_parent_id = 0";
	$rs=$db->Execute($sql);	
	echo "duongmn".$sql;
	if(!$rs->Recordcount()) return;	
	 
?>
<script language="javascript">
	function checkpoll(){
		 timeWin();
		 poll.submit();
		
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="poll" method="post" action="?module=poll&file=poll_update">
   <tr align="center">
		    <td colspan="2" style="background-image:url(theme/<?php echo $theme_name;?>/images/header/linemenu.gif); background-repeat:repeat-x; padding-bottom:3; padding-top:3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><img src="theme/<?php echo $theme_name?>/images/center/dow.gif" hspace="5" vspace="5"/></td>
				<td width="100%" class="title" style="color:#FFFFFF"><?php echo _POLL?></a></td>
				</tr>
			</table>
		</td>
	 </tr>
	 
  <tr>
    <td bgcolor="#dddddd" style="padding-left:5; padding-right:5; padding-top:5; padding-bottom:5" colspan="2" class="content" align="left"><?php echo translate($rs->fields("pol_name"), $lang); ?></td>
  </tr>
   <tr height="1" bgcolor="#666666">
    <td style="padding-left:5; padding-right:5; padding-top:5; padding-bottom:5" colspan="2" class="content" align="left"></td>
  </tr>
   <?php
	$sql_row = "SELECT * FROM polls WHERE pol_parent_id = " .$rs->fields("pol_id") . " ORDER BY pol_order ASC";																		
	$rs_row=$db->Execute($sql_row);			
	while(!$rs_row->EOF){
	?>
  <tr  bgcolor="#dddddd" style="padding-top:10">
    <td><input name="pol_id" type="radio" value="<?php echo  $rs_row->fields("pol_id");?>"/></td>
    <td align="left" width="90%"><?php echo translate($rs_row->fields("pol_name"), $lang);?></td>
  </tr>
  <?
	$rs_row->MoveNext();
	}
	?>
	<tr height="1" bgcolor="#666666">
	<td style="padding-left:5; padding-right:5; padding-top:5; padding-bottom:5" colspan="2" class="content" align="left"></td>
	</tr>
  <tr bgcolor="#dddddd">
    <td colspan="2" style="padding-top:5; padding-right:5; padding-bottom:5" align="right">
	<input type="button" class="button" onclick="checkpoll()" value="<?php echo _DANHGIA?>" />
	<input class="button" type="button" value="<?php echo _KETQUA?>" onclick="timeWin()" />
	</td>
  </tr>
  </form>
</table>

<script language="JavaScript">
	function timeWin(url) {
     remote=window.open('?module=poll&file=poll_result','timelineWin', 'width = 500, height = 250, alwaysLowered=0, alwaysRaised=0, channelmode=0, dependent=1, directories=0, fullscreen=0, hotkeys=1, location=0, menubar=0, resizable=0, scrollbars=1, status=0, titlebar=0, toolbar=0, z-lock=0');
     if (!remote.opener) 
				remote.opener = self;
		 if (window.focus)
				remote.focus();  
	}
</script>
<?
}
?>
