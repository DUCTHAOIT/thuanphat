<?php
	function updateFaq(){
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
			$sql = "SELECT * FROM sys_faq WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);
			$return=$db->Execute($sql);
		}else{
			$sql = "SELECT * FROM sys_faq WHERE id=$id";
			$rs = $db->Execute($sql);
			$sql = $db->GetUpdateSQL($rs, $record);
			$return=$db->Execute($sql);	
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		if($return){
			$ret_page="?m=faq";
			$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
		}else{
			$ret_page="?m=faq&op=frm";
			$a=new msgBox(_ERRO,"OKOnly", "Message", array($ret_page), 1);
		}
		$a->showMsg();	
	}
	//
	function getFaqList(){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*, DATE_FORMAT(date, '".format_date()."') as date_create";
		$obj->tableName="sys_faq";
		$obj->limit="all";
		$obj->orderBy="date DESC";
		$sql=$obj->sqlSelect();	
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//	 
	function lockFaq(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_faq SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";		
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_faq WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
	//
	function deleteFaq(){
		global $db;
		$id=getParam("id");
		$sql="DELETE FROM sys_faq WHERE id=$id";
		$db->Execute($sql);
		faqList();
	}	
	//
	function faqID($id){
		global $db;
		$sql="SELECT * FROM sys_faq WHERE  id=$id";		
		$rs=$db->Execute($sql);
		return $rs->fields;
	}
?>