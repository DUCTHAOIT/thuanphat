<?php
	function getGroupArticle($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='article')";
		$obj->limit="all";
		$obj->orderBy="sort";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);

		$sql="SELECt * FROM sys_article_cat WHERE artID=$artID";	
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
		$sql="SELECt * FROM sys_article_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function updateArticle(){
		global $db,$lang;
		$id=getParamPost("id");
		$member_id=getSession("uid");	
		if((!getParamPost("op")) ||(!getParamPost("name")) )return;	
			
		$id=getParamPost("id");
		$name=getParamPost("name");		
		$groupID=getParamPost("groupID");		
		$title_img=getParamPost("title_img");
		$summary=getParam("summary");
	//	$content=getParam("content");
		$content=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		// responsive img
		$foo = $content;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$content = str_replace($search, $replace, $newFoo);
		////
		$source=getParamPost("source");
		$date_create=getParamPost("date");
		$date_create = str_replace('/', '-', $date_create);
		$date_create =  date('Y-m-d', strtotime($date_create));
	
		$lang=getParamPost("lang");		
		$img=getParamPost("fileName");
		$img1=getParamPost("fileName1");
		
		$title=getParamPost("title");
		$description=getParamPost("description");
		$keywords=getParamPost("keywords");
		
		$special_promotion=getParamPost("special_promotion");		
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img;
		$to=_DOMAIN_ROOT_PATH."/images/article/".$img;
		moveFile($from,$to);
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img1;
		$to=_DOMAIN_ROOT_PATH."/images/article/".$img1;
		moveFile($from,$to);	
		
		//include_once("modules/article/convertString.php");
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
			
			$sql = "SELECT id FROM sys_article WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					$sql = "SELECT * FROM sys_article WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);				
					$sql = "INSERT INTO sys_article ( name, alias, summary, content, source, img, img1, title_img, date_create, lang, member_id, special_promotion,title, description, keywords ) VALUES ( '$name', '$alias', '$summary', '$content', '$source', '$img', '$img1', '$title_img', '$date_create', '$lang', '$member_id', '$special_promotion','$title','$description','$keywords')";				
					$return=$db->Execute($sql);
					//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_article_cat
					if($return){
						$idNew=$db->Insert_ID();
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_article_cat(catID,artID) VALUES('$value','$idNew')";
							$return=$db->Execute($sql);
						}
					}	
			}else{
				
					$sql = "SELECT * FROM sys_article WHERE 0 = -1";
					$rs = $db->Execute($sql);
					//$sql = $db->GetInsertSQL($rs, $record);				
					$sql = "INSERT INTO sys_article ( name, alias, summary, content, source, img, img1, title_img, date_create, lang, member_id, special_promotion,title, description, keywords ) VALUES ( '$name', '$alias', '$summary', '$content', '$source', '$img', '$img1', '$title_img', '$date_create', '$lang', '$member_id', '$special_promotion','$title','$description','$keywords')";	
								
					$return=$db->Execute($sql);
					
					$idNew=$db->Insert_ID();			
					$sqlid = "UPDATE sys_article SET";
					$sqlid.=" alias='".$alias."-".$idNew."' WHERE id='$idNew'";
					$db->Execute($sqlid);	
					
					//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_article_cat
					if($return){
						
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_article_cat(catID,artID) VALUES('$value','$idNew')";					
							$return=$db->Execute($sql);
						}
					}	
			}		
							
		}else{
			$sql = "SELECT id FROM sys_article WHERE alias = '$alias'";			
			$rs = $db->Execute($sql);
			if(!$rs->RecordCount()){
					
					$sql = "SELECT * FROM sys_article WHERE id=$id";
					$rs = @$db->Execute($sql);
					//$sql = @$db->GetUpdateSQL($rs, $record);					
					$sql= "UPDATE sys_article SET name = '$name', alias = '$alias', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";
					$return=$db->Execute($sql);
					//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_article_cat
					if($return){
						$sql="DELETE FROM sys_article_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_article_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
					}
			}else{
			
					$sql = "SELECT * FROM sys_article WHERE id=$id";
					$rs = @$db->Execute($sql);
					//$sql = @$db->GetUpdateSQL($rs, $record);					
					//$sql= "UPDATE sys_article SET name = '$name', alias = '".$alias."-".$id."', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";
					$sql= "UPDATE sys_article SET name = '$name', alias = '".$alias."', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', member_id='$member_id', special_promotion='$special_promotion', title='$title', description='$description', keywords='$keywords' WHERE id=$id";

					$return=$db->Execute($sql);
					//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_article_cat
					if($return){
						$sql="DELETE FROM sys_article_cat WHERE artID='$id'";
						$db->Execute($sql);
						foreach($groupID as $key=>$value){
							$sql="INSERT INTO sys_article_cat(catID,artID) VALUES('$value','$id')";
							$return=$db->Execute($sql);
						}
					}
			
			}		
		}	
		
		//////////////
		$path=_DOMAIN_ROOT_PATH."/rssnew.xml";	
					
		$sqlnew="SELECT sys_article.*, sys_function.htaccess FROM sys_article_cat,sys_article,sys_function WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=sys_function.id) ORDER BY sys_article.date_create DESC LIMIT 0,11";			
			
		$arrnew=$db->GetAssoc($sqlnew);		
		foreach($arrnew as $key=>$value){			
				$contentnew.="\n <item>
				<title><![CDATA[".$value["name"]."]]></title>
				<description><![CDATA[".$value['summary']."]]></description>
				<link>"._DOMAIN_ROOT_URL."/".$value["htaccess"]."".$value["alias"]."</link>
				<pubDate>".$value['date_create']."</pubDate>
				</item>";
			//	$content.="\n <slide jpegURL=\"thumbs/".$value["img"]."\" d_URL=\"slides/".$value["img1"]."\" transition=\"29\" panzoom=\"1\" URLTarget=\"0\" phototime=\"2\" url=\"\" title=\"1\" width=\"550\" height=\"400\"/>";		
		}		
		
		$content_file="<?xml version=\"1.0\" encoding=\"utf-8\"?>
			<rss version=\"2.0\">
			  <channel>
				<title>hnsdc.vn</title>
				<description>TRUNG TÂM DỮ LIỆU NHÀ NƯỚC HÀ NỘI</description>
				<link>http://hnsdc.vn/tin-tuc-su-kien/tin-tong-hop/</link>
				<copyright>hnsdc.vn</copyright>
				<generator>http://hnsdc/tin-tuc-su-kien/hoat-dong-cua-trung-tam/</generator>
				<pubDate>April 12, 2012, 9:56 pm</pubDate>
				<lastBuildDate>April 12, 2012, 9:56 pm</lastBuildDate>";
						
		$content_file.=$contentnew;
		$content_file.="\n</channel>";		
		$content_file.="\n</rss>";		
		//ghi vao file		
		if ($handle = fopen($path, 'w+')) {
			fwrite($handle, $content_file);
			fclose($handle); 
		}else{
			die($lable->_("Cannot write file"));
		}	
		
