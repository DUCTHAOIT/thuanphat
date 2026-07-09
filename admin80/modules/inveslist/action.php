<?php
	function getGroupinveslist($artID=""){
		global $db,$lang;	
		$sql="SELECT * FROM user WHERE (permit='1') ORDER BY id";	
		$arr=$db->GetAssoc($sql);
		$sql="SELECt * FROM sys_inveslist_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			//echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function getHocvien($artID=""){
		global $db,$lang;	
		if($artID){
		$sql="SELECT * FROM sys_userorder ORDER BY id";	
		}else{
		$sql="SELECT * FROM sys_userorder WHERE lop='0' ORDER BY id";	
		}
		$arr=$db->GetAssoc($sql);
		$sql="SELECt * FROM sys_userorder WHERE lop=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			//echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function getGroupProduct($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='product')";
		$obj->limit="all";
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);	
		$sql="SELECt * FROM sys_inveslist_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function updateinveslist(){
		global $db,$lang;
		$id=getParamPost("id");
		$member_id=getSession("uid");	
		if((!getParamPost("op")) ||(!getParamPost("name")) )return;	
			
		$id=getParamPost("id");
		$name=getParamPost("name");		
		$groupID=getParamPost("groupID");	
		$userid=getParamPost("userid");	
		
		$title_img=getParamPost("title_img");
		$summary=getParam("summary");
	//	$content=getParam("content");
		$content=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		$source=getParamPost("source");
		$date_create=getParamPost("date");
		$img=getParamPost("fileName");
		$img1=getParamPost("fileName1");
		
		$title=getParamPost("title");
		$description=getParamPost("description");
		$keywords=getParamPost("keywords");
		
		$special_promotion=getParamPost("special_promotion");		
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img;
		$to=_DOMAIN_ROOT_PATH."/images/inveslist/".$img;
		moveFile($from,$to);
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img1;
		$to=_DOMAIN_ROOT_PATH."/images/inveslist/".$img1;
		moveFile($from,$to);	
		
		//include_once("modules/inveslist/convertString.php");
		loadClass("convertString");
		$obj= new convertString;
		$alias=$obj->remoteDiacritic($name);	
		
		loadClass("convertStringContent");
		$objContent= new convertStringContent;
		$content=$objContent->remoteDiacriticContent($content);
		
		
		$record=array();
		$record["name"]=$name;
		$record["alias"]=$obj->remoteDiacritic($name);		
		$record["title_img"]=$title_img;
		$record["summary"]=$summary;
		$record["content"]=$objContent->remoteDiacriticContent($content);
		$record["source"]=$source;
		$record["date_create"]=$date_create;
		$record["lang"]=$lang;
		$record["img"]=$img;
		$record["img1"]=$img1;		
		
		if(!$id){
			
			$sql = "SELECT id FROM sys_inveslist WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					$sql = "SELECT * FROM sys_inveslist WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);				
					$sql = "INSERT INTO sys_inveslist ( name, alias, summary, content, source, img, img1, title_img, date_create, lang, member_id, special_promotion,title, description, keywords ) VALUES ( '$name', '$alias', '$summary', '$content', '$source', '$img', '$img1', '$title_img', '$date_create', '$lang', '$member_id', '$special_promotion','$title','$description','$keywords')";				
					$return=$db->Execute($sql);
					//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_inveslist_cat
					if($return){
						$idNew=$db->Insert_ID();
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_inveslist_cat(catID,artID) VALUES('$value','$idNew')";
							$return=$db->Execute($sql);
						}
						
						foreach($userid as $key=>$value){
							$sql="UPDATE sys_userorder SET lop='$idNew' WHERE id='$value'";
							$return=$db->Execute($sql);
						}
					}	
			}else{
				
					$sql = "SELECT * FROM sys_inveslist WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);				
					$sql = "INSERT INTO sys_inveslist ( name, alias, summary, content, source, img, img1, title_img, date_create, lang, member_id, special_promotion,title, description, keywords ) VALUES ( '$name', '$alias', '$summary', '$content', '$source', '$img', '$img1', '$title_img', '$date_create', '$lang', '$member_id', '$special_promotion','$title','$description','$keywords')";	
								
					$return=$db->Execute($sql);
					
					$idNew=$db->Insert_ID();			
					$sqlid = "UPDATE sys_inveslist SET";
					$sqlid.=" alias='".$alias."-".$idNew."' WHERE id='$idNew'";
					$db->Execute($sqlid);	
					
					//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_inveslist_cat
					if($return){
						
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_inveslist_cat(catID,artID) VALUES('$value','$idNew')";					
							$return=$db->Execute($sql);
						}
						
						foreach($userid as $key=>$value){
							$sql="UPDATE sys_userorder SET lop='$idNew' WHERE id='$value'";
							$return=$db->Execute($sql);
						}
					}	
			}		
							
		}else{
			$sql = "SELECT id FROM sys_inveslist WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					
					$sql = "SELECT * FROM sys_inveslist WHERE id=$id";
					$rs = @$db->Execute($sql);
					//$sql = @$db->GetUpdateSQL($rs, $record);					
					$sql= "UPDATE sys_inveslist SET name = '$name', alias = '$alias', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";
					$return=$db->Execute($sql);
					//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_inveslist_cat
					if($return){
						$sql="DELETE FROM sys_inveslist_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_inveslist_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
						// update lop
						foreach($userid as $key=>$value){
							$sql="UPDATE sys_userorder SET lop='$id' WHERE id='$value'";
							$return=$db->Execute($sql);
						}
					}
			}else{
			
					$sql = "SELECT * FROM sys_inveslist WHERE id=$id";
					$rs = @$db->Execute($sql);
					//$sql = @$db->GetUpdateSQL($rs, $record);					
					//$sql= "UPDATE sys_inveslist SET name = '$name', alias = '".$alias."-".$id."', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";
					$sql= "UPDATE sys_inveslist SET name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";

					$return=$db->Execute($sql);
					//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_inveslist_cat
					if($return){
						$sql="DELETE FROM sys_inveslist_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_inveslist_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
						// update lop
						foreach($userid as $key=>$value){
							$sql="UPDATE sys_userorder SET lop='$id' WHERE id='$value'";
							$return=$db->Execute($sql);
						}
					}
			
			}		
		}	
		
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=inveslist&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
		//	$ret_page="?m=inveslist&op=mainShowUser";
			$ret_page="?m=inveslist";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function arrList($all,$pageID,$limit=20){		
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		
		$catID=getParamPost("catID");
		if(!$keyword){
			$obj->fieldsName="sys_inveslist.*, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create";
			$obj->tableName="sys_inveslist,sys_inveslist_cat";		
					
			if(!$catID) $obj->where="sys_inveslist.id =  sys_inveslist_cat.artID";
			else $obj->where="sys_inveslist_cat.catID=$catID AND sys_inveslist.id =  sys_inveslist_cat.artID";
			
			$obj->groupBy="sys_inveslist.id";
			$obj->orderBy="sys_inveslist.id DESC";						
		}else{		
			$obj->fieldsName="sys_inveslist.*, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create, match(sys_inveslist.name) against('$keyword' in boolean mode) as relevance";
			$obj->tableName="sys_inveslist,sys_inveslist_cat";
			
			if(!$catID) $obj->where="sys_inveslist.id =  sys_inveslist_cat.artID AND match(sys_inveslist.name) against('$keyword' in boolean mode)";		
			else $obj->where="sys_inveslist_cat.catID=$catID AND sys_inveslist.id =  sys_inveslist_cat.artID AND match(sys_inveslist.name) against('$keyword' in boolean mode)";		 
			
			$obj->groupBy="sys_inveslist.id";
			$obj->orderBy="relevance DESC";				
		}
		
			
		if($all==false){
			$obj->limit_start = $pageID;
			$obj->limit=$limit;
		}else $obj->limit="All";
		$sql=$obj->sqlSelect();	
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;
		$obj->fieldsName="user.name, sys_inveslist_cat.artID, sys_inveslist_cat.catID";
		$obj->tableName="user, sys_inveslist_cat";
		$obj->where="user.id =  sys_inveslist_cat.catID";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$topicArr=$db->GetAll($sql);
		if(!$topicArr) return;
		
		$obj->fieldsName="sys_userorder.name,sys_userorder.lop";
		$obj->tableName="sys_userorder, sys_inveslist";
		$obj->where="sys_inveslist.id = sys_userorder.lop";
		$obj->limit="all";
		$sqlNumUser=$obj->sqlSelect();	
		$NumUserArr=$db->GetAll($sqlNumUser);
		if(!$NumUserArr) return;
		
		foreach($arr as $key=>$value){
			$topicName=checkFuncName($topicArr,$key);
			$arr[$key]["topicName"]= $topicName;
			
			$NumUser=checkNumUser($NumUserArr,$key);
			$arr[$key]["NumUser"]= $NumUser;
		}		
		return $arr;
	}
	//
	//
	function arrListUser($all,$pageID,$limit=20){	
	
		global $db;
		$member_id=getSession("uid");	
		
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		
		$catID=getParamPost("catID");
		if(!$keyword){
			$obj->fieldsName="sys_inveslist.*,sys_member.fistname, sys_member.lastname, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create";
			$obj->tableName="sys_inveslist ,sys_inveslist_cat, sys_member";		
					
			if(!$catID) $obj->where="sys_inveslist.id =  sys_inveslist_cat.artID AND sys_member.id=sys_inveslist.member_id AND sys_inveslist.member_id='".$member_id."'";
			else $obj->where="sys_inveslist_cat.catID=$catID AND sys_inveslist.id =  sys_inveslist_cat.artID AND sys_member.id=sys_inveslist.member_id AND sys_inveslist.member_id='".$member_id."'";
			
			$obj->groupBy="sys_inveslist.id";
			$obj->orderBy="sys_inveslist.id DESC";						
		}else{		
			$obj->fieldsName="sys_inveslist.*,sys_member.fistname, sys_member.lastname, DATE_FORMAT(sys_inveslist.date_create, '".format_date()."') as date_create, match(sys_inveslist.name) against('$keyword' in boolean mode) as relevance";
			$obj->tableName="sys_inveslist ,sys_inveslist_cat, sys_member";
			
			if(!$catID) $obj->where="sys_inveslist.id =  sys_inveslist_cat.artID AND match(sys_inveslist.name) against('$keyword' in boolean mode) AND sys_member.id=sys_inveslist.member_id AND sys_inveslist.member_id='".$member_id."'";		
			else $obj->where="sys_inveslist_cat.catID=$catID AND sys_inveslist.id =  sys_inveslist_cat.artID AND match(sys_inveslist.name) against('$keyword' in boolean mode) AND sys_member.id=sys_inveslist.member_id AND sys_inveslist.member_id='".$member_id."'";		 
			
			$obj->groupBy="sys_inveslist.id";
			$obj->orderBy="relevance DESC";				
		}
		if($all==false){
			$obj->limit_start = $pageID;
			$obj->limit=$limit;
		}else $obj->limit="All";
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;
		$obj->fieldsName="sys_function.name, sys_function.htaccess, sys_inveslist_cat.artID, sys_inveslist_cat.catID";
		$obj->tableName="sys_function, sys_inveslist_cat";
		$obj->where="sys_function.id =  sys_inveslist_cat.catID";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$topicArr=$db->GetAll($sql);
		if(!$topicArr) return;
		
		
		
		foreach($arr as $key=>$value){
			$topicName=checkFuncName($topicArr,$key);
			$topicUrl=checkFuncUrl($topicArr,$key);
			
			$arr[$key]["topicName"]= $topicName;
			$arr[$key]["htaccess"]= $topicUrl;
		}		
		return $arr;
	}
	//
	function checkFuncName($arr,$k){
		foreach($arr as $key=>$value){
			if($value["artID"]==$k) $name .= $value["name"].",";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function checkNumUser($arr,$k){
		foreach($arr as $key=>$value){
			if($value["lop"]==$k) $name .= $value["name"]."<br>";
		}
		$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	//
	function checkFuncUrl($arr,$k){
		foreach($arr as $key=>$value){
			if($value["artID"]==$k) $name .= $value["htaccess"];
		}
	//	$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	function getinveslistID($id){
		if(!$id) return;
		global $db;		
		loadClass("constructSql");
		$selectID = $selectID["selectID"];
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_inveslist";
		//$obj->fieldsLang="sys_inveslist";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function deleteinveslist(){
		global $db;
		$id=getParamPost("id");
		if(!$id){			
			messange(_ERRO);
			listinveslist();
			return;
		}		
		loadClass("constructSql");		
		$obj=new constructSql();				
		$obj->tableName="sys_inveslist";
		$obj->where="sys_inveslist.id =  $id";
		$obj->limit="all";		
		$sql=$obj->sqlDelete();	
		
		if(!$db->Execute($sql)){
			messange(_ERRO);
		}else{			
			messange(_DELETE_SUCCESSFU);
		}
		listinveslist();
	}
	//
	//
	function deleteList(){
		global $db;
		$chkdelete=getParamPost("chkdelete");		
		if(!$chkdelete){			
			messange("Kh&#244;ng x&#243;a &#273;&#432;&#7907;c d&#7919; li&#7879;u!");
			productList();
			return;
		}
		@include_once("classes/constructSql.class.php");	
		//loadClass("constructSql");
		$obj=new constructSql();				
		foreach($chkdelete as $key=>$value){
			//Xoa file anh
			$obj->tableName="sys_inveslist";
			$obj->where="id=$value";
			$sql=$obj->sqlSelect();
			$rs=$db->Execute($sql);
			if(($rs->fields("img")) or ($rs->fields("img1"))){
				loadClass("fileSystem");
				$objs=new fileSystem();
				$objs->delFile(_DOMAIN_ROOT_PATH ."/images/inveslist/".$rs->fields("img"));
				$objs->delFile(_DOMAIN_ROOT_PATH ."/images/inveslist/".$rs->fields("img1"));
			}
			
			
			$obj->tableName="sys_inveslist";
			$obj->where="id = $value";
			$obj->limit="all";		
			$sql=$obj->sqlDelete();	
			$db->Execute($sql);
		
		}
		
		/*
		if(!$db->Execute($sql)){
			messange("Kh&#244;ng x&#243;a &#273;&#432;&#7907;c d&#7919; li&#7879;u!");
		}else{			
			messange("D&#7919; li&#7879;u &#273;&#227; &#273;&#432;&#7907;c x&#243;a!");
		}
		*/
		listinveslist();
	}
	//
	//
	function lockinveslist(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_inveslist SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_inveslist WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	function duyetinveslist(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_inveslist SET active=IF(active=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_inveslist WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/duyet/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
?>