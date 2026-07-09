<?php

	include_once(_DOMAIN_ROOT_PATH . "/admin80/include/configSystem.php");
	function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	function checkUnique($field, $compared)
	{
		$query = mysql_query("SELECT `email` FROM `subscribers` WHERE `email` = '".$compared."'");
		if(mysql_num_rows($query)==0)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function random_string($type = 'alnum', $len = 8)
	{
		switch($type)
		{
			case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:

					switch ($type)
					{
						case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
						case 'numeric'	:	$pool = '0123456789';
							break;
						case 'nozero'	:	$pool = '123456789';
							break;
					}

					$str = '';
					for ($i=0; $i < $len; $i++)
					{
						$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
					}
					return $str;
			  break;
			case 'unique' : return md5(uniqid(mt_rand()));
			  break;
		}
	}

	function numeric($str)
	{
		return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
	}

	function alpha_numeric($str)
	{
		return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}

?>