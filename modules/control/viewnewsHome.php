<?php
		global $db,$smarty,$lable,$themeName,$arr_info_page,$lang;		
		$fid="0_62";
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_article";	
		$obj->where="ctrl&1=1";	
		$obj->orderBy="date_create DESC";
		$obj->limit="3";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);				
		$smarty->assign('arr',$arr);
		$smarty->assign('fid',$fid);
		$smarty->assign('theme',$themeName);	
		
		//$url="?m=article&"._MARK."=".$fid;
		if($lang=='vn'){
		$url=_DOMAIN_ROOT_URL."/trang-chu/tin-tuc/";
		}else{
		$url=_DOMAIN_ROOT_URL."/trang-chu/news/";
		}
		$smarty->assign('url',$url);	
		//$smarty->assign('News',$lable->_("News"));	
		$smarty->assign('Detail',$lable->_("Detail"));	
		$smarty->assign('News',$lable->_("HighLights"));	
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/newsHomeLeft.tpl','newsHomeLeft_');			
?>
