<?php 	
	//
	function getProductSearch(){
		global $db, $lang;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParam("keyword");
		$catID=getParam("catID");
		
		if(!$keyword){
			$obj->fieldsName="sys_product.*, sys_function.name as nameCat, sys_function.". getSession("rewrite_url"). " as url";
			$obj->tableName="sys_product ,sys_function";		
					
			if(!$catID) $obj->where="sys_product.catID =  sys_function.id";
			else $obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id)";
			
			$obj->orderBy="sys_product.date_create DESC";						
		}else{		
			$obj->fieldsName="sys_product.*, sys_function.name as nameCat, match(sys_product.name) against('$keyword' in boolean mode) as relevance, sys_function.". getSession("rewrite_url"). " as url";
			$obj->tableName="sys_product ,sys_function";
			
			if(!$catID) $obj->where="(sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.summary) against('$keyword' in boolean mode))";		
			else $obj->where="(sys_product.catID=$catID) AND (sys_product.catID =  sys_function.id) AND (match(sys_product.name, sys_product.summary) against('$keyword' in boolean mode))";		 			
			
			$obj->orderBy="relevance DESC";				
		}
		$obj->fieldsLang="sys_product.";
		$obj->limit="All";		
		$sql=$obj->sqlSelect();
		//echo $sql."<br>";		
		$arr=$db->GetAll($sql);		
		return $arr;						
	}
	//
	//
	function getArticleSearch(){
		global $db,$lang;
		$keyword=getParam("keyword");
		if($keyword){
		$sql="SELECT sys_article.*,match(sys_article.name) against('$keyword' in boolean mode) as relevance";
		$sql.=" FROM sys_article";
		$sql.=" WHERE match(sys_article.name, sys_article.summary) against('$keyword' in boolean mode)";
		}else{
		$sql="SELECT sys_article.*";
		$sql.=" FROM sys_article";
		$sql.=" ORDER BY sys_article.id DESC";	
		}		
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}	
	function articleListSearch(){
		global $db,$lang;		
		
		$txtSearch=getParam("keyword");
		
		$sql="SELECT sys_article.*";
		$sql.=" FROM sys_article_cat , sys_article";
		$sql.=" WHERE sys_article_cat.artID =  sys_article.id AND sys_article.lang='$lang' AND sys_article.ctrl&1=1";	
		
		if($txtSearch){
			$sql.=" AND (match(name, summary) against('$txtSearch' in boolean mode))";
		}	
				
		$sql.=" ORDER BY sys_article.id DESC";		
		$arr=$db->GetAll($sql);			
		return $arr;		
	}	
	//
?>