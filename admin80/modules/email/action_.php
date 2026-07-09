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
		$content=getParamPost("content");
		$title=getParamPost("title");				
		$lang=getParamPost("lang");
				
		$uid=getSession("uid");		
		$id=getParamPost("id");			
		
		// tiep tuc cap nhat
		$record=array();
		$record["content"]=$content;		
		$record["title"]=$title;
		$record["lang"]=$lang;	
		
		
		// kiep tra dieu kien update hay insert
		if(!$id){
			$record["date"]=date("Y-m-d");	
			$record["uid"]=$uid;			
			$sql = "SELECT * FROM sys_htmlpage WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);		
			@$db->Execute($sql);			
		}else{
			$sql = "SELECT * FROM sys_htmlpage WHERE id=$id";
			$rs = @$db->Execute($sql);
			$sql = @$db->GetUpdateSQL($rs, $record);
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