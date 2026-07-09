<?php
	switch ($op){
		case "uploadFile"	: uploadFile();break;
		default 				: mainShow();break;
	}
	//
	function getextension($name){
		$post = strrpos($name,".");
		if ($post==0) return "";
		$tem = substr($name,$post);
		return $tem;
	}
	
	//
	function mainShow(){
?>
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
	var fileType="";
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
		text = '<img style="width:80%" src=<?php echo _DOMAIN_ROOT_URL?>/temp/' + fileName + '>';
		opener.document.frmmain.<?php echo $_GET["fileName"]?>.value= fileName;
		opener.document.getElementById('<?php echo $_GET["fileName"]?>v').innerHTML = text;
		window.close();
	}
	</script>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<form name="frmUpload" action="?m=control&f=uploadFileDownload" target="hframe"  method="post" enctype="multipart/form-data">
	<input type="hidden" name="op" value="uploadFile">
		<tr>
			<td colspan="3" id="Upload">
				<table  border="0" align="center" cellpadding="0" cellspacing="8" class="borderbang">
				  <tr>
					<td style="font-family:tahoma,Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">&nbsp;</td>
					<td>Tên file không được có khoảng trắng hoặc ký tự đặc biệt!</td>
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
<?php
	}	
	function uploadFile(){
		$result = callUploadFile();
		$name=$result["file_name"]["name"];
		$type=$result["file_name"]["ext"];		
		if($name){?>
		<script language="javascript">
			parent.fileName="<?php echo $name;?>";
			parent.fileType="<?php echo $type;?>";
			parent.stsDone();		
		</script>
<?php }else{ ?>
		<script language="javascript">
			parent.stsFail();
		</script>		
<?php
		}
	}
	//
	function callUploadFile(){
		$tem = array_keys($_FILES);
		$result = array();
		for($i=0;$i<count($tem);$i++){
			$result[$tem[$i]] = array();
			if (!is_uploaded_file($_FILES[$tem[$i]]['tmp_name'])) {
					$result[$tem[$i]] = array("status"=>false,"name"=>"","ext"=>"","type"=>"","size"=>"");
					continue;
				}
			$ext = getextension($_FILES[$tem[$i]]['name']);
			  if(strstr(UPLOADTYPE,strtolower($ext)) == ""){
				   $result[$tem[$i]] = array("status"=>false,"name"=>"","ext"=>"","type"=>"","size"=>"");
					continue;
				}
			$path= _DOMAIN_ROOT_PATH."/temp/";
			//$name = uniquename().$ext;
			$name = uniquename()."_".$_FILES[$tem[$i]]['name'];
			//$name = $_FILES[$tem[$i]]['name'];
			  if (!move_uploaded_file($_FILES[$tem[$i]]['tmp_name'], $path.$name)){
				$result[$tem[$i]] = array("status"=>false,"name"=>"","ext"=>"","type"=>"","size"=>"");
				continue;
				}
			  $result[$tem[$i]] = array("status"=>true,"name"=>$name,"ext"=>$ext,"type"=>$_FILES[$tem[$i]]["type"],"size"=>$_FILES[$tem[$i]]["size"]);
			}
		unset($tem,$name,$ext);
		return $result;
	}
	
?>