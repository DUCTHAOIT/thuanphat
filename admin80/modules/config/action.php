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
		$f1=getParamPost("f1");
		$f2=getParamPost("f2");
		$f3=getParamPost("f3");
		$rewrite_url=getParamPost("rewrite_url");
		if($rewrite_url=="on") $rewrite_url="htaccess";
		else $rewrite_url="url";
		
		$record = array();
				
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
		$record["f1"] = $f1;
		$record["f2"] = $f2;
		$record["f3"] = $f3;
		$record["rewrite_url"] = $rewrite_url;
		
		$sql="DELETE FROM sys_config WHERE lang='$lang'";
		$db->Execute($sql);
		
		foreach($record as $key=>$value) {
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