<?php
global $db, $lable;
// Sử dụng vòng lặp for để lưu từng file trong mảng
foreach($_FILES['img_file']['name'] as $name => $value)
{
	$name_img = stripslashes(date('YmdHis')."_".$_FILES['img_file']['name'][$name]);
	$source_img = $_FILES['img_file']['tmp_name'][$name];
	$path_img = "upload/" . $name_img;
	move_uploaded_file($source_img, $path_img);
	
	$sql="INSERT INTO images(catID, file_name, uploaded_on) VALUES('0','$name_img',NOW())";
	$return=$db->Execute($sql); 
}

?>