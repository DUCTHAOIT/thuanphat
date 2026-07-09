<?php
	function arrList(){
		global $db,$lang;
		$txtSearch=getParam("txtSearch");
		//echo getParam("txtSearch");					
		$sql="SELECT *, DATE_FORMAT(date,'".format_date()."') as date FROM sys_htmlpage WHERE (sys_htmlpage.title  LIKE  '%$txtSearch%') AND (lang='$lang')";
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function updateHtmlpage(){
		global $db;
		$content=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		// responsive img
		$foo = $content;
		$parsedFoo = json_decode(json_encode(simplexml_load_string($foo)), true);
		$newFoo = str_replace('src=', 'style="height:'.$parsedFoo['@attributes']['height'].'!important;width:'.$parsedFoo['@attributes']['width'].'!important;" src=', $foo);
		// responsive video youtube
		$search = ['<iframe', '</iframe>'];
		$replace   = ['<div class="youtube" style="text-align:center"><iframe', '</iframe></div>'];
		$content = str_replace($search, $replace, $newFoo);

		/////
		$title=getParamPost("title");				
		$lang=getParamPost("lang");
				
		$uid=getSession("uid");		
		$id=getParamPost("id");	
		
		$filePDF=getParamPost("filePDF");	
		
		
		if($filePDF){
			$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
			$to=_DOMAIN_ROOT_PATH."/lib/$filePDF";
			moveFile($from,$to);
		}
				
		
		// tiep tuc cap nhat
		$record=array();
		$record["content"]=$content;		
		$record["title"]=$title;
		$record["lang"]=$lang;	
		
		
		// kiep tra dieu kien update hay insert
		if(!$id){
			//$record["date"]=date("Y-m-d");
			$date=date("Y-m-d");	
			//$record["uid"]=$uid;			
			//$sql = "SELECT * FROM sys_htmlpage WHERE 0 = -1";
			//$rs = $db->Execute($sql);
			//$sql = $db->GetInsertSQL($rs, $record);		
			$sql="INSERT INTO sys_htmlpage (id,title,lang,member_id,content,date,pdf) VALUES (NULL,'$title','$lang','$uid','$content','$date','$filePDF')";
			@$db->Execute($sql);			
		}else{
			//$sql = "SELECT * FROM sys_htmlpage WHERE id=$id";
			//$rs = @$db->Execute($sql);
			//$sql = @$db->GetUpdateSQL($rs, $record);
			$sql="UPDATE sys_htmlpage SET title='$title',member_id='$uid',content='$content',lang='$lang',pdf='$filePDF' WHERE (id='$id')";		
			@$db->Execute($sql);			
		}	
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=htmlpage";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();		
	}
	//
	function getHtmlpageID($id){
		if(!$id) return;
		global $db;
		@include_once("classes/constructSql.class.php");		
		$obj=new constructSql();
		$obj->fieldsName="*";
		$obj->tableName="sys_htmlpage";
		$obj->where="(id=$id)";		
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$rs=$db->Execute($sql);		
		return $rs->fields;
	}
	//
	//
	function deleteHtmlpage(){
		global $db;
		$chkdelete=getParamPost("chkdelete");		
		//$id=getParamPost("id");
		if(!$chkdelete){			
			messange("Kh&#244;ng x&#243;a &#273;&#432;&#7907;c d&#7919; li&#7879;u!");
			listHtmlpage();
			return;
		}
		@include_once("classes/constructSql.class.php");	
		//loadClass("constructSql");
		$obj=new constructSql();				
		foreach($chkdelete as $key=>$value){
			$obj->tableName="sys_htmlpage";
			$obj->where="id = $value";
			$obj->limit="all";		
			$sql=$obj->sqlDelete();	
			$db->Execute($sql);
			//echo $sql;
		}
		
		/*
		if(!$db->Execute($sql)){
			messange("Kh&#244;ng x&#243;a &#273;&#432;&#7907;c d&#7919; li&#7879;u!");
		}else{			
			messange("D&#7919; li&#7879;u &#273;&#227; &#273;&#432;&#7907;c x&#243;a!");
		}
		*/
		listHtmlpage();
	}
?>