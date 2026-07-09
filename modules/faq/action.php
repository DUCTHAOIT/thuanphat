<?php
function listFaq(){
	global $db;
	loadClass("constructSql");
	$obj=new constructSql();
	$obj->fieldsName="*, DATE_FORMAT(date, '".format_date()."') as date_create";
	$obj->tableName="sys_faq";
	$obj->limit="all";
	$obj->orderBy="id";
	$obj->where="(ctrl&1=1)";
	$sql=$obj->sqlSelect();		
	
	$arr=$db->GetAssoc($sql);
	return $arr;
}
function insertFaq(){
	global $db,$lang;	
	if(!$lang) $lang="vn";
	
	$name=getParamPost("name");	
	$email=getParamPost("email");	
	$question=getParamPost("question");
	
	$record = array();
	$record["name"] = $name;	
	$record["email"] = $email;	
	$record["question"] = $question;
	
	$record=array();
	$record["name"]=$name;
	$record["question"]=$question;
	$record["email"]=$email;
	$record["lang"]=$lang;		
	
	$sql = "SELECT * FROM sys_faq WHERE 0 = -1";
	$rs = $db->Execute($sql);
	$sql = $db->GetInsertSQL($rs, $record);
	$return=$db->Execute($sql);
		
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
	if(!$return){
		$ret_page="?m=faq";
		$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}else{
		$ret_page="?m=faq&mam=6";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}	
}
//
function getFaqID($id){
	global $db;
	$sql="SELECT *,DATE_FORMAT(date, '".format_date()."') as date_create FROM sys_faq WHERE id='$id'";
	$rs=$db->Execute($sql);
	$arr=$rs->fields;
	return $arr;	
}
	
?>