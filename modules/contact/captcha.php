<?php
	global $db, $lable;
	$txtCaptcha=getParam("img");	
	/*
	This is the back-end PHP file for the How to Create CAPTCHA Protection using PHP and AJAX Tutorial
	
	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.WebCheatSheet.com
	
	Copyright 2006 WebCheatSheet.com	
	*/
	
	//Continue the session
	session_start();
	
	//Make sure that the input come from a posted form. Otherwise quit immediately
	//Check if the securidy code and the session value are not blank 
	//and if the input text matches the stored text
	if ( ($txtCaptcha == $_SESSION["security_code"]) && 
		(!empty($txtCaptcha) && !empty($_SESSION["security_code"])) ) { 
		 echo '<input type="hidden" name="checkMail" id="checkMail" value="0" />';
	} else {
		
		 echo '<input type="hidden" name="checkMail" id="checkMail" value="1" />Captcha failed! Try again!';
	}
?>