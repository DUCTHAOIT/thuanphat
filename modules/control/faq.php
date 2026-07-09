<?php 
	function faq(){
		global $db, $lang,$smarty,$lable;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->tableName="sys_faq";
		$obj->limit="5";
		$obj->where = "ctrl&1=1";
		$obj->orderBy="date";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		if(!$arr) return;
		
		$smarty->assign('arr',$arr);
		$smarty->assign('Comment',$lable->_("Comment"));
			
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/faqhome.tpl','faqhome_');

	}
?>