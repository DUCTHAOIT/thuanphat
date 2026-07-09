<?php
	switch ($op){
		case "about" : about(); break;		
		case "help" : help(); break;
		default: mainShow();
	}
	function mainShow(){	
		global $smarty, $lable, $db;
		include_once("header.php");
		
		$sql="SELECT COUNT(id) as soluong FROM user";
		$rs=$db->Execute($sql);
		$tongsoluonguser=$rs->fields("soluong");
		$smarty->assign("tongsoluonguser",$tongsoluonguser);
		
		$sql="SELECT COUNT(id) as soluong FROM user WHERE (user.ctrl=0)";
		$rs=$db->Execute($sql);
		$tongsoluongusernew=$rs->fields("soluong");
		$smarty->assign("tongsoluongusernew",$tongsoluongusernew);
		
		$sql="SELECT SUM(amount) AS total_sales FROM orders WHERE status = 'approved'";
		$rs=$db->Execute($sql);
		$tongdoanhthu=$rs->fields("total_sales");
		$smarty->assign("tongdoanhthu",$tongdoanhthu);

		$thuevat=$tongdoanhthu*0.08;
        $smarty->assign("thuevat",$thuevat);

        $khenthuong=$tongdoanhthu*0.02;
        $smarty->assign("khenthuong",$khenthuong);

        $thuongkhac=$tongdoanhthu*0.05;
        $smarty->assign("thuongkhac",$thuongkhac);

        $sql="SELECT SUM(commissions.amount) AS total_commissions FROM commissions, orders WHERE commissions.order_id = orders.id AND orders.status = 'approved'";
        $rs=$db->Execute($sql);
        $tonghoahong=$rs->fields("total_commissions");
        $smarty->assign("tonghoahong",$tonghoahong);

        //$conlai=$tongdoanhthu-$tonghoahong-$thuevat-$khenthuong-$thuongkhac;
        $conlai=$tongdoanhthu-$tonghoahong-$thuevat;
        $smarty->assign("conlai",$conlai);
		
		$smarty->assign('Access_history',$lable->_("Access history"));
		$smarty->assign('About',$lable->_("About"));
		$smarty->assign('Help',$lable->_("Help"));

		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/index.tpl','index_');	
		include_once("footer.php");
	}
	//
?>