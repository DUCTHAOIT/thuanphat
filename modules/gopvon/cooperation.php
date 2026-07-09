<?php	
	switch ($op){
		case "productInfo"	: 	productInfo();break;
		case "productPhoto"	: 	productPhoto();break;
		case "productRelation"	: 	productRelation();break;
		default 			:	mainShow(); break;
	}
	//
	function mainShow(){
		global $smarty,$lable;
		include_once("header.php");		
		
		$idF=getparamFID(getParam(idF),false);	
		
		$product_id=getParam(_ID_PRODUCT);
		get_product_access($product_id);
		
		$arr=get_product_id($product_id);	
		$arrColor=getProductListPhoto($arr["id"]);	
		
		$arrrelation=articleListID($arr["catID"]);		
		if(count($arrColor)){
			//$smarty->assign('arr',$arr);
			//print_r($arr);			
			$str="<script>\n";
			$str.=" var imgArray=[";
			foreach ($arrColor as $key=>$value){
				$sStr.="'"._DOMAIN_ROOT_URL."/img/product/".$value["img1"]."$$$',";	
			}
			$str.= $sStr;
			$str.= "'"._DOMAIN_ROOT_URL."/img/product/note.gif$$$'];\n </script>";
			echo $str;
		}
		//print_r($arrColor);
		$smarty->assign('nameFun',getFunctionNameSub($idF));
		$smarty->assign('email',getSession("email"));		
		$smarty->assign('arr',$arr);
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('arrrelation',$arrrelation);
		$smarty->assign('product_review',product_review($product_id));
		
		//$smarty->registerPlugin("function","advertiseLeftFlashBig", "advertiseLeftFlashBig");
		
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('Products_sold_in',$lable->_("Products sold in"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Technical_data',$lable->_("Technical data"));
		$smarty->assign('Customer_feedback',$lable->_("Customer feedback"));
		$smarty->assign('Number_View',$lable->_("Number View"));
		$smarty->assign('InvestmentForm',$lable->_("Investment Form"));
		$smarty->assign('Owner',$lable->_("Owner"));
		$smarty->assign('Investmentposition',$lable->_("Investment position"));
		$smarty->assign('Content',$lable->_("Content"));
		$smarty->assign('Solution',$lable->_("Solution"));
				
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_cooperation.tpl','product_cooperation_');	
		include_once("footer.php");
	}
	/**
	 * danh sach san pham da xem
	 *
	 * @param unknown_type $product_id
	 */
	function product_review($product_id)
	{
		global $smarty,$db,$lable;
		if($product_id)
		{
			//unset($_SESSION["product_review"]);
			$_SESSION["product_review"][$product_id] = $_SERVER['REQUEST_URI'];			
			
			$arr=$_SESSION["product_review"];
			
			if(count($arr)>1)
			{	
				foreach ($arr as $key=>$value)
				{
					if($key!=$product_id) $query_in.= "'".$key."',";
				}
				$query_in=substr($query_in, 0, strlen($query_in)-1);
				
				$sql="SELECT  sys_product.id, ".check_view_script("sys_product.name")." as name, ".check_view_script("sys_product.summary")." as summary, sys_product.price, sys_product.price_old, sys_product.img, sys_product.product_in, sys_product.delivery, sys_product.promotion, hang_san_xuat.logo";
				$sql.=" FROM hang_san_xuat , sys_product";
				$sql.=" WHERE hang_san_xuat.id =  sys_product.hang_san_xuat AND sys_product.id IN ($query_in)";				
				
				$arr_product_review=$db->GetAssoc($sql);
				
				foreach($arr_product_review as $key=>$value)
				{
					$arr_product_review[$key]["url"] = $arr[$key];
				}				
				
				$smarty->assign('arr_product_review',$arr_product_review);
				
				$smarty->assign('Price',$lable->_("Price"));
				$smarty->assign('Products_sold_in',$lable->_("Products sold in"));
				$smarty->assign('Promotion',$lable->_("Promotion"));
				$smarty->assign('Delivery',$lable->_("Delivery"));
				$smarty->assign('Products_you_have_viewed',$lable->_("Products you have viewed"));						

				$smarty->registerPlugin("function","box_block_title", "box_block_title");
				$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/product_review.tpl");
			}
		}
		unset($arr,$arr_product_review);		
		return $output;
	}
	//	
?>