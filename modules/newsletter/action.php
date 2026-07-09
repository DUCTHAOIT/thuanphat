<?php
function listNewsletter(){
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
function insertNewsletter(){
	global $db,$lang;	
	
	$email=getParamPost("email");	
	
	$record = array();	
	$record["email"] = $email;	
	
	$sql = "SELECT * FROM subscribers WHERE 0 = -1";
	$rs = $db->Execute($sql);
	$sql = $db->GetInsertSQL($rs, $record);
	$return=$db->Execute($sql);
		
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
	if(!$return){
		$ret_page="/";
		$a=new msgBox(_CANNOT_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}else{
		$ret_page="/";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);			
		$a->showMsg();
	}	
}	
?>