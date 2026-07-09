<?php
/**
 * quaun ly ngon ngu
 * de su dung lop nay can khai bao theo cac buoc sau:
 * loadClass("language");
 * $lable=new language
 * $lable->_("ten nhan") 
 *
 */
class language{
	function language($module){				
		$lang=getLang();
		//echo $lang;
		include("language/$lang/global.php");
		$path = "language/$lang/$module.dll";
		//echo $path;
		ob_start();
		@readfile("language/$lang/global.dll");
		eval( '$GLOBALS[\'translate\']=array('.ob_get_contents()."\n'0');" );
		@readfile($path);
		eval( '$GLOBALS[\'translate\']=array('.ob_get_contents()."\n'0');" );
		ob_end_clean();
		//echo $GLOBALS["_COOKIE"]["PHPSESSID"];
		//print_r($GLOBALS);
	}	
	function _($key){
		if(@array_key_exists($key, @$GLOBALS['translate']))	
		$str=@$GLOBALS['translate'][$key];
		else $str=$key;
		return $str;
	}	
}
?>