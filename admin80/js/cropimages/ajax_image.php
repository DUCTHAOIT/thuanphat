<?php
$t_width = 500;	// Maximum thumbnail width
$t_height = 333;	// Maximum thumbnail height
//$new_name = $_GET['image_name']; // Thumbnail image name

//$new_name = "small.jpg"; // Thumbnail image name
$path = "/var/zpanel/hostdata/thoitrangkowil/public_html/winny_com_vn/images/photo/";
if(isset($_GET['t']) and $_GET['t'] == "ajax")
	{
		extract($_GET);
		$new_name = "small".$img; // Thumbnail image name
		$ratio = ($t_width/$w); 
		$nw = ceil($w * $ratio);
		$nh = ceil($h * $ratio);
		$nimg = imagecreatetruecolor($nw,$nh);
		$im_src = imagecreatefromjpeg($path.$img);
		imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
		imagejpeg($nimg,$path.$new_name,500);
		//mysql_query("UPDATE users SET profile_image_small='$new_name' WHERE uid='$session_id'");
		echo $new_name."?".time();
		exit;
	}
	

	?>