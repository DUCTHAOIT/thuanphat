<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kết quả bình chọn</title>
<link rel="stylesheet" type="text/css" href="theme/moon/style.css" />
</head>
<?php	
	$module_name="poll";
	$module_dir="modules/poll";
	global $db, $lang;	
	$sql="SELECT * FROM polls WHERE pol_active = 1 AND pol_parent_id = 0 AND lang='$lang'";
	$rs=$db->Execute($sql);	
	
	if(!$rs->Recordcount()) return;	
	
	$db_total_hits = "SELECT SUM(pol_hits) AS pol_hits
							 FROM polls
							 WHERE pol_parent_id = " . $rs->fields("pol_id");

	$rstotal=$db->Execute($db_total_hits);	
	$pol_hits = $rstotal->fields("pol_hits");
	if($pol_hits == 0){
?>
<table width="100%" height="100%">
	<tr>
		<td align="center" class="title">
			<font face="Verdana, Arial, Helvetica, sans-serif" color="#155295" size="5"><b>Chưa có bình chọn nào cả</b></font><p></p>
			<input class="form_button" type="button" name="close_window" value="Đóng cửa sổ" onClick="window.close()">
		</td>
	</tr>
</table>
<?php
}
else{
$db_poll_row = "SELECT *
							 FROM polls
							 WHERE pol_parent_id = " . $rs->fields("pol_id") . "
							 ORDER BY pol_order ASC";

$rs_poll_row=$db->Execute($db_poll_row);			
?>
<table border="1" bgcolor="#FFFFFF" cellpadding="4" cellspacing="0" width="100%" style="border-collapse:collapse">
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFCC33">
			<img src="<?php echo _DOMAIN_ROOT_URL?>/img/poll/thamdo.gif" />
		</td>
	</tr>
	<tr bgcolor="#FF9900">
		<td>&nbsp;</td>
		<td class="content" height="20"><?php echo "Lựa chọn";?></td>
		<td align="center" width="20%" class="content"><?php echo "Số đánh giá";?></td>
		<td align="center" width="50%" class="content"><?php echo "% Tỷ lệ";?></td>
	</tr>
<?php
$i = 0;
while(!$rs_poll_row->EOF){
?>	
	<tr <?php if (($i % 2) == 0) { ?> bgcolor="#0099CC" <?php } else { ?> bgcolor="#6699FF" <?php } ?>>
		<td align="center" width="20"><img src="<?php echo _DOMAIN_ROOT_URL?>/img/poll/dow.gif" border="0"></td>
		<td class="poll"><?php echo $rs_poll_row->fields("pol_name"); ?></td>
		<td align="center" class="detail"><?php echo $rs_poll_row->fields("pol_hits")?></td>
		<td>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="<?php echo number_format($rs_poll_row->fields("pol_hits")/$pol_hits*100,2)?>%">
						<table cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#000033" bgcolor="#FF9900" width="100%">
							<tr>
								<td height="20"></td>
							</tr>
						</table>
					</td>
					<td class="detail">&nbsp;<?php echo number_format($rs_poll_row->fields("pol_hits")/$pol_hits*100,2) . "%"?></td>
				</tr>
			</table>
		</td>
	</tr>
<?php
	$i++;
	$rs_poll_row->MoveNext();
	}
?>
</table>

<?php 
}
?>