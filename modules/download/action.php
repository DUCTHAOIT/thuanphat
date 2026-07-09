<?php
	function getDownloadList($catID){
		global $db;		
		$keyworld=getParamPost("txtSearch");		
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_download.id, sys_download.ctrl, sys_function.name as topicName, sys_download.name, sys_download.file_name, sys_download.`no`, sys_download.catID";
		$obj->tableName="sys_function , sys_download";
		$obj->limit="all";
		$obj->orderBy="no";		
		if($catID) $sql="(sys_function.id =  sys_download.catID) AND (sys_function.id=$catID)";
		else $sql="(sys_function.id =  sys_download.catID)";
		if($keyworld) $sql.=" AND match(sys_download.name) against('$keyworld' in boolean mode)";		
		$obj->where=$sql;
		$obj->fieldsLang="sys_function.";
		$sql=$obj->sqlSelect();
		//echo $sql;
		$arr=$db->GetAssoc($sql);

		if(!$arr) return;
		
		foreach ($arr as $key=>$value){
			$arrs[$value["topicName"]][]=$value;	
		}		
		return $arrs;
	}
?>