<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uploadfile</title>
<style type="text/css">
<!--
body {
	background-color: #D4D0C8;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style></head><body>
<script language="javascript">
var fileName="";
//var fileSize="";
function stsUpload(){
	document.getElementById("Upload").style.display="";
	document.getElementById("Done").style.display="none";
	document.getElementById("Fail").style.display="none";
	document.getElementById("Process").style.display="none";
}

function stsProcess(){
	document.getElementById("Upload").style.display="none";
	document.getElementById("Done").style.display="none";
	document.getElementById("Fail").style.display="none";
	document.getElementById("Process").style.display="";
}
function stsDone(){
	document.getElementById("Upload").style.display="none";
	document.getElementById("Done").style.display="";
	document.getElementById("Fail").style.display="none";
	document.getElementById("Process").style.display="none";
}
function stsFail(){
	document.getElementById("Upload").style.display="none";
	document.getElementById("Done").style.display="none";
	document.getElementById("Fail").style.display="";
	document.getElementById("Process").style.display="none";
}
function _return(){
	text = '<img src=<?php echo _DOMAIN_ROOT_URL?>/temp/' + fileName + '>';
	<?php	
		$file_upload=$_GET["nameImg"];
		$divID=$_GET["divID"];
		echo "opener.document.frmmain." . $file_upload . ".value= fileName;\n";
		echo "opener.document.getElementById('". $divID ."').innerHTML = text;\n";
	?>	
	window.close();
}
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="frmUpload" action="?m=news&f=upload" target="hframe" method="post" enctype="multipart/form-data">
<input type="hidden" name="f" value="upload">
	<tr>
		<td colspan="3" id="Upload">
			<table  border="0" align="center" cellpadding="0" cellspacing="8" class="borderbang">
			  <tr>
			    <td style="font-family:tahoma,Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">&nbsp;</td>
			    <td>Tên anh không được có khoảng trắng hoặc ký tự đặc biệt!</td>
		      </tr>
			  <tr>
					<td style="font-family:tahoma,Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">File:</td>
					<td><input type="file" class="vien" size="39" name="file_name" id="idbrowse1"></td>
			  </tr>
			  <tr>
					<td>&nbsp;</td>
					<td><input type="submit" class="button" value="Upload" onClick="javascript:stsProcess(); document.frmUpload.submit();"> 
					<input type="button" class="button" value="Cancel" onClick="javascript: window.close();"></td>
			  </tr>
		  </table>
	  </td>
	</tr>
	
	<tr>
	<td colspan="3">&nbsp;</td>
    </tr>
	
	<tr id="Process" style="display:none">
		<td colspan="3">
			<table border="0" celpadding="0" cellspacing="0" width="100%">
				<tr><td align="center" class="admintitle"><?php _RUN_UPLOAD_FILE?></td></tr>
				<tr><td height="10" align="center" id="waiting"><img src="images/wait.gif"></td>
			</table>
		</td>
	</tr>
	
	<tr align="center" id="Done" style="display:none">
		<td colspan="3">
			<table border="0" celpadding="0" cellspacing="0" width="100%">
				<tr><td align="center" class="admintitle">Upload thành công</td></tr>
				<tr><td height="10"></td>
				<tr><td height="10" align="center"><input type="button" value="Close" class="button" onClick="javascript:_return();"></td>
			</table>
		</td>
	</tr>
	
	<tr>
	  <td colspan="3" id="Fail" style="display:none">
		  <table border="0" celpadding="0" cellspacing="0" width="100%">
			<tr>
			  <td align="center">Không thể upload file</td>
			</tr>
			<tr>
			  <td height="10"></td>
			<tr>
			  <td height="10" align="center"><input type="button" value="Refresh" class="button" onClick="javascript:stsUpload();"></td>
		  </table>
	  </td>
    </tr>
	
	<tr>
	  <td colspan="3"><iframe name="hframe" height="0" frameborder="0" width="0" src=""></iframe></td>
    </tr>
</form>
</table>
</body>
</html>