//////////////

		
		$sqlfun="SELECT * FROM sys_function WHERE (lang='$lang') AND (ctrl&1=1) AND (sys_function.focus = '1') AND (sys_function.module = 'article') ORDER BY sort";
		$rsfun=$db->Execute($sqlfun);	
		if($rsfun->RecordCount()){
			while(!$rsfun->EOF){
				//////////////
				$path=_DOMAIN_ROOT_PATH."/".$rsfun->fields("id").".xml";	
				$sqlgallery="SELECT sys_article.*, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, sys_function.htaccess";
				$sqlgallery.=" FROM sys_article_cat , sys_article, sys_function";
				$sqlgallery.=" WHERE sys_article_cat.artID =  sys_article.id AND sys_article_cat.catID =  sys_function.id AND sys_article.lang='$lang' AND sys_article.ctrl&1=1";
				$sqlgallery.=" AND sys_function.id = ".$rsfun->fields("id")."";		
				$sqlgallery.=" ORDER BY sys_article.date_create DESC LIMIT 0,11";	
					
				$arrgallery=$db->GetAssoc($sqlgallery);		
				foreach($arrgallery as $key=>$value){			
						$contentgallery.="\n <item>
						<title><![CDATA[".$value["name"]."]]></title>
						<description><![CDATA[".$value['summary']."]]></description>
						<link>"._DOMAIN_ROOT_URL."/".$value["htaccess"]."".$value["alias"]."</link>
						<pubDate>".$value['date_create']."</pubDate>
						</item>";
					//	$content.="\n <slide jpegURL=\"thumbs/".$value["img"]."\" d_URL=\"slides/".$value["img1"]."\" transition=\"29\" panzoom=\"1\" URLTarget=\"0\" phototime=\"2\" url=\"\" title=\"1\" width=\"550\" height=\"400\"/>";		
				}		
				
				$content_file="<?xml version=\"1.0\" encoding=\"utf-8\"?>
					<rss version=\"2.0\">
					  <channel>
						<title>hnsdc.vn</title>
						<description>TRUNG TÂM DỮ LIỆU NHÀ NƯỚC HÀ NỘI</description>
						<link>http://hnsdc.vn/tin-tuc-su-kien/tin-tong-hop/</link>
						<copyright>hnsdc.vn</copyright>
						<generator>http://hnsdc.vn/tin-tuc-su-kien/tin-tong-hop/</generator>
						<pubDate>April 12, 2012, 9:56 pm</pubDate>
						<lastBuildDate>April 12, 2012, 9:56 pm</lastBuildDate>";
								
				$content_file.=$contentgallery;
				$content_file.="\n</channel>";		
				$content_file.="\n</rss>";		
				//ghi vao file		
				if ($handle = fopen($path, 'w+')) {
					fwrite($handle, $content_file);
					fclose($handle); 
				}else{
					die($lable->_("Cannot write file"));
				}	
				$rsfun->MoveNext();	
			}	
		}		
		//////////////
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=article&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
		//	$ret_page="?m=article&op=mainShowUser";
			$ret_page="?m=article";
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
			$obj->fieldsName="sys_article.*,sys_member.fistname, sys_member.lastname, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create";
			$obj->tableName="sys_article ,sys_article_cat, sys_member";		
					
			if(!$catID) $obj->where="sys_article.id =  sys_article_cat.artID AND sys_member.id=sys_article.member_id";
			else $obj->where="sys_article_cat.catID=$catID AND sys_article.id =  sys_article_cat.artID AND sys_member.id=sys_article.member_id";
			
			$obj->groupBy="sys_article.id";
			$obj->orderBy="sys_article.id DESC";						
		}else{		
			$obj->fieldsName="sys_article.*, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, match(sys_article.name) against('$keyword' in boolean mode) as relevance";
			$obj->tableName="sys_article ,sys_article_cat";
			
			if(!$catID) $obj->where="sys_article.id =  sys_article_cat.artID AND match(sys_article.name) against('$keyword' in boolean mode) AND sys_member.id=sys_article.member_id";		
			else $obj->where="sys_article_cat.catID=$catID AND sys_article.id =  sys_article_cat.artID AND match(sys_article.name) against('$keyword' in boolean mode) AND sys_member.id=sys_article.member_id";		 
			
			$obj->groupBy="sys_article.id";
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
		$obj->fieldsName="sys_function.name, sys_function.htaccess, sys_article_cat.artID, sys_article_cat.catID";
		$obj->tableName="sys_function, sys_article_cat";
		$obj->where="sys_function.id =  sys_article_cat.catID";
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
	//
	function arrListUser($all,$pageID,$limit=20){	
	
		global $db;
		$member_id=getSession("uid");	
		
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		
		$catID=getParamPost("catID");
		if(!$keyword){
			$obj->fieldsName="sys_article.*,sys_member.fistname, sys_member.lastname, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create";
			$obj->tableName="sys_article ,sys_article_cat, sys_member";		
					
			if(!$catID) $obj->where="sys_article.id =  sys_article_cat.artID AND sys_member.id=sys_article.member_id AND sys_article.member_id='".$member_id."'";
			else $obj->where="sys_article_cat.catID=$catID AND sys_article.id =  sys_article_cat.artID AND sys_member.id=sys_article.member_id AND sys_article.member_id='".$member_id."'";
			
			$obj->groupBy="sys_article.id";
			$obj->orderBy="sys_article.id DESC";						
		}else{		
			$obj->fieldsName="sys_article.*,sys_member.fistname, sys_member.lastname, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, match(sys_article.name) against('$keyword' in boolean mode) as relevance";
			$obj->tableName="sys_article ,sys_article_cat, sys_member";
			
			if(!$catID) $obj->where="sys_article.id =  sys_article_cat.artID AND match(sys_article.name) against('$keyword' in boolean mode) AND sys_member.id=sys_article.member_id AND sys_article.member_id='".$member_id."'";		
			else $obj->where="sys_article_cat.catID=$catID AND sys_article.id =  sys_article_cat.artID AND match(sys_article.name) against('$keyword' in boolean mode) AND sys_member.id=sys_article.member_id AND sys_article.member_id='".$member_id."'";		 
			
			$obj->groupBy="sys_article.id";
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
		$obj->fieldsName="sys_function.name, sys_function.htaccess, sys_article_cat.artID, sys_article_cat.catID";
		$obj->tableName="sys_function, sys_article_cat";
		$obj->where="sys_function.id =  sys_article_cat.catID";
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
	function checkFuncUrl($arr,$k){
		foreach($arr as $key=>$value){
			if($value["artID"]==$k) $name .= $value["htaccess"];
		}
	//	$name=substr($name, 0, (strlen($name)-1));
		return $name;
	}
	//
	function getArticleID($id){
		if(!$id) return;
		global $db;		
		loadClass("constructSql");
		$selectID = $selectID["selectID"];
		$obj=new constructSql();
		$obj->fieldsName="*,DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create";
		$obj->tableName="sys_article";
		//$obj->fieldsLang="sys_article";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function deleteArticle(){
		global $db;
		$id=getParamPost("id");
		if(!$id){			
			messange(_ERRO);
			listArticle();
			return;
		}		
		loadClass("constructSql");		
		$obj=new constructSql();				
		$obj->tableName="sys_article";
		$obj->where="sys_article.id =  $id";
		$obj->limit="all";		
		$sql=$obj->sqlDelete();	
		
		if(!$db->Execute($sql)){
			messange(_ERRO);
		}else{			
			messange(_DELETE_SUCCESSFU);
		}
		listArticle();
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
			$obj->tableName="sys_article";
			$obj->where="id=$value";
			$sql=$obj->sqlSelect();
			$rs=$db->Execute($sql);
			if(($rs->fields("img")) or ($rs->fields("img1"))){
				loadClass("fileSystem");
				$objs=new fileSystem();
				$objs->delFile(_DOMAIN_ROOT_PATH ."/images/article/".$rs->fields("img"));
				$objs->delFile(_DOMAIN_ROOT_PATH ."/images/article/".$rs->fields("img1"));
			}
			
			
			$obj->tableName="sys_article";
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
		listArticle();
	}
	//
	//
	function lockArticle(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_article SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_article WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	function duyetArticle(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_article SET active=IF(active=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_article WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/duyet/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
?>