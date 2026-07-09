<?php	
	switch ($op){
		case "productInfo"	: 	productInfo();break;
		case "productPhoto"	: 	productPhoto();break;
		case "productRelation"	: 	productRelation();break;
		case "download"		: 	download();break;
		default 			:	mainShow(); break;
	}
	//
	function mainShow(){
		global $smarty,$lable;
		include_once("header.php");		
		
		$idF=getparamFID(getParam(idF),false);	
		
		$product_id=getParam(_ID_PRODUCT);
		get_product_access($product_id);
		$urlshare=$_SERVER['REQUEST_URI'];
		
		$arr=get_product_id($product_id);	
		$arrColor=getProductListPhoto($arr["id"]);	
		$arrFile=getproductListFile($arr["id"]);
		
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
		$smarty->assign('urlshare',$urlshare);
		
		
		$smarty->assign('arrFile',$arrFile);
		//$smarty->registerPlugin("function","advertiseLeftFlashBig", "advertiseLeftFlashBig");
		
		
		$smarty->assign('Click_view_product',$lable->_("Click view product"));
		
		$smarty->assign('Product_Code',$lable->_("Product Code"));
		$smarty->assign('Type',$lable->_("Type"));
		$smarty->assign('Origin',$lable->_("Origin"));		
		$smarty->assign('Load',$lable->_("Load"));
		$smarty->assign('Height_increase',$lable->_("Height increase"));
		$smarty->assign('Working_regime',$lable->_("Working regime"));
		$smarty->assign('Power_work',$lable->_("Power work"));
		
		
		
		$smarty->assign('Relation_Product',$lable->_("Relation Product"));
		$smarty->assign('Delivery',$lable->_("Delivery"));
		$smarty->assign('Technical_data',$lable->_("Technical data"));
		$smarty->assign('Customer_feedback',$lable->_("Customer feedback"));
		$smarty->assign('Number_View',$lable->_("Number View"));
		$smarty->assign('InvestmentForm',$lable->_("Investment Form"));
		$smarty->assign('Owner',$lable->_("Owner"));
		$smarty->assign('Investmentposition',$lable->_("Investment Location"));
		$smarty->assign('Content',$lable->_("Contents"));
		$smarty->assign('Solution',$lable->_("Achiture & Construction"));
		$smarty->registerPlugin("function","productRelation", "productRelation");
		$smarty->registerPlugin("function","productRelation2", "productRelation2");		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/product_detail.tpl','product_detail_');	
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
	//
	function advertiseLeftFlashBig(){	
		global $smarty,$lable,$themeName,$lang;		
		$smarty->assign('Advertise',$lable->_("Advertise"));
		$smarty->assign('Orientation_for_growth',$lable->_("Orientation for growth"));
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/advertiseLeftFlashBig.tpl','advertiseLeftFlashBig_');	
	}
	//	
	function productRelation(){
		global $smarty,$lable,$themeName;
		$idProduct=getParam(_ID_PRODUCT);
		
		//$idF=getparamFID(getParam(idF),false);	
		
		if(!$idF=getParam("submenu")) $idF=getparamFID(getParam(idF),false);	
		
		$arrRelation=productListID($idF,11,1);
		if(count($arrRelation)>1){				
			$smarty->assign('arrRelation',$arrRelation);
			$smarty->assign('idProduct',$idProduct);			
			$smarty->assign('mark',getParam(_MARK));
			$smarty->assign('theme',$themeName);
			
			$smarty->assign('RelatedProducts',$lable->_("Related Products"));				
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productRelation.tpl','productRelation_'.$idProduct);
		}
	}
	//
	//	
	function productRelation2(){
		global $smarty,$lable,$themeName;
		$idProduct=getParam(_ID_PRODUCT);
		$idF=getparamFID(getParam(idF),false);	
		
		$arrRelation=productListID($idF,7,1);
		if(count($arrRelation)>1){				
			$smarty->assign('arrRelation',$arrRelation);
			$smarty->assign('idProduct',$idProduct);			
			$smarty->assign('mark',getParam(_MARK));
			$smarty->assign('theme',$themeName);
			
			$smarty->assign('RelatedTemplate',$lable->_("Related Template"));				
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/productRelation2.tpl','productRelation2_'.$idProduct);
		}
	}
	//
	function productListID($fid,$number_rows,$pageid){
		global $db,$lang;
		if(!$pageid or $pageid==1) $pageid=1;
		$start=($pageid-1)*$number_rows;
		$idProduct=getParam(_ID_PRODUCT);
		
		$sql="SELECT sys_product.*";
		$sql.=" FROM sys_product";
		$sql.=" WHERE sys_product.catID =  '$fid' AND (sys_product.ctrl&1=1) AND (sys_product.id<>$idProduct) AND (sys_product.lang = '$lang')";
		$sql.=" ORDER BY sys_product.date_create DESC LIMIT ".$start.",".$number_rows;
		
		$arr=$db->GetAssoc($sql);
		//print_r($arr);
		return $arr;
	}	
	//
	function download(){

		global $smarty,$lable,$themeName,$db,$lang;
		
		$filename = getParam("file");
		$download_path = "lib/";
		
		if(eregi("\.\.", $filename)) die("I'm sorry, you may not download that file.");
		$file = str_replace("..", "", $filename);
		// Make sure we can't download .ht control files.
		if(eregi("\.ht.+", $filename)) die("I'm sorry, you may not download that file."); // Combine the download path and the filename to create the full path to the file.
		$file = "$download_path$file";
		
		// Test to ensure that the file exists.
		if(!file_exists($file)) die("I'm sorry, the file doesn't seem to exist."); // Extract the type of file which will be sent to the browser as a header
		$type = filetype($file); // Get a date and timestamp	
		$today = date("F j, Y, g:i a");
		$time = time(); 
		// Send file headers
		header("Content-type: $type");
		header("Content-Disposition: attachment;filename=$filename");
		header("Content-Transfer-Encoding: binary");
		header('Pragma: no-cache');
		header('Expires: 0');// Send the file contents.
		set_time_limit(0);
		readfile($file); 
		return;
		
		// place this code inside a php file and call it f.e. "download.php"
		$path = "lib/";  // change the path to fit your websites document structure
		$fullPath = $path.getParam("file");
		 
		if ($fd = fopen ($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			
			$file_extension = strtolower(substr(strrchr(getParam("file"),"."),1));
		
			//This will set the Content-Type to the appropriate setting for the file
			switch( $file_extension ) {
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			case "mp3": $ctype="audio/mpeg"; break;
			case "wav": $ctype="audio/x-wav"; break;
			case "mpeg":
			case "mpg":
			case "mpe": $ctype="video/mpeg"; break;
			case "mov": $ctype="video/quicktime"; break;
			case "avi": $ctype="video/x-msvideo"; break;
			case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;
			
			default: $ctype="application/force-download";
			}
			
			header("Content-Type: $ctype");
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose ($fd);
		exit;
		// example: place this kind of link into the document where the file download is offered:
		// <a href="download.php?download_file=some_file.pdf">Download here</a>
	
		return;	
	}
?>