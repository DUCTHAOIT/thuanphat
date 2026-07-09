<?php
	switch ($op){		
		case "add_basket"		: 	$output=add_basket(); break;
		case "edit_basket"		: 	edit_basket(); break;
		case "delete_basket"	: 	delete_basket(); break;
		case "register_basket"	: 	$output = register_basket(); break;
		case "deliveryInformation": $output=deliveryInformation();break;
		case "checkout_shipping"	: checkout_shipping();break;
		case "payment_information"	: $output= payment_information();break;
		case "checkout_confirmation": $output=checkout_confirmation();break;		
		default 				:	$output=productListCategory(); break;
	}
	
	include_once("header.php");		
	$smarty->assign("content",$output);	
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/basket.tpl','basket_'.$themeName);		
	include_once("footer.php");	
			
	//
	function add_basket(){		
		global $smarty,$themeName,$lang,$lable;
		
		$product_id=getParam("product_id");
		$txt_add_basket=getParam("txt_add_basket");
		if($product_id){
			if (!$_SESSION["basket"]){
				session_register("basket");
				$_SESSION["basket"] = array();
			}
	
			if($_SESSION["basket"][$product_id]){
				$_SESSION["basket"][$product_id]["quantity"]=$_SESSION["basket"][$product_id]["quantity"] + $txt_add_basket;
			}else{	
				$_SESSION["basket"][$product_id]=array(				
					"quantity"=>(int)$txt_add_basket				
				);
			}
		}
		//print_r(getProductBasket());
		$smarty->assign('arrProductBasket',getProductBasket());
		$smarty->assign('themeName',$themeName);
		$smarty->assign('lang',$lang);
		$smarty->assign("Product_name",$lable->_("Product name"));
		$smarty->assign("Price",$lable->_("Price"));
		$smarty->assign("Quantity",$lable->_("Quantity"));

		$smarty->registerPlugin("function",'format_number','format_number');		
		$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketList.tpl');
		return $output;	
	}	
	//
	function deliveryInformation(){		
		global $smarty,$lable,$themeName;
		if(!getSession("guestID")) header("Location: ?m=basket&op=register_basket");
		
		include_once("action/guest.php");
		$arrInfoGuest=guestID(getSession("guestID"));
		
		$smarty->assign("arrInfoGuest",$arrInfoGuest);
		$smarty->assign("themeName",$themeName);
		$smarty->assign("arr",get_shipping_method());
		
		$smarty->assign("shipping",getSession("shipping"));
		$smarty->assign("comments",getSession("comments"));
		
		$smarty->assign("Step",$lable->_("Step"));
		$smarty->assign("Delivery_information",$lable->_("Delivery information"));
		$smarty->assign("Shipping_information",$lable->_("Shipping information"));
		$smarty->assign("Shipping_method",$lable->_("Shipping method"));
		$smarty->assign("Please_select_shipping_method",$lable->_("Please select the preferred shipping method to use on this order."));
		$smarty->assign("Comments_your_order",$lable->_("Special Instructions or Comments About Your Order"));
		$smarty->assign("Continue_to_Step_2",$lable->_("Continue to Step 2"));	
		
		$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketDeliveryInformation.tpl');
		return $output;	
	}
	//
	function payment_information(){
		if(!getSession("guestID")) header("Location: ?m=basket&op=register_basket");
		global $smarty,$lable,$themeName;
		include_once("action/guest.php");
		//thong tin khach hangf
		$arrInfoGuest=guestID(getSession("guestID"));
		//Tinh gia thanh gio hang
		$arrBasket=getProductBasket();
		foreach($arrBasket as $key=>$value){
			$price=$price + $value["price"];
		}
		//thong tin phuong thuc thanh toan
		$methosInfo=get_shipping_method_id(getSession("shipping"));
		
		$smarty->assign("arrInfoGuest",$arrInfoGuest);
		$smarty->assign("methosInfo",$methosInfo);
		$smarty->assign("price",$price);
		$smarty->assign("comments",getSession("comments"));
		$smarty->assign("themeName",$themeName);
		
		$smarty->assign("Step",$lable->_("Step"));
		$smarty->assign("Payment_information",$lable->_("Payment information"));
		$smarty->assign("Billing_address",$lable->_("Billing address"));
		$smarty->assign("Your_total",$lable->_("Your total"));
		$smarty->assign("Sub_total",$lable->_("Sub total"));
		$smarty->assign("Total",$lable->_("Total"));
		$smarty->assign("Discount_coupon",$lable->_("Discount coupon"));
		$smarty->assign("Please_type_your_coupon_code",$lable->_("Please type your coupon code into the box next to Redemption Code. Your coupon will be applied to the total and reflected in your cart after you click continue."));
		$smarty->assign("Redemption_code",$lable->_("Redemption Code"));
		$smarty->assign("Payment_method",$lable->_("Payment method"));
		$smarty->assign("Please_select_payment_method",$lable->_("Please select a payment method for this order."));
		$smarty->assign("Credit_card",$lable->_("Credit card"));
		$smarty->assign("Card_Owner_Name",$lable->_("Card Owner's Name"));
		$smarty->assign("Card_Number",$lable->_("Card Number"));
		$smarty->assign("Expiration_Date",$lable->_("Expiration Date"));
		$smarty->assign("Comments_your_order",$lable->_("Special Instructions or Comments About Your Order"));
		$smarty->assign("Thanks_for_shopping",$lable->_("Thanks for shopping with us online! Please check mail see detail order"));
		$smarty->assign("Check_Money_Order",$lable->_("Check/Money Order"));		
		
		$smarty->registerPlugin("function",'format_number','format_number');
		$output = $smarty->fetch(_DOMAIN_ROOT_TEMPLATE.'/basketPaymentInformation.tpl');
		return $output;	
	}
?>