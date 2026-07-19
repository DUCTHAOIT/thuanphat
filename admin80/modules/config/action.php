<?php
	function Update(){
		global $db,$smarty,$lang;
		
		$site_name=getParamPost("site_name");
		$web_title=getParamPost("web_title");
		$email=getParamPost("email");
		$meta_keys=getParamPost("meta_keys");
		$address= getParamPost("address");
		$des=getParamPost("des");
		$support=getParamPost("support");
		
		$ymsupport=str_replace(" ", "", trim(getParamPost("ymsupport")));
		$lang=getParamPost("lang");
		$theme=getParamPost("theme");
		$skype=str_replace(" ", "", trim(getParamPost("skype")));
		$hotline=getParamPost("hotline");
		$tel=getParamPost("tel");
		$rewrite_url=getParamPost("rewrite_url");
		if($rewrite_url=="on") $rewrite_url="htaccess";
		else $rewrite_url="url";

		$card_payment_percent=getParamPost("card_payment_percent");
		if($card_payment_percent==="" || !is_numeric($card_payment_percent)) $card_payment_percent=100;
		if($card_payment_percent<0) $card_payment_percent=0;
		if($card_payment_percent>100) $card_payment_percent=100;

		$operating_fund_percent=getParamPost("operating_fund_percent");
		if($operating_fund_percent==="" || !is_numeric($operating_fund_percent)) $operating_fund_percent=10;
		if($operating_fund_percent<0) $operating_fund_percent=0;
		if($operating_fund_percent>100) $operating_fund_percent=100;

		$accumulated_consumption_percent=getParamPost("accumulated_consumption_percent");
		if($accumulated_consumption_percent==="" || !is_numeric($accumulated_consumption_percent)) $accumulated_consumption_percent=10;
		if($accumulated_consumption_percent<0) $accumulated_consumption_percent=0;
		if($accumulated_consumption_percent>100) $accumulated_consumption_percent=100;

		$card_recurring_percent=getParamPost("card_recurring_percent");
		if($card_recurring_percent==="" || !is_numeric($card_recurring_percent)) $card_recurring_percent=16;
		if($card_recurring_percent<0) $card_recurring_percent=0;
		if($card_recurring_percent>100) $card_recurring_percent=100;

		$recurring_consumption_ancestor_percent=getParamPost("recurring_consumption_ancestor_percent");
		if($recurring_consumption_ancestor_percent==="" || !is_numeric($recurring_consumption_ancestor_percent)) $recurring_consumption_ancestor_percent=70;
		if($recurring_consumption_ancestor_percent<0) $recurring_consumption_ancestor_percent=0;
		if($recurring_consumption_ancestor_percent>100) $recurring_consumption_ancestor_percent=100;

		$record = array();

		// Tỉ lệ % hoa hồng theo tầng F1-F8: hoa hồng sơ đồ trực tiếp (mục 4 - key f1..f8) và hoa hồng cây
		// điều tầng (mục 6 - key spillover_f1..f8). Nhập/hiển thị dạng % (0-100) cho dễ đọc, nhưng LƯU dạng
		// phân số (value/100) vào sys_config để khớp đúng định dạng generateDirectCommission()/
		// generateSpilloverCommission() đang đọc trực tiếp làm hệ số nhân (0-1), không đổi code 2 hàm đó.
		$directDefaults = array(1 => 16, 2 => 2, 3 => 2, 4 => 2, 5 => 2, 6 => 2, 7 => 2, 8 => 2);
		for ($lvl = 1; $lvl <= 8; $lvl++) {
			$directPercent = getParamPost("f$lvl");
			if ($directPercent === "" || !is_numeric($directPercent)) $directPercent = $directDefaults[$lvl];
			if ($directPercent < 0) $directPercent = 0;
			if ($directPercent > 100) $directPercent = 100;
			$record["f$lvl"] = $directPercent / 100;

			$spilloverPercent = getParamPost("spillover_f$lvl");
			if ($spilloverPercent === "" || !is_numeric($spilloverPercent)) $spilloverPercent = 3;
			if ($spilloverPercent < 0) $spilloverPercent = 0;
			if ($spilloverPercent > 100) $spilloverPercent = 100;
			$record["spillover_f$lvl"] = $spilloverPercent / 100;
		}

		$record["site_name"] = $site_name;
		$record["web_title"] = $web_title;
		$record["email"] = $email;
		$record["meta_keys"] = $meta_keys;
		$record["address"] = $address;
		$record["des"] = $des;
		$record["support"] = $support;
		$record["ymsupport"] = $ymsupport;
		$record["lang"] = $lang;
		$record["theme"] = $theme;
		$record["skype"] = $skype;
		$record["hotline"] = $hotline;
		$record["tel"] = $tel;
		$record["rewrite_url"] = $rewrite_url;
		$record["card_payment_percent"] = $card_payment_percent;
		$record["operating_fund_percent"] = $operating_fund_percent;
		$record["accumulated_consumption_percent"] = $accumulated_consumption_percent;
		$record["card_recurring_percent"] = $card_recurring_percent;
		$record["recurring_consumption_ancestor_percent"] = $recurring_consumption_ancestor_percent;

		// Chỉ xoá/ghi đúng các key thuộc form này (không DELETE toàn bộ sys_config theo lang), để không
		// xoá nhầm các cấu hình khác không nằm trong form (vd f9 - đã bỏ, không dùng tới, mục 4
		// BUSINESS_RULES.md - không có ô nhập trong form này nên giữ nguyên giá trị cũ nếu còn tồn tại).
		foreach($record as $key=>$value) {
			$sql = "DELETE FROM sys_config WHERE lang='$lang' AND name='$key'";
			$db->Execute($sql);
			$sql = "INSERT INTO sys_config(value,name,lang) VALUES ('$value','$key','$lang')";
			$db->Execute($sql);
		}

		//set_session("config_tb","");
		$smarty->clear_cache(null, "header");
		$smarty->clear_cache(null, "footer");
		$smarty->clear_cache(null, "index");
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=config";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1); 
		$a->showMsg();
	}
	function getConfig(){
		global $db, $lang;
		$sql="SELECT name,value FROM sys_config WHERE lang='$lang'";
		$db->setFetchMode(ADODB_FETCH_ASSOC);
		$arr=$db->GetAssoc($sql);
		//echo $sql;
		return $arr;
	}
?>