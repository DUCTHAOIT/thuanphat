<?php
	switch ($op){	
		
		//case "view_detail_order":	view_detail_order(); break;
		case "add_basket"		: 	add_basket(); break;		
		case "view_basket"		: 	view_basket(); break;
		case "edit_basket"		: 	edit_basket(); break;
		case "delete_basket"	: 	delete_basket(); break;
		
		case "optioncheckout" 	: optionCheckOut(); break;	
		case "infomember"		: infoMember();break;	
		case "login"			: loginOrder();break;
		case "sorder" 			: saveOrderToDatabase(); break;		
		
		default 				: main_show(); break;
	}
	//
	function main_show(){
		global $smarty, $lable;		
		$smarty->registerPlugin("function","converMoney", "do_converMoney");
		$arr=$_SESSION["ssorder"];
		if($arr){
			$smarty->assign('arr', $arr);
			$smarty->assign('basketInfo', $lable->_("Basket info"));
			$smarty->assign('Name', $lable->_("Product name"));
			$smarty->assign('Price', $lable->_("Price"));
			$smarty->assign('Quality', $lable->_("Quality"));
			$smarty->assign('Total', $lable->_("Total"));
			$smarty->assign('Detail', $lable->_("Detail"));
			
			$smarty->registerPlugin("function","format_number", "format_number");
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket_count.tpl','basket_count_');
		}else{
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"> <tr><td align=\"center\" style=\"padding-top:30px\"><img src=\"theme/default/images/hoala.gif\" /></td></tr></table>";
		}
	}
	/**
	 * Them san pham vao gio hang
	 *
	 * @return unknown
	 */
	function add_basket(){		
		global $smarty,$lang,$lable;
		
		$product_id=getParam("product_id");
		
		//$color=getParam("color");
		//$size=getParam("size");		
		$txt_add_basket=getParam("qty");		
		//echo "abc".$product_id.$color.$size.$txt_add_basket;
		if(!$txt_add_basket) $txt_add_basket=1;
		
		if($product_id){
	
			if($_SESSION["basket"][$product_id]){
				$_SESSION["basket"][$product_id]["quantity"]=$_SESSION["basket"][$product_id]["quantity"] + $txt_add_basket;
			
			}else{	
				$_SESSION["basket"][$product_id]=array(				
					"quantity"=>(int)$txt_add_basket				
				);
			}
			//$_SESSION["basket"][$product_id]["color"]=$color;
			//$_SESSION["basket"][$product_id]["size"]=$size;
			
		}	
		
		$count_basket=count($_SESSION["basket"]);
		echo $count_basket; 
	}	 

	//
	function view_basket_popup()
	{		
		
		global $smarty,$lang,$lable;
		$arrProductBasket=getProductBasket();

		//print_r($arrProductBasket);
		if($arrProductBasket){
			$smarty->assign('arrProductBasket',$arrProductBasket);
			$smarty->assign('themeName',$themeName);
			$smarty->assign('lang',$lang);
			$smarty->assign("Product_name",$lable->_("Product name"));
			$smarty->assign("Price",$lable->_("Price"));
			$smarty->assign("Amount",$lable->_("Amount"));	
			$smarty->assign("Total",$lable->_("Total"));			
			$smarty->registerPlugin("function","format_number", "format_number");
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket_list_popup.tpl','basket_list_');
		}
		else {
			echo '<div style="text-align:center; padding-top:100px; padding-bottom: 100px; color:#8D0100"><b>'.$lable->_("No products in cart").'</b></div>';
		}				
	
	}
	//
	function view_basket()
	{

		include_once("header.php");

		global $smarty,$lang,$lable,$mysqli;
		$arrProductBasket=getProductBasket();
        $username=getSession("username");
        if($username){
            $cmt=getMemberNameID($username,"cmt");
            $img=getMemberNameID($username,"img");
            $img1=getMemberNameID($username,"img1");
            $smarty->assign('username',$username);
            $smarty->assign('cmt',$cmt);
            $smarty->assign('img',$img);
            $smarty->assign('img1',$img1);

            // Số dư điểm thẻ/ví + % giới hạn thanh toán bằng thẻ, hiển thị cho khách chọn nguồn thanh
            // toán (mục 3 BUSINESS_RULES.md, cập nhật 2026-07-11)
            $memberId=(int)getMemberNameID($username,"id");

            $stmt=$mysqli->prepare("SELECT balance FROM consumption_cards WHERE user_id = ?");
            $stmt->bind_param("i",$memberId);
            $stmt->execute();
            $cardBalance=(float)($stmt->get_result()->fetch_assoc()['balance'] ?? 0);
            $stmt->close();

            $stmt=$mysqli->prepare("SELECT tieu_dung, kha_dung FROM user_wallets WHERE user_id = ?");
            $stmt->bind_param("i",$memberId);
            $stmt->execute();
            $walletRow=$stmt->get_result()->fetch_assoc();
            $tieuDungBalance=(float)($walletRow['tieu_dung'] ?? 0);
            $khaDungBalance=(float)($walletRow['kha_dung'] ?? 0);
            $stmt->close();

            $stmt=$mysqli->prepare("SELECT value FROM sys_config WHERE name = 'card_payment_percent' AND lang = 'vn'");
            $stmt->execute();
            $cardPaymentPercent=(float)($stmt->get_result()->fetch_assoc()['value'] ?? 100);
            $stmt->close();

            // Giao (intersection) nguồn thanh toán được TẤT CẢ sản phẩm trong giỏ hàng chấp nhận (mục 3
            // BUSINESS_RULES.md, cập nhật 2026-07-11) - chỉ hiện checkbox cho nguồn nào cả giỏ đều chấp nhận
            $acceptedSources=getAcceptedPaymentSources();

            $smarty->assign('cardBalance',$cardBalance);
            $smarty->assign('tieuDungBalance',$tieuDungBalance);
            $smarty->assign('khaDungBalance',$khaDungBalance);
            $smarty->assign('cardPaymentPercent',$cardPaymentPercent);
            $smarty->assign('acceptCard',$acceptedSources['accept_card']);
            $smarty->assign('acceptTieuDung',$acceptedSources['accept_tieu_dung']);
            $smarty->assign('acceptKhaDung',$acceptedSources['accept_kha_dung']);
        }
		if($arrProductBasket){
			$smarty->assign('arrProductBasket',$arrProductBasket);
			$smarty->assign('themeName',$themeName);
			$smarty->assign('lang',$lang);
			$smarty->assign("Name",$lable->_("Name"));
			$smarty->assign("Price",$lable->_("Price"));
			$smarty->assign("Amount",$lable->_("Amount"));	
			$smarty->assign("Total",$lable->_("Total"));	
			$smarty->assign("Mobile",$lable->_("Mobile"));	
			$smarty->assign("Address",$lable->_("Address"));	
			$smarty->assign("Content",$lable->_("Content"));	
			$smarty->assign("Order",$lable->_("Order"));
			$smarty->assign("Total",$lable->_("Total"));
			$smarty->assign("Number",$lable->_("The number of products"));
			$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket_list.tpl','basket_list_');
		}
		else {
			echo '<div style="text-align:center; padding-top:100px; padding-bottom: 100px; color:#8D0100"><b>Không có sản phẩm nào trong giỏ hàng</b></div>';
		}				
		include_once("footer.php");
	}
	
	function edit_basket(){	
		$product_id= getParamPost("product_id");
		$quantity= getParamPost("quantity".$product_id);
		$_SESSION["basket"][$product_id]["quantity"]=$quantity;		
		header("Location: "._DOMAIN_ROOT_URL."/view_basket/");
		
	}
	//
	function delete_basket(){		
		$product_id= getParamPost("product_id");
		unset($_SESSION["basket"][$product_id]);		
		header("Location: "._DOMAIN_ROOT_URL."/view_basket/");
	}
	//
	function optionCheckOut(){
	
		$product_id=getParamPost("product_id");
		$quantity=getParamPost("quantity");
		for($i=0;$i<count($product_id); $i++){
			if($_SESSION["basket"][$product_id[$i]]){
				$_SESSION["basket"][$product_id[$i]]["quantity"]=$quantity[$i];
			}
		}
		if (getSession("username"))
			{
			 header("Location: "._DOMAIN_ROOT_URL."/infomember_basket/");
			}
		include_once "header.php";
		global $smarty,$lang;	
		$smarty->assign('Username',$lable->_("Username"));
		$smarty->assign('Password',$lable->_("Password"));
		$smarty->assign('Information_login',$lable->_("Information login"));
		$smarty->assign('Note',$lable->_("Note"));
		$smarty->assign('Your_Visitors_Cart',$lable->_("Your Visitors Cart contents will be merged with your Members Cart contents once you have logged on."));
		$smarty->assign('New_Customer',$lable->_("New Customer"));
		$smarty->assign('I_am_a_new_customer',$lable->_("I am a new customer"));
		$smarty->assign('Proceed_Directly_to_Checkout',$lable->_("Proceed Directly to Checkout"));
		$smarty->assign('Proceed_to_Checkout_without',$lable->_("Proceed to Checkout without creating an account. By choosing this option none of your user information will be kept in our records, and you will not be able to review your order status, nor keep track of your previous orders."));
		//$smarty->assign('',$lable->_(""));	
	
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basketOptionCheckOut.tpl','basketOptionCheckOut_');	
		include_once "footer.php";	
	}
	//
	//
	function loginOrder(){
		global $db;	
		
			$username=getParamPost("username");
			$password=getParamPost("password");		
			
			$sql="SELECT * FROM user WHERE username='$username' AND password=md5('$password')";
	
			$rs = $db->Execute($sql);		
			include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
			
			$ret_page=""._DOMAIN_ROOT_URL."/basket/";		
			if($rs->fields("username")){
				setSession("username",$rs->fields("username"));														
				header("Location: "._DOMAIN_ROOT_URL."/infomember_basket/");
				//header("Location: ?m=basket&op=infomember");
				//$a=new msgBox("Please wait...","OKOnly", "Message", array($ret_page), 1);			
				//$a->showMsg();			
			}
			$ret_page=getParamPost("ret_page");				
			$a=new msgBox("Login false!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
	}
	//
	//
	function infoMember(){
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		if (!getSession("username")){
			$ret_page="?m=basket&op=optioncheckout";
			$a=new msgBox("False...!","OKOnly", "Message", array($ret_page), 1);			
			$a->showMsg();
		}	
		global $db, $smarty, $lable;
		include_once "header.php";
		
		
		
		$smarty->registerPlugin("function","converMoney", "do_converMoney");
		
		$sql="SELECT * FROM user WHERE username='".getSession("username")."'";
		$rs = $db->Execute($sql);	
		$arrs=$rs->fields;	
		
		$smarty->assign('Payment_Method',$lable->_("Payment Method"));
		$smarty->assign('Credit_Card',$lable->_("Credit Card"));
		$smarty->assign('Cash_on_Delivery',$lable->_("Cash on Delivery"));
		$smarty->assign('Add_Comments_About_Your_Order',$lable->_("Add Comments About Your Order"));
		$smarty->assign('Total',$lable->_("Total"));
		
	
		$smarty->assign('Shipping_Address',$lable->_("Shipping Address"));
		$smarty->assign('Fullname',$lable->_("Fullname"));
		$smarty->assign('Telephone',$lable->_("Telephone"));
		$smarty->assign('Company_Name',$lable->_("Company Name"));
		$smarty->assign('Street_Address',$lable->_("Street Address"));
		$smarty->assign('Postcode',$lable->_("Postcode"));
		$smarty->assign('Product',$lable->_("Product"));
		$smarty->assign('City_Province_Country',$lable->_("City - Province - Country"));
		
		
		
		$smarty->assign('arr',$arrs);	
		$smarty->assign('basketInfoMember',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketInfoMember.tpl'));
		
		
		if($_SESSION["basket"]){
		foreach ($_SESSION["basket"] as $key=>$value){			
				if($value["parent"]==0){
					$arr[$key]=$_SESSION["basket"][$key];
				}
				$arrAll[$value["parent"]][]= $key;
				$s_id.="'".$key."',";
			}		
	
			$s_id=substr($s_id, 0, strlen($s_id)-1);
			$sql="SELECT * FROM sys_product WHERE sys_product.id IN($s_id)";
			$arrProduct=$db->GetAssoc($sql);
			if($arr){
			foreach ($arr as $key=>$value){			
				$record["name"]=$arrProduct[$key]["name"];
				$record["img"]=$arrProduct[$key]["img"];
				$record["quanlity"]=$_SESSION["basket"][$key]["quantity"];
				$record["price"]=$arrProduct[$key]["price"];
				$record["price_old"]=$arrProduct[$key]["price_old"];
				$record["level"]=0;
				$arrView[$key]=$record;
				//dua do an phu vao mang
				if($arrAll[$key]){
					foreach($arrAll[$key] as $keys=>$values){
						$record["name"]=$arrProduct[$values]["name"];
						$record["img"]=$arrProduct[$values]["img"];
						$record["quanlity"]=$_SESSION["basket"][$values]["quantity"];
						$record["price"]=$arrProduct[$values]["price"];
						$record["price_old"]=$arrProduct[$values]["price_old"];
						$record["level"]=1;
						$arrView[$values]=$record;
					}
				}
			}
			}
		
		$arr=$arrView;
		}
		if($arrView){
			$smarty->assign('arr', $arrView);	
			$smarty->assign('basketInfo',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketInfo.tpl'));
		}else{
			$smarty->assign('basketInfo',"<div style=\"color:#FF0000; padding-top:20px; text-align:center\">".$lable->_("Please choice product to basket")."</div>");
		}	
				
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket.tpl','basket_');
		include_once "footer.php";
	}
	//
	function saveOrderToDatabase(){
		include_once("header.php");	
		include('phpmailer/class.smtp.php');
		include "phpmailer/class.phpmailer.php"; 
		include_once("phpmailer/config.php");
		global $db, $lable, $smarty;
		
		$ord_name=getParamPost("ord_name");					
		$ord_gender=getParamPost("ord_gender");
		$ord_address=getParamPost("ord_address");
		$ord_email=getParamPost("ord_email");
		$ord_phone=getParamPost("ord_phone");		
		$ord_mobile=getParamPost("ord_mobile");	
		$ord_otherinfo=getParamPost("ord_otherinfo");		
		
		$ord_sname=getParamPost("ord_sname");		
		$ord_sgender=getParamPost("ord_sgender");
		$ord_saddress=getParamPost("ord_saddress");	
		$ord_semail=getParamPost("ord_semail");	
		$ord_sphone=getParamPost("ord_sphone");	
		$ord_smobile=getParamPost("ord_smobile");	
		$ord_sfax=getParamPost("ord_sfax");	
		$ord_sotherinfo=getParamPost("ord_sotherinfo");	
		
		$ord_delivery=getParamPost("ord_delivery");
		$ord_date=getParamPost("ord_date");
		$ord_month=getParamPost("ord_month");
		$ord_year=getParamPost("ord_year");
		$ord_payment=getParamPost("ord_payment");
			
		$date=date("Y-m-d");
			
		$timeOder=$ord_date."-".$ord_month."-".$ord_year;


        //// upload img
        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = _DOMAIN_ROOT_PATH . '/images/order/';
            $ext = strtolower(pathinfo($_FILES['imageUpload']['name'], PATHINFO_EXTENSION));
            $filename = time() . '_' . uniqid() . '.' . $ext;

            // Chỉ cho phép một số loại file ảnh
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadDir . $filename);
                $fileName = $filename;
            } else {
                $fileName = ''; // File không hợp lệ
            }
        } else {
            // Nếu không upload mới, dùng ảnh cũ
            $fileName = $_POST['fileName'] ?? '';
        }
        $img=$fileName;
        /// ket thuc upload img

		
		$arrProductBasket=getProductBasket();
		$smarty->assign('arrProductBasket', $arrProductBasket);	
		
		$smarty->assign('basketInfo', $lable->_("Basket info"));
		$smarty->assign('Name', $lable->_("Product name"));
		$smarty->assign('Price', $lable->_("Price"));
		$smarty->assign('Quality', $lable->_("Quality"));
		$smarty->assign('Total', $lable->_("Total"));
		$smarty->assign('Detail', $lable->_("Detail"));
		$smarty->assign('basketInfo',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketInfo.tpl'));
	
		$smarty->assign('date', date("F j, Y, g:i a"));
		
		$smarty->assign('Information_basket', $lable->_("Information basket"));
		$smarty->assign('Information_date', $lable->_("Information date"));
		$smarty->assign('Product', $lable->_("Product"));
		$smarty->assign('Information_member', $lable->_("Information member"));
		$smarty->assign('Thansk', $lable->_("Thansk"));
		
		$smarty->assign('ord_name',$ord_name);
		$smarty->assign('ord_gender',$ord_gender);
		$smarty->assign('ord_address',$ord_address);
		$smarty->assign('ord_email',$ord_email);
		$smarty->assign('ord_phone',$ord_phone);
		$smarty->assign('ord_mobile',$ord_mobile);
		$smarty->assign('ord_fax',$ord_fax);
		$smarty->assign('ord_otherinfo',$ord_otherinfo);
		
		$smarty->assign('ord_sname',$ord_sname);
		$smarty->assign('ord_sgender',$ord_sgender);
		$smarty->assign('ord_saddress',$ord_saddress);
		$smarty->assign('ord_semail',$ord_semail);
		$smarty->assign('ord_sphone',$ord_sphone);
		$smarty->assign('ord_smobile',$ord_smobile);
		$smarty->assign('ord_sotherinfo',$ord_sotherinfo);		
		
		$smarty->assign('ord_delivery',$ord_delivery);
		$smarty->assign('timeOder',$timeOder);
		$smarty->assign('date',$date);
		$smarty->assign('ord_payment',$ord_payment);
			
		$content= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketSendMail.tpl');		
	
		$TEXT="";
		$HTML="<span>";
		$HTML.=$content;
		$HTML.="</span>";
		
		
		$emailFrom		=$ord_email;
		$nameFrom		=$ord_name;			
		$emailTo      	= getSession("email");		
		$nameTo			= getSession("email");			
		$subject 		= "Đặt hàng";	
		
		
		$sql ="INSERT INTO sys_order(des,email,name,address,content,sdate,img) VALUES ('$content','$ord_email','$ord_name','$ord_address','$ord_otherinfo','$date','$img')";
		$return=$db->Execute($sql);
		
		
		$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc='', $emailFrom, $nameFrom);
		if($mail==1){
			sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc='', $emailTo, $nameTo);
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>Đơn hàng của quý khách đã được đặt thành công, chúng tôi sẽ liên hệ lại ngay với quý khách</strong></div>";	
		}else{
			echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
		<strong>".$lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever")." </strong>
		</div>";
		}
		unset($_SESSION["basket"]);		
		session_destroy();
		include_once("footer.php");
		
	}
	//
	function saveOrderToDatabase__(){
		global $db, $lable, $smarty;
		
		$ord_name=getParamPost("ord_name");					
		$ord_gender=getParamPost("ord_gender");
		$ord_address=getParamPost("ord_address");
		$ord_email=getParamPost("ord_email");
		$ord_phone=getParamPost("ord_phone");		
		$ord_mobile=getParamPost("ord_mobile");		
		$ord_fax=getParamPost("ord_fax");		
		$ord_otherinfo=getParamPost("ord_otherinfo");		
		
		$ord_sname=getParamPost("ord_sname");		
		$ord_sgender=getParamPost("ord_sgender");
		$ord_saddress=getParamPost("ord_saddress");	
		$ord_semail=getParamPost("ord_semail");	
		$ord_sphone=getParamPost("ord_sphone");	
		$ord_smobile=getParamPost("ord_smobile");	
		$ord_sfax=getParamPost("ord_sfax");	
		$ord_sotherinfo=getParamPost("ord_sotherinfo");	
		
		$ord_delivery=getParamPost("ord_delivery");
		$ord_date=getParamPost("ord_date");
		$ord_month=getParamPost("ord_month");
		$ord_year=getParamPost("ord_year");
		$ord_payment=getParamPost("ord_payment");
			
		$date=date("Y-m-d");
			
		$timeOder=$ord_date."-".$ord_month."-".$ord_year;
	
			
		// cap nhat thong tin don hang vao bang sys_order_detail		
		//print_r($_SESSION["basket"]);
		if($_SESSION["basket"]){
		foreach ($_SESSION["basket"] as $key=>$value){			
				if($value["parent"]==0){
					$arr[$key]=$_SESSION["basket"][$key];
				}
				$arrAll[$value["parent"]][]= $key;
				$s_id.="'".$key."',";
			}		
	
			$s_id=substr($s_id, 0, strlen($s_id)-1);
			$sql="SELECT * FROM sys_product WHERE sys_product.id IN($s_id)";
			$arrProduct=$db->GetAssoc($sql);
	
			foreach ($arr as $key=>$value){			
				$record["basketID"] = $basketID;	
				$record["proid"] = $key;
				$record["name_product"]=$arrProduct[$key]["name"];
				//$record["level"]=0;
				$record["quanlity"]=$_SESSION["basket"][$key]["quantity"];
				$record["price"]=$arrProduct[$key]["price"];
				$record["img"]=$arrProduct[$key]["img"];
				$record["price_old"]=$arrProduct[$key]["price_old"];			
				$sql = "SELECT * FROM sys_order_detail WHERE 0 = -1";
				$rs = $db->Execute($sql);
				$sql = $db->GetInsertSQL($rs, $record);			
				$resurn=$db->Execute($sql);
				unset($record);
				}
		}
		
		////////////////
		if($_SESSION["basket"]){
			foreach ($_SESSION["basket"] as $key=>$value){			
				if($value["parent"]==0){
					$arr[$key]=$_SESSION["basket"][$key];
				}
				$arrAll[$value["parent"]][]= $key;
				$s_id.="'".$key."',";
			}		
	
			$s_id=substr($s_id, 0, strlen($s_id)-1);
			$sql="SELECT * FROM sys_product WHERE sys_product.id IN($s_id)";
			$arrProduct=$db->GetAssoc($sql);
			if($arr){
			foreach ($arr as $key=>$value){			
				$record["name"]=$arrProduct[$key]["name"];
				$record["img"]=$arrProduct[$key]["img"];
				$record["quanlity"]=$_SESSION["basket"][$key]["quantity"];
				$record["price"]=$arrProduct[$key]["price"];
				$record["price_old"]=$arrProduct[$key]["price_old"];
				$record["level"]=0;
				$arrView[$key]=$record;
				//dua do an phu vao mang
				if($arrAll[$key]){
					foreach($arrAll[$key] as $keys=>$values){
						$record["name"]=$arrProduct[$values]["name"];
						$record["img"]=$arrProduct[$values]["img"];
						$record["quanlity"]=$_SESSION["basket"][$values]["quantity"];
						$record["price"]=$arrProduct[$values]["price"];
						$record["price_old"]=$arrProduct[$values]["price_old"];
						$record["level"]=1;
						$arrView[$values]=$record;
					}
				}
			}
		}
		
		//$arr=$arrView;
	
		/////////////////
		
		//$sql="SELECT proid, name_product as name, fid, quality, price, img FROM sys_order_detail WHERE basketID='$basketID'";
		//$arr = $db->GetAssoc($sql);	
		$smarty->assign('arr', $arrView);	
		}
		$smarty->assign('basketInfo', $lable->_("Basket info"));
		$smarty->assign('Name', $lable->_("Product name"));
		$smarty->assign('Price', $lable->_("Price"));
		$smarty->assign('Quality', $lable->_("Quality"));
		$smarty->assign('Total', $lable->_("Total"));
		$smarty->assign('Detail', $lable->_("Detail"));
	
		$smarty->assign('basketInfo',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketInfo.tpl'));
		
		$smarty->assign('date', date("F j, Y, g:i a"));
		
		$smarty->assign('Information_basket', $lable->_("Information basket"));
		$smarty->assign('Information_date', $lable->_("Information date"));
		$smarty->assign('Product', $lable->_("Product"));
		$smarty->assign('Information_member', $lable->_("Information member"));
		$smarty->assign('Thansk', $lable->_("Thansk"));
		
		$smarty->assign('ord_name',$ord_name);
		$smarty->assign('ord_gender',$ord_gender);
		$smarty->assign('ord_address',$ord_address);
		$smarty->assign('ord_email',$ord_email);
		$smarty->assign('ord_phone',$ord_phone);
		$smarty->assign('ord_mobile',$ord_mobile);
		$smarty->assign('ord_fax',$ord_fax);
		$smarty->assign('ord_otherinfo',$ord_otherinfo);
		
		$smarty->assign('ord_sname',$ord_sname);
		$smarty->assign('ord_sgender',$ord_sgender);
		$smarty->assign('ord_saddress',$ord_saddress);
		$smarty->assign('ord_semail',$ord_semail);
		$smarty->assign('ord_sphone',$ord_sphone);
		$smarty->assign('ord_smobile',$ord_smobile);
		$smarty->assign('ord_sfax',$ord_sfax);
		$smarty->assign('ord_sotherinfo',$ord_sotherinfo);		
		
		$smarty->assign('ord_delivery',$ord_delivery);
		$smarty->assign('timeOder',$timeOder);
		$smarty->assign('date',$date);
		$smarty->assign('ord_payment',$ord_payment);
			
		$content= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketSendMail.tpl');
		
		sendMail(getSession("email"),getSession("site_name"),$ord_semail,$ord_sname,$lable->_("Information basket"),$content,$fileAttachment="");		
		sendMail($ord_semail,getSession("site_name"),getSession("email"),$ord_sname,$lable->_("Information basket"),$content,$fileAttachment="");
		
		session_unregister("basket");
		include_once("header.php");	
		//echo $content;	
		echo "<div style=\"padding-top:100px; padding-bottom:130px; padding-left:40px; padding-right:40px; text-align:justify; font-weight:bold\">Cảm ơn quý khách đã đặt hàng tại Quadacbiet.com. <p>Vui lòng kiểm tra mail để xem thông tin thanh toán đơn hàng và thực hiện việc thanh toán.<p> Sau khi nhận được thanh toán đơn hàng từ quý khách chúng tôi sẽ xử lý và vận chuyển đơn hàng.</div>";		
		include_once("footer.php");
		//header("Location: ?");
		//$ret_page="?";
		//$a=new msgBox($lable->_("Please check mail see information order"),"OKOnly", "Message", array($ret_page), 5);			
		//$a->showMsg();
	}
	//
	function view_detail_order(){
			global $smarty,$lable,$smarty,$db;
			$count_basket=count($_SESSION["basket"]);
			///
			$arr=$_SESSION["basket"];
			print_r($arr);
				if(!$arr)return;		
				foreach ($arr as $key=>$value){
					if($key>0) $product.="'$key',";			
				}
				$product=substr($product, 0, strlen($product)-1);
				if(!$product){
					//echo $lable->_("Cannot find product in basket");
					return;
				}
				
				$sql="SELECT sys_product.id, sys_product.name, sys_product.price, sys_product.catID, sys_product.img, sys_function.". getSession("rewrite_url"). " as url";
				$sql.=" FROM sys_product, sys_function";
				$sql.=" WHERE sys_product.id IN($product) AND (sys_product.catID=sys_function.id)";
				
				$rs=$db->Execute($sql);
				
				if(!$rs->RecordCount()){
					//echo box("Error!!",$lable->_("Cannot find basket!"));	
					return;
				}
				
				while(!$rs->EOF){
					$key=$rs->fields("id");
					$arr_order[$key]["price"] = $arr[$key]["quantity"] * $rs->fields("price");
					$total=$total+$arr_order[$key]["price"];				
					$rs->MoveNext();
				}
			///
			
			if(!$count_basket) $str=$lable->_("No cart items");
			else $str=$count_basket. " ".$lable->_("Products in cart");
			
			$smarty->assign('str',$str);
			$smarty->assign('total',$total);
			$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/basket_count.tpl");
			echo "duong";
			echo $output;
	}
?>