<?php
//define("UPLOADTYPE",".zip,.bmp,.jpg,.jpeg,.gif,.png,.swf");
$result = uploadfile();
//print_r($result);return;
if($result){?>
	<script language="javascript">
		parent.fileName="<?php echo $result;?>";
		parent.stsDone();	
	</script>
<?php
}
else{?>
<script language="javascript">
	parent.stsFail();
</script>
<?php
}
function uploadfile(){
	$uploaddir = _DOMAIN_ROOT_PATH."/temp/";
	$fileName=uniquename()."_". basename($_FILES['file_name']['name']);
	$uploadfile = $uploaddir . basename($_FILES['file_name']['name']);
	
	if (move_uploaded_file($_FILES['file_name']['tmp_name'], $uploadfile)) {
	   $jpegqual = '100';
		//Create images small
		$sourcefile = $uploadfile;
		$targetfile = $uploaddir . $fileName;
		$dest_x = '120';
		$dest_y = '70';
		$return=resizeToFile ($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual);
		//Create images big
		$targetfile = $uploaddir ."big_". $fileName;
		$dest_x = '300';
		$dest_y = '200';
		$return=resizeToFile ($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual);
	} else {
	   echo "Possible file upload attack!\n";
	   echo "<input type=\"button\" value=\"Refresh\" class=\"button\" onClick=\"javascript:stsUpload();\"<BR>";
	}
	unlink($uploadfile);
	if($return==true) return $fileName;
}
//
function resizeToFile($sourcefile, $dest_x, $dest_y, $targetfile,$jpegqual)
{

	/* Get the dimensions of the source picture */
	$picsize=getimagesize("$sourcefile");
	$source_x = $picsize[0];
	$source_y = $picsize[1];
	$source_id = imageCreateFromJPEG("$sourcefile");
	/* Create a new image object (not neccessarily true colour) */
	
	$target_id=imagecreatetruecolor($dest_x, $dest_y);
	/* Resize the original picture and copy it into the just created image
	  object. Because of the lack of space I had to wrap the parameters to
	  several lines. I recommend putting them in one line in order keep your
	  code clean and readable */
	
	$target_pic=imagecopyresampled($target_id,$source_id,
								  0,0,0,0,
								  $dest_x,$dest_y,
								  $source_x,$source_y);
	/* Create a jpeg with the quality of "$jpegqual" out of the
	  image object "$target_pic".
	  This will be saved as $targetfile */
	
	imagejpeg ($target_id,"$targetfile",$jpegqual);
	return true;
}
//
function getextension($name){
	$post = strrpos($name,".");
	if ($post==0) return "";
	$tem = substr($name,$post);
	return $tem;
}
//
function uniquename(){
    	$d=getdate();
     	$tem = ((int)$d["year"]-1900)*12*30*24*60*60;
		$tem += (int)$d["mon"]*30*24*60*60;
		$tem += ((int)$d["mday"])*24*60*60;
		$tem += ((int)$d["hours"])*60*60;
		$tem += ((int)$d["minutes"])*60;
		$tem += ((int)$d["seconds"]);
		$tem .= rand(1,100);
     	$tem = base_convert($tem,10,32);
     	$tem = strtoupper((string)$tem);
     	return $tem;
}
//
?>