<?php
	function newsHomeScroll() {
		global $db,$smarty,$lable,$themeName,$arr_info_page,$lang;		
		
		$sql="SELECT sys_article.*, sys_function.htaccess FROM sys_article_cat,sys_article,sys_function WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=sys_function.id) AND (sys_function.ctrl&1=1) AND (sys_function.module='article') AND (sys_article.lang='$lang') AND (sys_article.ctrl&1=1) AND (sys_function.ctrl&1=1) ORDER BY sys_article.date_create DESC LIMIT 0,10";		
	
		$arr=$db->GetAssoc($sql);			
		$smarty->assign('arr',$arr);
		$smarty->assign('fid',$fid);
		$smarty->assign('theme',$themeName);			
		
		$smarty->assign('Detail',$lable->_("Detail"));	
		$smarty->assign('News',$lable->_("HighLights"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsHomeScrollers.tpl','newsHomeScrollers_');
	
	}		
?>
