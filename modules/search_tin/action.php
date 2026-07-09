<?php 	
	//
	function articleListSearch(){
		global $db, $lang;
		loadClass("constructSql");		
		$obj=new constructSql();
		$keyword=getParam("keyword");
		global $db,$lang;		
		
		$txtSearch=getParam("keyword");
		
		$sql="SELECT sys_article.*, sys_function.htaccess";
		$sql.=" FROM sys_article_cat , sys_article, sys_function";
		$sql.=" WHERE  sys_article_cat.artID =  sys_article.id AND sys_article_cat.catID =  sys_function.id AND sys_article.lang='$lang' AND sys_article.ctrl&1=1";
		
	//	if($txtSearch){
	//		$sql.=" AND (match(sys_article.name, sys_article.summary) against('$txtSearch' in boolean mode))";
	//	}	
		if($txtSearch){
			$sql.=" AND ((sys_article.name LIKE '%".$txtSearch."%') OR (sys_article.summary LIKE '%".$txtSearch."%'))";
		}	
		
		//echo $sql;		
		$sql.=" ORDER BY sys_article.id DESC";		
		$arr=$db->GetAll($sql);	
		return $arr;						
	}
	//
?>