<?php
	include_once("include/common.php");
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");	
	$op=getParam("op");
	switch ($op){
		case "logout"	: 	logout();break;
		case "lang"		: 	setLanguage();break;
		default			: 	login(); break;
		
	}
	//
	function setLanguage(){
		$lang=getParam("lang");		
		setLang($lang);
		//$retPage=getParam("retPage");		
		//header("Location: "._DOMAIN_ROOT_URL."/admin80/?".$retPage);
		$ret_page="index.php";
		$a=new msgBox("Pleate wait...","OKOnly", "Message", array($ret_page), 1);
		$a->showMsg();
	}
	//
	function login(){
		global $db;
		if(getParamPost("PHPSESSID")<>$GLOBALS["_COOKIE"]["PHPSESSID"])	header("Location: login.php"); 
		
		$uid=getSession("uid");
		
		if($uid){
			$ret_page="index.php";
			$a=new msgBox("Pleate wait...","OKOnly", "Message", array($ret_page), 1);
			$a->showMsg();
		}
		
		$email=getParamPost("email");
		$password=md5(getParamPost("pass"));
		//echo $password;
		if($email and $password){
			$sql="SELECT * FROM sys_member WHERE (email='$email') AND (password='$password') AND (ctrl&3)";
			//echo $sql;
			$rs=$db->Execute($sql);
			$arr=$rs->fields;		
			if($arr){
				setSession("uid",$arr["id"]);
				setSession("fistName",$arr["fistname"]);
				setSession("permitID",$arr["permit"]);
                $_SESSION['isLoggedIn'] = true;
				$sql="UPDATE sys_member SET num=num+1 WHERE (email='$email') AND (password='$password')";
				$db->Execute($sql);
				$ret_page="index.php";
				$a=new msgBox("Pleate wait...","OKOnly", "Message", array($ret_page), 1);
				$a->showMsg();
			}else{
				$ret_page="login.php";
				$a=new msgBox("login false!","OKOnly", "Message", array($ret_page), 1);
				$a->showMsg();
			}
		}else{		
			$ret_page="login.php";
			$a=new msgBox("login false!","OKOnly", "Message", array($ret_page), 1); 
			$a->showMsg();
		}
	}
	//
	function logout(){
		setSession("uid","");
		setSession("fistName","");
        unset($_SESSION['isLoggedIn']);
		$ret_page="login.php";
		$a=new msgBox("Pleate wait...","OKOnly", "Message", array($ret_page), 1); 
		$a->showMsg();
	}
?>