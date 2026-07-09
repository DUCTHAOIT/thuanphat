<?php
	function updatecommentarticle(){
		global $db;		
		
		$id=getParamPost("id");
		$subject=getParamPost("subject");
		$question=getParamPost("question");
		$answer=getParamPost("answer");		
		$lang=getParamPost("lang");	
		
		$record=array();
		$record["subject"]=$subject;
		$record["question"]=$question;
		$record["answer"]=$answer;		
		$record["lang"]=$lang;	
		$record["ctrl"]=1;
		
		if(!$id){			
			$sql = "SELECT * FROM sys_commentarticle WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_commentarticle WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=commentarticle";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=commentarticle&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getcommentarticleList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_commentarticle.*, sys_article.name as articlename, DATE_FORMAT(sys_commentarticle.date, '".format_date()."') as date_create";
		$obj->tableName="sys_commentarticle, sys_article";
		$obj->fieldsLang="sys_commentarticle";
		$obj->where="sys_commentarticle.proid=sys_article.id";
		$obj->limit="all";
		$obj->orderBy="sys_commentarticle.id DESC";
		$sql=$obj->sqlSelect();				
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockcommentarticle(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_commentarticle SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_commentarticle WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function deletecommentarticle(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_commentarticle WHERE id=$id";
		$db->Execute($sql);
		commentarticleList();
	}	
	//
	function commentarticleID($id){
		global $db;
		$sql="SELECT * FROM sys_commentarticle WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
?>