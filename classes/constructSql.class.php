<?php
class constructSql{	
	var $tableName=null;
	var $fieldsName="*";
	var $where=null;
	var $orderBy=null;
	var $groupBy=null;
	var $limit=20;
	var $lowPriority=null;	
	var $fieldsLang=null;
	
	function sqlSelect(){
		try {
			$lang=getLang();
			$sql="SELECT $this->fieldsName FROM $this->tableName";
			$sql.="  WHERE (".$this->fieldsLang."lang='$lang')";
			if($this->where) $sql.=" AND $this->where";			
			if($this->groupBy) $sql.=" GROUP BY $this->groupBy";			
			if ($this->orderBy)$sql.=" ORDER BY $this->orderBy";
			if ((int)$this->limit > 0) $sql.=" LIMIT 0,$this->limit";			
			
			$this->defaultValue();
			return $sql;			
			
		}catch (Exception $e){
			echo _ERRO;
			$this->defaultValue();
			return;
		}
	}
	//
	function sqlDelete(){
		try {
			$sql="DELETE $this->lowPriority";
			$sql.=" FROM $this->tableName";
			$sql.=" WHERE $this->where";
			if ((int)$this->limit > 0) $sql.=" LIMIT (0,$this->limit)";			
			
			$this->defaultValue();
			return $sql;			
		}catch (Exception $e){
			echo _ERRO;
			$this->defaultValue();
			return;
		}
	}	
	/**
	 * Thuc thi cau truy van
	 *
	 * @param unknown_type $sSql
	 * @return unknown
	 */
	function runSql($sSql){
		global $db;
		$db->StartTrans(); 
	    $return=$db->Execute($sSql); 	    
	    $db->CompleteTrans(); 
	    if(!$return) $return = Err(_ERRO,false);
	    return $return;
	}
	/*
		lay lai gia tri default cho cac bien
	*/	
	function defaultValue(){
		$this->tableName=null;
		$this->fieldsName="*";
		$this->where=null;
		$this->orderBy=null;
		$this->groupBy=null;
		$this->limit=20;
		$lowPriority=null;
		$fieldsLang=null;
	}
}
?>	