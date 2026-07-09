<?php
class convertStringContent{	
	function remoteDiacriticContent($str){
		$arr=array("'");
		$str=str_replace($arr, "\'", $str);
		return $str;
	} 	
}	
?>