<?php
$path = "/var/zpanel/hostdata/thoitrangkowil/public_html/winny_com_vn/images/photo/";
?>
<link rel="stylesheet" type="text/css" href="js/cropimages/css/imgareaselect-default.css" />
<script type="text/javascript" src="js/cropimages/scripts/jquery.min.js"></script>
<script type="text/javascript" src="js/cropimages/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
function getSizes(im,obj)
	{
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		if(thumb_width > 0)
			{
				if(confirm("Do you want to save image..!"))
					{
						$.ajax({
							type:"GET",
							url:"js/cropimages/ajax_image.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
							cache:false,
							success:function(rsponse)
								{
								 $("#cropimage").hide();
								    $("#thumbs").html("");
									$("#thumbs").html("<img src='http://winny.com.vn/images/photo/"+rsponse+"' width='200' />");
								}
						});
					}
			}
		else
			alert("Please select portion..!");
	}

$(document).ready(function () {
    $('img#photo').imgAreaSelect({
        aspectRatio: '1:1',
        onSelectEnd: getSizes
    });
});
</script>
<?php 
	global $db,$lang;
	$id=getParam("id");
	$parent=getParam("parent");		
	$sql="SELECT * FROM sys_photo WHERE (id='$id')";		
	$rs=$db->Execute($sql);	
	$rs->RecordCount();
	$actual_image_name=$rs->fields("img");
	
	
?>
<?php

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST['submit']))
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats) && $size<(10240*10240))
						{
							$actual_image_name = time().substr($txt, 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
							//	mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
									$image="<h1>Please drag on the image</h1><img src='http://winny.com.vn/images/photo/".$actual_image_name."' id=\"photo\" >";
								
									
								}
							else
								echo "failed";
						}
					else
						echo "Kích thước ảnh nhập không được vượt quá 1024px!";					
				}
			else
				echo "Please select image..!";
		}
?>


<body>
<div style="margin:0 auto; width:600px">
<?php if($image){?>
<?php echo $image; ?>
<?php }else{
	if($id){
?> 
	<img src="http://winny.com.vn/images/photo/<?php echo $rs->fields("img")?>" id="photo">
<?php }
	}
?> 
<div id="thumbs" style="padding:5px; width:600px"></div>
<div style="width:600px">
<form id="cropimage" method="post" enctype="multipart/form-data">
	Upload ảnh <input type="file" name="photoimg" id="photoimg" />
	<input type="hidden" name="image_name" id="image_name" value="<?php echo($actual_image_name)?>" />
	<input type="submit" name="submit" value="Submit" />
</form>
</div>
</div>
</body>
</html>

<form name="frmmain" action="?m=photo" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="lang" value="<?php echo $lang;?>" />
<input type="hidden" name="id" value="<?php echo $rs->fields("id")?>" />

<input type="hidden" name="fileName" id="fileName" value="<?php echo($actual_image_name)?>" /> 
<input type="hidden" name="fileName1" id="fileName1" value="small<?php echo($actual_image_name)?>" /> 
               
<input type="hidden" name="parent" value="<?php echo $parent?>" />
<div class="topic">Cập nhật thông tin</div>
<table width="80%" border="1" cellspacing="0" cellpadding="0" class="table">  
  <?php if(!$parent){
  	$sql="SELECT * FROM sys_function WHERE (module='photo') AND (lang='$lang') ORDER BY sort ASC";
	$arr=$db->GetAssoc($sql);
  ?>
  <tr>
    <td nowrap="nowrap" class="td">Đầu mục</td>
    <td class="td">
		<select name="groupID">		
			<?php 
			foreach($arr as $k=>$v){
			?>      
				
				<option value="<?php echo $v["id"]?>" <?php if($v["id"]==$rs->fields("catID")){ ?> selected="selected" <?php }?>><?php echo $v["name"]?></option>				
			<?php 
		  	}
		  ?>
		</select>
	</td>
  </tr>
  <?php }?>
  <tr>
    <td nowrap="nowrap" class="td">Tên</td>
    <td width="100%" class="td"><input type="text" name="name" value="<?php echo $rs->fields("name")?>" class="text" /></td>
  </tr>
   <tr>
    <td>Mô tả</td>
    <td><div id="des"><textarea name="des" class="textarea" style="width:100%; height:100"><?php echo $rs->fields("des")?></textarea></div></td>
  </tr>  
  <tr>
    <td nowrap="nowrap" class="td">Thứ tự</td>
    <td class="td"><input type="text" name="no" class="text" value="<?php echo $rs->fields("no")?>" style="width:50" /></td>
  </tr>
  <tr>
  	 <td nowrap="nowrap" style="padding-right:10px">Tiêu điểm?</td>
    <td class="td"><input type="checkbox" name="focus" id="focus" value="1" <?php if($rs->fields("focus")){?> checked="checked" <?php }?> /></td>      
  	</tr> 
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td"><input type="submit" value="Update" class="button" /></td>
  </tr>
</table>
</form>