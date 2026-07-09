<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print</title>
<link rel="stylesheet" type="text/css" href="../../theme/default/style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body>
<?php
	global $db;
	$id = getParam("id");
	if(!$id) return;		
	
	$sql="SELECT sys_article.*";
	$sql.=" FROM sys_article";
	$sql.=" WHERE (sys_article.id='$id')";		
	$rs=$db->Execute($sql);		
	
?>
<table width="95%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #cccccc">
  <tr  bgcolor="#F4F4F4">
  	<td valign="top" class="title" style="font-size:12px; padding-left:10px; color:#990000; border-bottom:1px dashed #CCCCCC; border-top:1px dashed #CCCCCC;" nowrap="nowrap"><?php echo $rs->fields("name") ?></td>
    <td align="right" style="border-bottom:1px dashed #CCCCCC; border-top:1px dashed #CCCCCC;"><table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber37">
        <tr>
          <td nowrap="nowrap"><a onclick="javascript:window.print()" style="cursor:pointer"><img border="0" src="../../theme/default/images/sv_print.gif" /></a></td>
          <td nowrap="nowrap"><a onclick="javascript:window.print()" style="cursor:pointer">Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
		  <td  class="content" align="right" nowrap="nowrap" style="padding-right:40; padding-left:20;">
		  <a onclick="javascript:window.close();" style="cursor:pointer">
	<img src="../../theme/default/images/close.gif" alt="CLOSE" width="15" height="11" border="0" >Close</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>	
        </tr>
    </table></td>
  </tr>   
  <tr>
    <td colspan="2" style="padding-top:10px; padding-bottom:10px; padding-left:10px; padding-right:10px">	
		<?php if($rs->fields("img1")){?>
		<table border="0" align="left" cellpadding="0" cellspacing="0">		
		  <tr>
		  <td style="padding-right:10px"><img src="../../img/article/<?php echo $rs->fields("img1") ?>" border="0" vspace="10" /></td>
		  </tr>		 
		</table>
		<?php } ?>
		<font class="title"><?php echo $rs->fields("summary") ?></font>	
		<font class="content"><?php echo $rs->fields("content") ?></font>	</td>
  </tr>
  <tr>
    <td colspan="2" align="right" bgcolor="#F4F4F4" style="border-bottom:1px dashed #CCCCCC; border-top:1px dashed #CCCCCC;"><table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber37">
        <tr>
          <td nowrap="nowrap"><a onclick="javascript:window.print()" style="cursor:pointer"><img border="0" src="../../theme/default/images/sv_print.gif" /></a></td>
          <td nowrap="nowrap"><a onclick="javascript:window.print()" style="cursor:pointer">Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td  class="content" align="right" nowrap="nowrap"><a onclick="javascript:window.close();" style="cursor:pointer"> <img src="../../theme/default/images/close.gif" alt="CLOSE" width="15" height="11" border="0" />Close</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
