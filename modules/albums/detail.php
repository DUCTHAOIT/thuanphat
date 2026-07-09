<?php	
	switch ($op){
		case "albumsInfo"	: 	albumsInfo();break;
		case "albumsPhoto"	: 	albumsPhoto();break;
		case "albumsRelation"	: 	albumsRelation();break;
		default 			:	mainShow(); break;
	}
	//
	function mainShow(){
		global $smarty,$lable;
		include_once("header.php");		
		
		$product_id=getParam(_ID_PRODUCT);
		get_albums_access($product_id);
		
		$arr=get_albums_id($product_id);	
		$arrColor=getalbumsListPhoto($arr["id"]);	
		
		$arrrelation=articleListID($arr["catID"]);		
		if(count($arrColor)){
			//$smarty->assign('arr',$arr);
			//print_r($arr);			
			$str="<script>\n";
			$str.=" var imgArray=[";
			foreach ($arrColor as $key=>$value){
				$sStr.="'"._DOMAIN_ROOT_URL."/img/albums/".$value["img1"]."$$$',";	
			}
			$str.= $sStr;
			$str.= "'"._DOMAIN_ROOT_URL."/img/albums/note.gif$$$'];\n </script>";
			echo $str;
		}
		//print_r($arrColor);
		
		$smarty->assign('arr',$arr);
		$smarty->assign('arrColor',$arrColor);
		$smarty->assign('arrrelation',$arrrelation);
		$smarty->assign('albums_review',albums_review($product_id));
		
		//$smarty->registerPlugin("function","advertiseLeftFlashBig", "advertiseLeftFlashBig");
		$smarty->registerPlugin("function","advertiseLeft", "advertiseLeft");
		
		$smarty->assign('Price',$lable->_("Price"));
		$smarty->assign('albumss_sold_in',$lable->_("albumss sold in"));
		$smarty->assign('Promotion',$lable->_("Promotion"));
		$smarty->assign('Description',$lable->_("Description"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Technical_data',$lable->_("Technical data"));
		$smarty->assign('Customer_feedback',$lable->_("Customer feedback"));
		//$smarty->assign('',$lable->_(""));		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/albums_detail.tpl','albums_detail_');	
		include_once("footer.php");
	}
	/**
	 * danh sach san pham da xem
	 *
	 * @param unknown_type $product_id
	 */
	function albums_review($product_id)
	{
		global $smarty,$db,$lable;
		if($product_id)
		{
			//unset($_SESSION["product_review"]);
			$_SESSION["albums_review"][$product_id] = $_SERVER['REQUEST_URI'];			
			
			$arr=$_SESSION["albums_review"];
			
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
				
				$arr_albums_review=$db->GetAssoc($sql);
				
				foreach($arr_albums_review as $key=>$value)
				{
					$arr_albums_review[$key]["url"] = $arr[$key];
				}				
				
				$smarty->assign('arr_albums_review',$arr_albums_review);
				
				$smarty->assign('Price',$lable->_("Price"));
				$smarty->assign('albumss_sold_in',$lable->_("albumss sold in"));
				$smarty->assign('Promotion',$lable->_("Promotion"));
				$smarty->assign('Delivery',$lable->_("Delivery"));
				$smarty->assign('albumss_you_have_viewed',$lable->_("albumss you have viewed"));						

				$smarty->registerPlugin("function","box_block_title", "box_block_title");
				$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/albums_review.tpl");
			}
		}
		unset($arr,$arr_albums_review);		
		return $output;
	}
	//
	//
	function advertiseLeftFlashBig(){	
		global $smarty,$lable,$themeName,$lang;		
		$smarty->assign('Advertise',$lable->_("Advertise"));
		$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeftFlashBig.tpl','advertiseLeftFlashBig_');	
	}
	//
	//
	function advertiseLeft(){	
		global $smarty,$lable,$themeName,$db,$lang;
		$sql="SELECT * FROM sys_advertise";
		$sql.=" WHERE (ctrl&1=1) AND lang='$lang'";
		$sql.=" ORDER BY no ASC LIMIT 0,16";
		$arrAd=$db->GetAssoc($sql);			
		
		$smarty->assign('theme',$themeName);
		$smarty->assign('arrAd',$arrAd);
		$smarty->assign('Advertise',$lable->_("Advertise"));
		$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeft.tpl','advertiseLeft_');	
	}
?>