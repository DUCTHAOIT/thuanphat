<?php
	function getGrouppartner($artID=""){
		global $db,$lang;		
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();		
		$obj->fieldsName="*";
		$obj->tableName="sys_function";
		$obj->where="(lang='$lang') AND (module='partner')";
		$obj->limit="all";
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);

		$sql="SELECt * FROM sys_partner_cat WHERE artID=$artID";	
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
		$sql="SELECt * FROM sys_partner_cat WHERE artID=$artID";	
		$arrCat=$db->getAssoc($sql);
		
		foreach ($arr as $key=>$value){
			if($arrCat[$key]) $arr[$key]["select"]="selected=\"selected\"";
			echo $arrCat[$key];
		}
		//print_r($arr);
		return $arr;		
	}	
	//
	function updatepartner(){
		global $db,$lang;
		$id=getParamPost("id");
		
		//if((!getParamPost("op")) ||(!getParamPost("name")) )return;	
		//if((!getParamPost("op")) ||(!getParamPost("summary")) )return;	
			
		$id=getParamPost("id");
		$name=getParamPost("name");
		//$name=getParamPost("summary");		
		$groupID=getParamPost("groupID");		
		$title_img=getParamPost("title_img");
		$summary=getParamPost("summary");
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
		
		$loiich=str_replace("'","&#8217;",getParamPost("contents"));// bo dau phay tren
		// responsive img
		$foo = $loiich;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$loiich = str_replace($search, $replace, $newFoo);
		////
		
		$ainenhoc=str_replace("'","&#8217;",getParamPost("content1"));// bo dau phay tren
		// responsive img
		$foo = $ainenhoc;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$ainenhoc = str_replace($search, $replace, $newFoo);
		////
		
		$giangvien=str_replace("'","&#8217;",getParamPost("content2"));// bo dau phay tren
		// responsive img
		$foo = $giangvien;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$giangvien = str_replace($search, $replace, $newFoo);
		////
		/////
		$noidung=str_replace("'","&#8217;",getParamPost("content3"));// bo dau phay tren
		// responsive img
		$foo = $noidung;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$noidung = str_replace($search, $replace, $newFoo);
		////
		
		$thongtin=str_replace("'","&#8217;",getParamPost("content4"));// bo dau phay tren
		// responsive img
		$foo = $thongtin;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$thongtin = str_replace($search, $replace, $newFoo);
		////
		
		$uudai=str_replace("'","&#8217;",getParamPost("content5"));// bo dau phay tren
		// responsive img
		$foo = $uudai;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$uudai = str_replace($search, $replace, $newFoo);
		////
		
	
		
		$content=getParam("content");
		$content=getParam("content");
		$content=getParam("content");
		
		$source=getParamPost("source");
		$date_create=getParamPost("date");
		//$lang=getParamPost("lang");		
		$img=getParamPost("fileName");
		$img1=getParamPost("fileName1");
		
		$special_promotion=getParamPost("special_promotion");
		
		if($special_promotion) $special_promotion = 1;
		else $special_promotion = 0;	
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img;
		$to=_DOMAIN_ROOT_PATH."/images/partner/".$img;
		moveFile($from,$to);
		
		$from=_DOMAIN_ROOT_PATH."/temp/".$img1;
		$to=_DOMAIN_ROOT_PATH."/images/partner/".$img1;
		moveFile($from,$to);	
		
		$filePDF=getParamPost("filePDF");
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}	
		
		loadClass("convertString");
		$obj= new convertString;
		$alias=$obj->remoteDiacritic($name);	
		
		if(!$id){
			$sql = "SELECT * FROM sys_partner WHERE 0 = -1";
			$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);				
			$sql = "INSERT INTO sys_partner ( name, alias, summary, content, source, img, img1, title_img, date_create, special_promotion, lang, loiich, ainenhoc, giangvien, noidung, thongtin, uudai, pdf ) VALUES ( '$name', '$alias', '$summary', '$content', '$source', '$img', '$img1', '$title_img', '$date_create', '$special_promotion', '$lang', '$loiich', '$ainenhoc', '$giangvien', '$noidung', '$thongtin', '$uudai', '$filePDF')";				
			$return=$db->Execute($sql);
			//neu insert thanh cong tin bai=> cap nhat nhom tin vao bang sys_partner_cat
			if($return){
				$idNew=$db->Insert_ID();
				foreach($groupID as $key=>$value){
					$sql="INSERT INTO sys_partner_cat(catID,artID) VALUES('$value','$idNew')";
					$return=$db->Execute($sql);
				}
			}			
		}else{
			$sql = "SELECT * FROM sys_partner WHERE id=$id";
			$rs = @$db->Execute($sql);
			//$sql = @$db->GetUpdateSQL($rs, $record);					
			$sql= "UPDATE sys_partner SET name = '$name', alias = '$alias', summary = '$summary', content = '$content', source = '$source', img = '$img', img1 = '$img1', title_img = '$title_img', date_create = '$date_create', special_promotion = '$special_promotion', loiich='$loiich', ainenhoc='$ainenhoc', giangvien='$giangvien', noidung='$noidung', thongtin='$thongtin', uudai='$uudai', pdf='$filePDF' WHERE id=$id";
			$return=$db->Execute($sql);
			//neu edit thanh cong tin=> cap nhat nhom tin  vao bang sys_partner_cat
			if($return){
				$sql="DELETE FROM sys_partner_cat WHERE artID='$id'";
				$db->Execute($sql);
				foreach($groupID as $key=>$value){
					$sql="INSERT INTO sys_partner_cat(catID,artID) VALUES('$value','$id')";
					$return=$db->Execute($sql);
				}
			}
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if(!$return){
			$ret_page="?m=partner&op=frm";
			$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}else{
			$ret_page="?m=partner";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}
	}
	//
	function arrList(){		
		global $db;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParamPost("keyword");
		
		$catID=getParamPost("catID");
		if(!$keyword){
			$obj->fieldsName="sys_partner.*, DATE_FORMAT(sys_partner.date_create, '".format_date()."') as date_create";
			$obj->tableName="sys_partner ,sys_partner_cat";		
					
			if(!$catID) $obj->where="sys_partner.id =  sys_partner_cat.artID";
			else $obj->where="sys_partner_cat.catID=$catID AND sys_partner.id =  sys_partner_cat.artID";
			
			$obj->groupBy="sys_partner.id";
			$obj->orderBy="sys_partner.id DESC";						
		}else{		
			$obj->fieldsName="sys_partner.*, DATE_FORMAT(sys_partner.date_create, '".format_date()."') as date_create, match(sys_partner.name) against('$keyword' in boolean mode) as relevance";
			$obj->tableName="sys_partner ,sys_partner_cat";
			
			if(!$catID) $obj->where="sys_partner.id =  sys_partner_cat.artID AND match(sys_partner.name) against('$keyword' in boolean mode)";		
			else $obj->where="sys_partner_cat.catID=$catID AND sys_partner.id =  sys_partner_cat.artID AND match(sys_partner.name) against('$keyword' in boolean mode)";		 
			
			$obj->groupBy="sys_partner.id";
			$obj->orderBy="relevance DESC";				
		}
		
		$sql=$obj->sqlSelect();		
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		if(!$arr) return;
		$obj->fieldsName="sys_function.name, sys_partner_cat.artID, sys_partner_cat.catID";
		$obj->tableName="sys_function, sys_partner_cat";
		$obj->where="sys_function.id =  sys_partner_cat.catID";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$topicArr=$db->GetAll($sql);
		if(!$topicArr) return;
		
		foreach($arr as $key=>$value){
			$topicName=checkFuncName($topicArr,$key);
			$arr[$key]["topicName"]= $topicName;
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
	function getpartnerID($id){
		if(!$id) return;
		global $db;		
		loadClass("constructSql");
		$selectID = $selectID["selectID"];
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_partner";
		//$obj->fieldsLang="sys_partner";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
	//
	function deletepartner(){
		global $db;
		$id=getParamPost("id");
		if(!$id){			
			messange(_ERRO);
			listpartner();
			return;
		}		
		loadClass("constructSql");		
		$obj=new constructSql();				
		$obj->tableName="sys_partner";
		$obj->where="sys_partner.id =  $id";
		$obj->limit="all";		
		$sql=$obj->sqlDelete();	
		
		if(!$db->Execute($sql)){
			messange(_ERRO);
		}else{			
			messange(_DELETE_SUCCESSFU);
		}
		listpartner();
	}
	//
	//
	function lockpartner(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_partner SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_partner WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
?>