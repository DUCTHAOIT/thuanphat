<?php
	function productList($fid){
		global $db,$lang;
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product_cat , sys_product";
		$sql.=" WHERE sys_product_cat.catID = ".$fid." AND sys_product_cat.proID =  sys_product.id AND (sys_product.ctrl&1=1)";
		//$sql.=" WHERE (ctrl&1=1) AND (lang='$lang')";
		$sql.=" ORDER BY sys_product.date_create DESC LIMIT 0,6";		
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}	
	//
	function articleHomeList($catID){
		global $db;
		$sql="SELECT sys_article.id,sys_article.alias,sys_article.name,sys_article.summary,sys_article.img,sys_article_cat.catID";
		$sql.=" FROM sys_article_cat,sys_article";
		$sql.=" WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=".$catID.") AND (sys_article.ctrl&1=1)";
		$sql.=" ORDER BY date_create DESC LIMIT 0,6";		
		$arr=$db->GetAssoc($sql);		
		return $arr;		  
	}
	//
	function advertiseList(){
		global $db;
		$sql="SELECT * FROM sys_partner";
		$sql.=" WHERE (ctrl&1=1)";
		$sql.=" ORDER BY no DESC LIMIT 0,3";
		$arr=$db->GetAssoc($sql);		
		return $arr;			  
	}
	//
	function getHtmlpageID($id){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_htmlpage";		
		$obj->where="id=$id";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$rs=$db->Execute($sql);		
		$arr=$rs->fields;		
		return $arr;
	}	
?>