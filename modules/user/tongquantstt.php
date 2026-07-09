<?php 
	include_once("header.php");
			global $smarty,$db;
			
			
			$arrTSI=getTSI();
			$smarty->assign('arrTSI',$arrTSI);
			$arrTSITangGiam=getTSITangGiam();
			$smarty->assign('arrTSITangGiam',$arrTSITangGiam);
		
			
			
			$smarty->assign('navtstt',htmlcontent(130));
			$smarty->assign('danhmucdttstt',htmlcontent(129));
			
			include_once("modules/home/producthome.php");
			$smarty->registerPlugin("function","producthome","producthome");
			
			$smarty->registerPlugin("function","diendanmo","diendanmo");
			
			$smarty->assign('tongquan',htmlcontent(108));
			$smarty->assign('gioithieu',htmlcontent(125));
			$smarty->assign('thanhtuu',htmlcontent(126));
			
			$smarty->assign('dieukhoan',htmlcontent(116));
			$smarty->assign('chienluoc',htmlcontent(109));
			$smarty->assign('phuongphap',htmlcontent(110));
			$smarty->assign('danhmuc',htmlcontent(111));
			$smarty->assign('ruiro',htmlcontent(112));
			$smarty->assign('uudiem',htmlcontent(113));
			$smarty->assign('ndtsohuu',htmlcontent(114));
			$smarty->assign('faq',htmlcontent(152));
			
			$smarty->assign('cachtinhdvdt',htmlcontent(148));
			$smarty->assign('hoantravongop',htmlcontent(150));
			$smarty->assign('phanchialoinhuan',htmlcontent(140));
			$smarty->assign('hoahonggioithieu',htmlcontent(141));
			$smarty->assign('bieuphi',htmlcontent(142));
			$smarty->assign('ruirodieukhoan',htmlcontent(143));
			
			$smarty->registerPlugin("function","format_number", "format_number");
			$smarty->registerPlugin("function","format_number2", "format_number2");
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/tongquantstt.tpl','tongquantstt_');
			
	include_once("footer.php");
	
?>