<?php
	function getGroup($artID=""){
		global $db,$moduleName;
		loadClass("menuLevel");				
		loadClass("constructSql");
		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_function";		
		$obj->orderBy="id";		
		$obj->where="module='video' AND (ctrl&1=1)";	
		$obj->limit="all";
		$sql=$obj->sqlSelect();				
		$obj=new menuLevel();
		$obj->sql=$sql;		
		$arr=$obj->orderMenu();				
		return $arr;
	}
	//		
	function updatevideo(){
		global $db,$lang;		
		
		$id=getParamPost("id");
		$typeyoutube=getParamPost("youtube");
		if($typeyoutube=='video'){
			$fileName1=getParamPost("fileName1");
			$youtube="";
		}else{
			$youtube=getParamPost("txt_youtube");
			$fileName1="";	
		}
		
		$name=getParamPost("name");
		$address=getParamPost("address");
		$tel=getParamPost("tel");
		$website=getParamPost("website");
		$des=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		//$des=getParamPost("des");		
		$no=getParamPost("no");
		$fileName=getParamPost("fileName");		
		$catid=getParamPost("catid");
		$catID=getParamPost("groupID");	
		
		$special_promotion=getParamPost("special_promotion");
		
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;
		
		$record=array();
		$record["name"]=$name;
		$record["address"]=$address;
		$record["tel"]=$tel;
		$record["website"]=correct_url($website);
		
		$record["des"]=$des;		
		$record["lang"]=$lang;
		$record["no"]=$no;
		$record["img"]=$fileName;
		$record["img1"]=$fileName1;
		$record["catid"]=$catid;
		$record["special_promotion"]=$special_promotion;
		
		if($fileName){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName";
			$to=_DOMAIN_ROOT_PATH."/images/video/$fileName";
			moveFile($from,$to);
		}
		if($fileName1){
			$from=_DOMAIN_ROOT_PATH."/temp/$fileName1";
			$to=_DOMAIN_ROOT_PATH."/images/video/$fileName1";
			moveFile($from,$to);
		}
		
		if(!$id){			
			$sql = "SELECT * FROM sys_video WHERE 0 = -1";
			$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);
			$sql = "INSERT INTO sys_video (name, address, tel, website, des, lang, no, img, img1, special_promotion,youtube,catID) VALUES ('$name', '$address', '$tel', '$website', '$des', '$lang', '$no', '$fileName', '$fileName1', '$special_promotion','$youtube','$catID')";						
			
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_video WHERE id=$id";
			$rs = $db->Execute($sql);
			//$sql = $db->GetUpdateSQL($rs, $record);
			$sql= "UPDATE sys_video SET name='$name', address='$address', tel='$tel', website='$website', des='$des', lang='$lang', no='$no', img='$fileName', img1='$fileName1', special_promotion='$special_promotion',youtube='$youtube', catID='$catID' WHERE id=$id";
			
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=video";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=video&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getvideoList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_video";	
		$obj->fieldsLang="sys_video";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockvideo(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_video SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_video WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function correct_url($url)// dua url ve dang chuan http://www.namedomain.com
	{
		If ($url==FALSE) {
		return $url;
		}
		$url=parse_url($url);
		If (stristr($url['host'], "www")==FALSE and $url['scheme']==FALSE and stristr($url['path'], "www")==FALSE) {
		$url['host']="www." .$url['host'];
		}
		$new_url="http:" .$url['port'] ."//" .$url['host'] .$url['path'];
		If ($url['query']!=FALSE) {
		$new_url=$new_url ."?" .$url['query'];
		}
		If ($url['fragment']!=FALSE) {
		$new_url=$new_url ."#" .$url['fragment'];
		}
		return $new_url;
	}
	//
	function videoDelete(){		
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_video WHERE id=$id";		
		$db->Execute($sql);
		videoList();
	}	
	//
	function getvideoID($id){
		global $db;
		$sql="SELECT * FROM sys_video WHERE  id=$id";			
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		if($arr["img"]){
			$arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/video/".$arr["img"];
		}else{
			$arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/none.gif";
		}
		
		//else $arr["imgs_view"]=_DOMAIN_ROOT_URL."/images/video/".$arr["img"];		
		return $arr;
	}
	//
	function getvideoCat($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_video_cat";
		$obj->limit="all";
		$obj->orderBy="no";
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function getGroupVideo(){
		global $db,$lang;
		$sql="SELECT * FROM sys_function WHERE (module='video') AND (lang='$lang')";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
?>