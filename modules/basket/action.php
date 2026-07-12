<?php
	// Giao (intersection) nguồn thanh toán được TẤT CẢ sản phẩm trong giỏ hàng hiện tại chấp nhận (mục 3
	// BUSINESS_RULES.md, cập nhật 2026-07-11). Dùng chung cho cả trang giỏ hàng (hiện/ẩn checkbox) và
	// modules/basket/order.php (kiểm tra lại ở server trước khi trừ tiền, không tin lựa chọn từ client).
	// Giỏ trống hoặc sản phẩm không xác định -> mặc định cho phép cả 3 (an toàn, giống sản phẩm chưa cấu
	// hình riêng).
	function getAcceptedPaymentSources(){
		global $mysqli;
		$default = ['accept_card' => true, 'accept_tieu_dung' => true, 'accept_kha_dung' => true];

		$basket = $_SESSION["basket"];
		if (!$basket) return $default;

		$ids = array_filter(array_map('intval', array_keys($basket)), function($id) { return $id > 0; });
		if (!$ids) return $default;

		$in = implode(",", $ids);
		$res = $mysqli->query("SELECT MIN(accept_card_payment) c, MIN(accept_tieu_dung_payment) t, MIN(accept_kha_dung_payment) k FROM sys_product WHERE id IN ($in)");
		$row = $res ? $res->fetch_assoc() : null;
		if (!$row || $row['c'] === null) return $default;

		return [
			'accept_card' => (int) $row['c'] === 1,
			'accept_tieu_dung' => (int) $row['t'] === 1,
			'accept_kha_dung' => (int) $row['k'] === 1,
		];
	}

	function getProductBasket(){
		global $db,$lable;
		$arr=$_SESSION["basket"];
		if(!$arr)return;		
		foreach ($arr as $key=>$value){
			if($key>0) $product.="'$key',";			
		}
		$product=substr($product, 0, strlen($product)-1);
		if(!$product){
			//echo $lable->_("Cannot find product in basket");
			return;
		}
		
		$sql="SELECT sys_product.*, sys_function.". getSession("rewrite_url"). " as url";
		$sql.=" FROM sys_product, sys_function";
		$sql.=" WHERE sys_product.id IN($product) AND (sys_product.catID=sys_function.id) AND (sys_product.ctrl&1=1)";
		$rs=$db->Execute($sql);
		
		if(!$rs->RecordCount()){
			//echo box("Error!!",$lable->_("Cannot find basket!"));	
			return;
		}
		
		while(!$rs->EOF){
			$key=$rs->fields("id");
			$arr_order[$key]["name"] = $rs->fields("name");
			$arr_order[$key]["alias"] = $rs->fields("alias");
			$arr_order[$key]["img"] = $rs->fields("img");
			$arr_order[$key]["url"] = $rs->fields("url");
			$arr_order[$key]["model"] = $rs->fields("model");
			
			$arr_order[$key]["thanhtien"] = $arr[$key]["quantity"] * $rs->fields("price");
			$arr_order[$key]["price"] = $rs->fields("price");
			
			$arr_order[$key]["quantity"] = $arr[$key]["quantity"];
			$arr_order[$key]["color"] = $arr[$key]["color"];
			$arr_order[$key]["size"] = $arr[$key]["size"];	
			
			$rs->MoveNext();
		}
		return $arr_order;
	}	
	function getBasketList($limit,$pageID=0){
		global $db;
		$username=getSession("username");
		if($limit=="all") $sql="SELECT *, DATE_FORMAT(sdate, '".format_date()."') as sdate FROM sys_order WHERE (username='$username') ORDER BY sdate ASC";
		else  $sql="SELECT *, DATE_FORMAT(sdate, '".format_date()."') as sdate FROM sys_order  WHERE (username='$username') ORDER BY sdate ASC LIMIT $pageID,15";		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	function getDetailBasket($basketID){		
		global $db;
		$sql="SELECt * FROM sys_order_detail WHERE basketID=$basketID";
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
?>