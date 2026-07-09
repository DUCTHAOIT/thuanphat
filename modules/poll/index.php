<?php
 //----------NEWS INDEX.PHP ----------------------------
 	include "include/common_action.php";
 	include "modules/poll/lib.php";
 	
	$current_file = urlencode("modules.php?module=poll");

	$op = get_param("op");
	switch ($op) {
		case "result": View_active_result(); break;
		case "vote": Vote(); break;
		case "main": Main_show(); break;
		default: View_active_poll();	
		
	}
	
	

function View_active_result()
{ 	include "header.php";

	$db = get_condb();
	$poll_id = (get_param("poll"))?get_param("poll"): get_config("poll");
	View_result($poll_id);
	include "footer.php";
}

function View_active_poll()
{
	$poll_id = get_config("poll");
	
	include("header.php");
	
	View_poll($poll_id);
	
	include("footer.php");
	
}	

?>