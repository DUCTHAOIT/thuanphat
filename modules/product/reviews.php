<?php 
		global $db;
		$id  = getParam("id");
		$name  = getParam("name");
		$comment  = getParam("comment");
		$rating  = getParam("rating");
		$user_id = getParam("user_id");
		
		if(!$rating){$rating=0;}
		if(!$id) return;
		$sql="INSERT INTO review ( hotel_id, content, people_name, star, user_id ) VALUES ( '$id', '$comment', '$name', '$rating', '$user_id' )";
		$return=$db->Execute($sql);
		if($return){
			echo "Cảm ơn bạn đã đánh giá sản phẩm!";
		}
		
?>